<?php

namespace backend\controllers;

use common\helpers\Variables;
use common\models\EmailTemplates;
use common\models\Inbound;
use common\models\InboundHostUniversityCourses;
use common\models\Kcdio;
use common\models\Pic;
use common\models\search\InboundSearch;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * InboundController implements the CRUD actions for Inbound model.
 */
class InboundController extends Controller
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
     * Lists all Inbound models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InboundSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inbound model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Inbound::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('No record Found');
        }

        $courses = InboundHostUniversityCourses::find()
            ->with('application')
            ->where(['application_id' => $model->id])
            ->asArray()
            ->all();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $courses,
            'pagination' => [
                'pageSize' => 10, // Adjust the page size if needed
            ],
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Creates a new Inbound model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Inbound();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Inbound model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'wizard';

        // Find the existing record to update
        $model = Inbound::findOne(['id' => $id]);


        // Check if the record exists
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // Load related models (if any)
        $modelsCourses = InboundHostUniversityCourses::find()->where(['application_id' => $id])->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $coursesData = Yii::$app->request->post('InboundHostUniversityCourses', []);
            $modelsCourses = [];

            foreach ($coursesData as $index => $data) {
                if (isset($data['id'])) {
                    // Existing course, load and update
                    $modelCourse = InboundHostUniversityCourses::findOne($data['id']);
                } else {
                    // New course, create a new model instance
                    $modelCourse = new InboundHostUniversityCourses();
                }
                $modelCourse->load($data, '');
                $modelsCourses[] = $modelCourse;
            }

            // Set application ID for new courses
            foreach ($modelsCourses as $modelCourse) {
                $modelCourse->application_id = $model->id;
            }

            // Handle save/update based on button clicked
            if ($this->request->post('saving')) {
                $model->status = null;
            } else if ($this->request->post('creating')) {
                $model->scenario = 'creating';
                $model->status = Variables::application_init;
            }

            if($model->language_english_test_name == 'Other'){
                $model->language_english_test_name = $model->language_english_test_name_other;
            }
            if($model->financial_funding == 'Other'){
                $model->financial_funding = $model->financial_funding_other;
            }
            if($model->propose_program_type == 'Other'){
                $model->propose_program_type = $model->propose_program_type_other;
            }


            // Upload files and validate
            $model->uploadFiles(Yii::$app->user->id);
            $valid = Model::validateMultiple($modelsCourses) && $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($model->save()) {
                        // Delete removed courses
                        $existingCourseIds = array_map(function ($modelCourse) {
                            return $modelCourse->id;
                        }, $modelsCourses);

                        InboundHostUniversityCourses::deleteAll(['and', ['not in', 'id', $existingCourseIds], ['application_id' => $model->id]]);

                        // Save/update courses
                        foreach ($modelsCourses as $modelCourse) {
                            if (!$modelCourse->save(false)) {
                                $transaction->rollBack();
                                Yii::error('Course not saved: ' . json_encode($modelCourse->errors));
                                return $this->render('update', [
                                    'model' => $model,
                                    'modelsCourses' => $modelsCourses,
                                ]);
                            }
                        }

                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Transaction failed: ' . $e->getMessage());
                }
            } else {
                Yii::error('Validation failed: ' . json_encode($model->errors) . ' ' . json_encode($modelsCourses));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsCourses' => (empty($modelsCourses)) ? [new InboundHostUniversityCourses()] : $modelsCourses
        ]);
    }

    /**
     * Deletes an existing Inbound model.
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

    public function actionAction($id)
    {
        try {
            $modelKedio = Kcdio::find()->all();
            $model = $this->findModel($id);
            $model->scenario = 'actioner';

            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->temp = "(" . Yii::$app->user->identity->type . ") " . "(" . Yii::$app->user->identity->email . ") " . Yii::$app->user->identity->username;

                // Setting token
                if (in_array($model->status, [Variables::application_redirected_kcdio_inbound, Variables::application_redirected_amad_inbound, Variables::application_resubmitted_to_kcdio_inbound])) {
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

    /**
     * Finds the Inbound model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Inbound the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inbound::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function sendEmail($model){

        $emailTemplateMap = [
            Variables::application_redirected_kcdio_inbound => Variables::requestHodSignatureOutBound,
            Variables::application_resubmitted_to_kcdio_inbound => Variables::requestHodSignatureOutBound,
            Variables::application_redirected_amad_inbound => Variables::requestDeanSignatureOutBound,
            Variables::application_rejected_inbound => Variables::rejectedApplicationOutBound,
            Variables::application_redirected_upload_inbound => Variables::requestUploadDocsOutBound,
            Variables::application_files_not_complete_inbound => Variables::uploadedFilesNotComplete,
            Variables::application_accepted_inbound => Variables::applicationActive,
        ];

        $userMap = [
            Variables::application_redirected_kcdio_inbound => $model->kulliyyah_id,
            Variables::application_resubmitted_to_kcdio_inbound => $model->kulliyyah_id,
            Variables::application_redirected_amad_inbound => $model->cps_id,
        ];

        $template = EmailTemplates::findOne($emailTemplateMap[$model->status]);

        $body = $template->body;

        $body = str_replace('{reason}', $model->reason, $body);
        $body = str_replace('{applicant}', $model->name, $body);


        if(
            !in_array($model->status,
                [
                    Variables::application_rejected,
                    Variables::redirected_to_student_UPLOAD_files,
                    Variables::application_files_not_complete,
                    Variables::application_accepted,
                ]
            )
        ){
            $user = Pic::findOne($userMap[$model->status]);
            $link =  Yii::$app->urlManager->createAbsoluteUrl(['workflowi/index', 'id' => $model->id, 'token' => $model->token]);

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
        $uploadPath = Yii::getAlias('@common/uploads/inbound_application_') . Yii::$app->user->id . '/';
        $fullPath = $uploadPath . $filePath;

        if (!file_exists($fullPath)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'message' => 'File not found or corrupted.'];
        } else {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
    }

    public function actionDownload($filePath)
    {
        $uploadPath = Yii::getAlias('@common/uploads/inbound_application_') . Yii::$app->user->id . '/';
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
        try {
            $dataProvider = new ActiveDataProvider([
                'query' => Inbound::find()->where([
                    'and', [
                        'or', ['EXTRACT(YEAR FROM "propose_duration_start")' => $year],
                        ['EXTRACT(YEAR FROM "propose_duration_end")' => $year],
                    ], ['not', ['status' => 6]]
                ]), 'pagination' => false,
            ]);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('B1', 'Internationalisation of Academic Program: (Inbound)')
                ->getStyle('B1')->getFont()->setBold(true);

            // Set column headers
            $sheet->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Student Name')
                ->setCellValue('C3', 'Program')
                ->setCellValue('D3', 'Type of Programme')
                ->setCellValue('E3', 'Name of Outbound University')
                ->setCellValue('F3', 'Country')
                ->setCellValue('G3', 'From')
                ->setCellValue('H3', 'To')
                ->setCellValue('I3', 'K/C/D/I/O');

            for ($col = 'A'; $col !== 'K'; $col++) {
                $sheet->getStyle($col.'3')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension('3')->setRowHeight(33);
                $sheet->getStyle($col.'3')->getAlignment()->setWrapText(true);

                switch ($col) {
                    case 'A': $sheet->getColumnDimension($col)->setWidth(5); break;
                    case 'B': $sheet->getColumnDimension($col)->setWidth(50); break;
                    case 'C': $sheet->getColumnDimension($col)->setWidth(35); break;
                    case 'D': $sheet->getColumnDimension($col)->setWidth(13); break;
                    case 'E': $sheet->getColumnDimension($col)->setWidth(50); break;
                    case 'F': $sheet->getColumnDimension($col)->setWidth(17); break;
                    case 'G': $sheet->getColumnDimension($col)->setWidth(15); break;
                    case 'H': $sheet->getColumnDimension($col)->setWidth(15); break;
                    case 'I': $sheet->getColumnDimension($col)->setWidth(12); break;
                }
            }

            $row = 4;
            foreach ($dataProvider->getModels() as $model) {
                $sheet->setCellValue('A'.$row, $row - 3)
                    ->setCellValue('B'.$row, $model->name)
                    ->setCellValue('C'.$row, $model->propose_mobility_type)
                    ->setCellValue('D'.$row, $model->propose_transform_credit_hours)
                    ->setCellValue('E'.$row, $model->academic_home_university)
                    ->setCellValue('F'.$row, $model->country_of_origin)
                    ->setCellValue('G'.$row, $model->propose_duration_start)
                    ->setCellValue('H'.$row, $model->propose_duration_end)
                    ->setCellValue('I'.$row, $model->propose_kulliyyah_applied);

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
                'query' => Inbound::find()->select([
                    'Country_of_origin AS country', 'COUNT(*) AS count'
                ])->groupBy('country'), 'pagination' => false,
            ]);

            $countryCounts = [];
            foreach ($dataProvider->getModels() as $model) {
                $country = $model['country_of_origin'];
                $countryCounts[$country] = isset($countryCounts[$country]) ? $countryCounts[$country] + 1 : 1;
            }

            foreach ($countryCounts as $country => $count) {
                $sheet->setCellValue('B'.$row, $country)
                    ->setCellValue('C'.$row, $count);
                $row++;
            }

            $sheet->setCellValue('B'.$row, 'Total')
                ->setCellValue('C'.$row, array_sum($countryCounts));


            $writer = new Xlsx($spreadsheet);
            $filePath = Yii::getAlias('@runtime').'/Inbound_Export_'.date('YmdHis').'.xlsx';

            $writer->save($filePath);

            if (file_exists($filePath)) {
                Yii::$app->response->sendFile($filePath, 'Inbound_Export_'.date('YmdHis').'.xlsx')->send();
                unlink($filePath); // Clean up after sending
            } else {
                throw new \Exception("File not found: " . $filePath);
            }

        } catch (\Exception $e) {
            Yii::error("Error exporting Excel: " . $e->getMessage(), __METHOD__);
            throw $e;
        }
    }

}
