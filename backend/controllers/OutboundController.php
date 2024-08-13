<?php

namespace backend\controllers;

use common\helpers\Variables;
use common\models\EmailTemplates;
use common\models\HostUniversityCources;
use common\models\Kcdio;
use common\models\LocalUniversityCources;
use common\models\Outbound;
use common\models\OutboundLog;
use common\models\Pic;
use common\models\search\OutboundSearch;
use DirectoryIterator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * OutboundController implements the CRUD actions for outbound model.
 */
class OutboundController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'], // Admins can access all actions
                        ],
                        [
                            'allow' => true,
                            'roles' => ['staff'],
                            'actions' => ['index', 'view', 'action', 'serve-file', 'export-excel'],
                        ],
                        [
                            'allow' => false, // Deny access by default
                        ],
                    ],
                ],
            ]
        );
    }
    /**
     * Lists all outbound models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OutboundSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionServeFile($filename)
    {
        $filePath = Yii::getAlias('@common/uploads/') . $filename;

        if (file_exists($filePath)) {
            // Get the file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            // Set the appropriate MIME type
            $mimeType = '';
            switch (strtolower($extension)) {
                case 'jpg':
                case 'jpeg':
                    $mimeType = 'image/jpeg';
                    break;
                case 'png':
                    $mimeType = 'image/png';
                    break;
                case 'gif':
                    $mimeType = 'image/gif';
                    break;
                case 'mp4':
                    $mimeType = 'video/mp4';
                    break;
                case 'avi':
                    $mimeType = 'video/x-msvideo';
                    break;
                default:
                    $mimeType = 'application/octet-stream';
                    break;
            }

            // Send the file with the correct MIME type
            return Yii::$app->response->sendFile($filePath, $filename, ['mimeType' => $mimeType, 'inline' => true]);
        } else {
            throw new \yii\web\NotFoundHttpException('File not found');
        }
    }

    /**
     * Displays a single outbound model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Outbound::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('No record Found   ');
        }

        $hostCourses = HostUniversityCources::find()
            ->with('application')
            ->where(['application_id' => $model->id])
            ->asArray()
            ->all();
        $localCourses = LocalUniversityCources::find()
            ->with('application')
            ->where(['application_id' => $model->id])
            ->asArray()
            ->all();
        $localDataProvider = new ArrayDataProvider([
            'allModels' => $localCourses,
            'pagination' => [
                'pageSize' => 10, // Adjust the page size if needed
            ],
        ]);
        $hostDataProvider = new ArrayDataProvider([
            'allModels' => $hostCourses,
            'pagination' => [
                'pageSize' => 10, // Adjust the page size if needed
            ],
        ]);

        $folderPath = Yii::getAlias('@common/uploads/outbound_application_' .$id. '/gallery');
        $files = [];
        if (is_dir($folderPath)) {
            $dir = new DirectoryIterator($folderPath);
            foreach ($dir as $fileinfo) {
                if ($fileinfo->isFile() && in_array($fileinfo->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi'])) {
                    $files[] = 'outbound_application_' .$model->id.'/gallery/'.$fileinfo->getFilename();
                }
            }
        }
        return $this->render('view', [
            'model' => $model,
            'localDataProvider' => $localDataProvider,
            'hostDataProvider' => $hostDataProvider,
                'files' => $files,
        ]);
    }

    /**
     * Updates an existing outbound model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'wizard';

        // Find the existing record to update
        $model = Outbound::findOne(['id' => $id]);



        // Load related models (if any)
        $localUniversityCources = LocalUniversityCources::find()->where(['application_id' => $id])->all();
        $hostUniversityCources = HostUniversityCources::find()->where(['application_id' => $id])->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $localCoursesData = Yii::$app->request->post('LocalUniversityCources', []);
            $hostCoursesData = Yii::$app->request->post('HostUniversityCources', []);
            $localUniversityCources = [];
            $hostUniversityCources = [];


            $fileAttributes = [
                'f_offer_letter_file', 'f_academic_transcript_file', 'f_program_brochure_file',
                'f_latest_payslip_file'
            ];
            foreach ($fileAttributes as $attribute) {
                $model->$attribute = UploadedFile::getInstance($model, $attribute);
            }

            // Handle Local University Courses
            foreach ($localCoursesData as $index => $localData) {
                if (isset($localData['id'])) {
                    // Existing course, load and update
                    $modelCourse = LocalUniversityCources::findOne($localData['id']);
                } else {
                    // New course, create a new model instance
                    $modelCourse = new LocalUniversityCources();
                }
                $modelCourse->load($localData, '');
                $localUniversityCources[] = $modelCourse;
            }

            // Handle Host University Courses
            foreach ($hostCoursesData as $index => $hostData) {
                if (isset($hostData['id'])) {
                    // Existing course, load and update
                    $modelHostCourse = HostUniversityCources::findOne($hostData['id']);
                } else {
                    // New course, create a new model instance
                    $modelHostCourse = new HostUniversityCources();
                }
                $modelHostCourse->load($hostData, '');
                $hostUniversityCources[] = $modelHostCourse;
            }

            // Set application ID for new courses
            foreach ($localUniversityCources as $modelCourse) {
                $modelCourse->application_id = $model->id;
            }
            foreach ($hostUniversityCources as $modelCourse) {
                $modelCourse->application_id = $model->id;
            }

            // Upload files and validate
            $model->uploadFiles(Yii::$app->user->id);
            $valid = Model::validateMultiple($localUniversityCources) && Model::validateMultiple($hostUniversityCources) && $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        // Delete removed courses
                        $existingLocalCourseIds = array_map(function ($modelCourse) {
                            return $modelCourse->id;
                        }, $localUniversityCources);
                        $existingHostCourseIds = array_map(function ($modelCourse) {
                            return $modelCourse->id;
                        }, $hostUniversityCources);

                        LocalUniversityCources::deleteAll(['and', ['application_id' => $model->id], ['not in', 'id', $existingLocalCourseIds]]);
                        HostUniversityCources::deleteAll(['and', ['application_id' => $model->id], ['not in', 'id', $existingHostCourseIds]]);

                        // Save/update courses
                        foreach ($localUniversityCources as $modelLocalCourse) {
                            if (!$modelLocalCourse->save(false)) {
                                $transaction->rollBack();
                                Yii::error('Local Course not saved: ' . json_encode($modelLocalCourse->errors));
                                return $this->render('update', [
                                    'model' => $model,
                                    'modelsLocalCourses' => $localUniversityCources,
                                    'modelsHostCourses' => $hostUniversityCources,
                                ]);
                            }
                        }
                        foreach ($hostUniversityCources as $modelHostCourse) {
                            if (!$modelHostCourse->save(false)) {
                                $transaction->rollBack();
                                Yii::error('Host Course not saved: ' . json_encode($modelHostCourse->errors));
                                return $this->render('update', [
                                    'model' => $model,
                                    'modelsLocalCourses' => $localUniversityCources,
                                    'modelsHostCourses' => $hostUniversityCources,
                                ]);
                            }
                        }

                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                    else {
                        // Error saving
                        Yii::error('Error saving model: ' . json_encode($model->errors));
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Transaction failed: ' . $e->getMessage());
                }
            } else {
                Yii::error('Validation failed: ' . json_encode($model->errors) . ' ' . json_encode($localUniversityCources) . ' ' . json_encode($hostUniversityCources));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsLocalCourses' => (empty($localUniversityCources)) ? [new LocalUniversityCources()] : $localUniversityCources,
            'modelsHostCourses' => (empty($hostUniversityCources)) ? [new HostUniversityCources()] : $hostUniversityCources
        ]);
    }

    public function actionAction($id)
    {
        try {
            $modelKedio = Kcdio::find()->all();
            $model = $this->findModel($id);
            $model->scenario = 'actioner';

            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->temp = "(" . Yii::$app->user->identity->type . ") " . "(" . Yii::$app->user->identity->email . ") " . Yii::$app->user->identity->username;

                // Setting token
                if (in_array($model->status, [Variables::redirected_to_hod, Variables::redirected_to_dean, Variables::application_resubmitted_to_hod])) {
                    $model->token = Yii::$app->security->generateRandomString(32);
                } else {
                    $model->token = null;
                }

                if ($model->save()) {
                    $this->sendEmail($model);
                    return $this->redirect(['index']);
                } else {
                    Yii::error('Failed to save model: ' . print_r($model->errors, true), __METHOD__);
                }
            }

            return $this->renderAjax("action", [
                "model" => $model,
                "modelKedio" => $modelKedio,
            ]);
        } catch (\Exception $e) {
            Yii::error('Exception occurred: ' . $e->getMessage(), __METHOD__);
            throw $e; // rethrow the exception if needed
        }
    }
    public function actionLog($id){
        $logsDataProvider = new ActiveDataProvider([
            'query' => OutboundLog::find()->where(['outbound_id' => $id]),
            'pagination' => ['pageSize' => 100,],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC], // Display logs by creation time in descending order
            ],]);

        $logModel = Outbound::findOne($id);

        return $this->renderAjax('log', [
            'logsDataProvider' => $logsDataProvider,
            'logModel' => $logModel
        ]);
    }

    public function sendEmail($model){

        $emailTemplateMap = [
            Variables::redirected_to_hod => Variables::requestHodSignatureOutBound,
            Variables::application_resubmitted_to_hod => Variables::requestHodSignatureOutBound,
            Variables::redirected_to_dean => Variables::requestDeanSignatureOutBound,
            Variables::application_rejected => Variables::rejectedApplicationOutBound,
            Variables::redirected_to_student_UPLOAD_files => Variables::requestUploadDocsOutBound,
            Variables::application_files_not_complete => Variables::uploadedFilesNotComplete,
            Variables::application_not_complete => Variables::incompleteApplicationOutBound,
            Variables::application_accepted => Variables::applicationActive,
        ];

        $userMap = [
            Variables::redirected_to_hod => $model->hod_id,
            Variables::application_resubmitted_to_hod => $model->hod_id,
            Variables::redirected_to_dean => $model->dean_id,
        ];

        $template = EmailTemplates::findOne($emailTemplateMap[$model->status]);

        $body = $template->body;

        $body = str_replace('{reason}', $model->reason, $body);
        $body = str_replace('{applicant}', $model->name, $body);


        if(
            !in_array($model->status,
                    [
                        Variables::application_not_complete,
                        Variables::application_rejected,
                        Variables::redirected_to_student_UPLOAD_files,
                        Variables::application_files_not_complete,
                        Variables::application_accepted,
                    ]
            )
        ){
            $user = Pic::findOne($userMap[$model->status]);
            $link =  Yii::$app->urlManager->createAbsoluteUrl(['workflowo/index', 'id' => $model->id, 'token' => $model->token]);

            $body = str_replace('{user}', $user->name, $body);
            $body = str_replace('{link}', $link, $body);
            $mailer = Yii::$app->mailer
                ->compose(['html' => '@backend/views/email/emailTemplate.php'],
                    [
                        'subject' => $template->subject,
                        'recipientName' => $user->name,
                        'reason' => $model->reason,
                        'applicant' => $model->name,
                        'link' => $link,
                        'body' => $body,
                    ])
                ->setFrom(['noReplay@iium.edy.my' => 'IIUM'])
                ->setTo($user->email)
                ->setSubject($template->subject);

            $ccEmails = [];
            if (!empty($user->{"email_cc_x"})) {
                $ccEmails[] = $user->{"email_cc_x"};
            }
            if (!empty($user->{"email_cc_xx"})) {
                $ccEmails[] = $user->{"email_cc_xx"};
            }
            if (!empty($ccEmails)) {
                $mailer->setCc($ccEmails);
            }
        }else{
            $mailer = Yii::$app->mailer
                ->compose(['html' => '@backend/views/email/emailTemplate.php'],
                    [
                        'subject' => $template->subject,
                        'reason' => $model->reason,
                        'applicant' => $model->name,
                        'body' => $body,
                    ])
                ->setFrom(['noReplay@iium.edy.my' => 'IIUM | Exchange Program'])
                ->setTo($model->email)
                ->setSubject($template->subject);
        }

        $mailer->send();

    }

    /**
     * Deletes an existing outbound model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the outbound model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Outbound the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Outbound::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetPic($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $pic = Pic::find()
            ->where(['kcdio_id' => $id])
            ->all();

        // Map the result to include both name and email in the format 'Name (Email)'
        $result = [];
        foreach ($pic as $p) {
            $result[$p->id] = $p->name . ' (' . $p->email . ')';
        }

        return $result;
    }

    public function actionDownloader($filePath, $id)
    {
        $uploadPath = Yii::getAlias('@common/uploads/outbound_application_') . $id . '/';
        $fullPath = $uploadPath . $filePath;

        if (!file_exists($fullPath)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'message' => 'File not found or corrupted.'];
        } else {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
    }

    public function actionDownload($filePath, $id)
    {
        $uploadPath = Yii::getAlias('@common/uploads/outbound_application_') . $id . '/';
        $fullPath = $uploadPath . $filePath;

        if (file_exists($fullPath)) {
            Yii::$app->response->sendFile($fullPath);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }
    }

    public function actionBulkDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $ids = Yii::$app->request->post('ids', []);
        if (empty($ids)) {
            return ['success' => false, 'message' => 'No items selected.'];
        }

        foreach ($ids as $id) {
            $model = $this->findModel($id);
            if ($model !== null) {
                // Delete associated files
                $folderPath = Yii::getAlias('@common/uploads/' . $id);
                if (is_dir($folderPath)) {
                    $this->deleteDirectory($folderPath);
                }

                // Delete the model
                $model->delete();
            }
        }

        return ['success' => true, 'message' => 'Selected items have been deleted.'];
    }

    public function actionExportExcel($year)
    {

        // Set up data provider with your query
        $dataProvider = new ActiveDataProvider([
            'query' => Outbound::find()->where([
                'and',
                ['or',
                    ['EXTRACT(YEAR FROM "mobility_from")' => $year],
                    ['EXTRACT(YEAR FROM "mobility_until")' => $year],
                ],
                ['not', ['status' => 2]]
            ]),
            'pagination' => false,
        ]);

        // Create a new PhpSpreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('B1',
            'Internationalisation of Academic Program: (Outbound)')->getStyle('B1')->getFont()->setBold(true);

        // Set column headers
        $sheet->setCellValue('A3', 'No')
            ->setCellValue('B3', 'Student Name')
            ->setCellValue('C3', 'Studnet ID')
            ->setCellValue('D3', 'Program')
            ->setCellValue('E3', 'Type of Programme')
            ->setCellValue('F3', 'Name of Outbound University')
            ->setCellValue('G3', 'Country')
            ->setCellValue('H3', 'From')
            ->setCellValue('I3', "To")
            ->setCellValue('J3', 'K/C/D/I/O');

        for ($col = 'A'; $col !== 'K'; $col++) {
            $sheet->getStyle($col.'3')->applyFromArray([
                'font' => [
                    'bold' => true,
                ], 'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getRowDimension('3')->setRowHeight(33);
            $sheet->getStyle($col.'3')->getAlignment()->setWrapText(true);

            switch ($col) {
                case 'A':
                    $sheet->getColumnDimension($col)->setWidth(5);
                    break;
                case 'B':
                    $sheet->getColumnDimension($col)->setWidth(50);
                    break;
                case 'C':
                    $sheet->getColumnDimension($col)->setWidth(9);
                    break;
                case 'D':
                    $sheet->getColumnDimension($col)->setWidth(35);
                    break;
                case 'E':
                    $sheet->getColumnDimension($col)->setWidth(13);
                    break;
                case 'F':
                    $sheet->getColumnDimension($col)->setWidth(50);
                    break;
                case 'G':
                    $sheet->getColumnDimension($col)->setWidth(17);
                    break;
                case 'H':
                    $sheet->getColumnDimension($col)->setWidth(15);
                    break;
                case 'I':
                    $sheet->getColumnDimension($col)->setWidth(15);
                    break;
                case 'J':
                    $sheet->getColumnDimension($col)->setWidth(12);
                    break;

            }
        }
        // Populate data
        $row = 4;
        foreach ($dataProvider->getModels() as $model) {
            $sheet
                ->setCellValue('A'.$row, $row - 3)
                ->setCellValue('B'.$row, $model->name)
                ->setCellValue('C'.$row, $model->matric_card)
                ->setCellValue('D'.$row, $model->mobility_type)
                ->setCellValue('E'.$row, $model->credit_transform_availability)
                ->setCellValue('F'.$row, $model->host_university_name)
                ->setCellValue('G'.$row, $model->host_university_country)
                ->setCellValue('H'.$row, $model->mobility_from)
                ->setCellValue('I'.$row, $model->mobility_until)
                ->setCellValue('J'.$row, $model->academic_kulliyyah);
            ;
            for ($col = 'A'; $col !== 'K'; $col++) {
                if ($col != 'B' || $row != 1) {
                    $style = $sheet->getStyle($col.$row);
                    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                }
            }
            $row++;
        }

        $row += 4;

        $dataCountry = new ActiveDataProvider([
            'query' => Outbound::find()->select([
                'host_university_country AS country', 'COUNT(*) AS count'
            ])->groupBy('country'), 'pagination' => false,
        ]);

        $countryCounts = [];

        foreach ($dataProvider->getModels() as $model) {
            $country =$model['host_university_country'];

            // Increment country count or initialize if not present
            $countryCounts[$country] = isset($countryCounts[$country]) ? $countryCounts[$country] + 1 : 1;
        }

        // Display country counts
        foreach ($countryCounts as $country => $count) {
            $sheet->setCellValue('B'.$row, $country)->setCellValue('C'.$row, $count);
            $row++;
        }

        // Display total
        $sheet->setCellValue('B'.$row, 'Total')->setCellValue('C'.$row, array_sum($countryCounts));


        // Create a writer
        $writer = new Xlsx($spreadsheet);

        // Set file path
        $filePath = Yii::getAlias('@runtime').'/Outbound_Export_'.date('YmdHis').'.xlsx';

        // Save the file
        $writer->save($filePath);

        // Provide download link
        Yii::$app->response->sendFile($filePath, 'Outbound_Export_'.date('YmdHis').'.xlsx')->send();
        unlink($filePath); // Optionally, you can delete the file after sending it


    }

}
