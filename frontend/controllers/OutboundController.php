<?php

namespace frontend\controllers;

use common\helpers\Variables;
use common\models\HostUniversityCources;
use common\models\LocalUniversityCources;
use common\models\Outbound;
use common\models\State;
use DirectoryIterator;
use Exception;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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
                            'roles' => ['outbound'],
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
        $model = Outbound::findOne(Yii::$app->user->id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('You do not have any records yet');
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
                'pageSize' => 10,
            ],
        ]);
        $hostDataProvider = new ArrayDataProvider([
            'allModels' => $hostCourses,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $folderPath = Yii::getAlias('@common/uploads/outbound_application_' .$model->id. '/gallery');
        $files = [];
        if (is_dir($folderPath)) {
            $dir = new DirectoryIterator($folderPath);
            foreach ($dir as $fileinfo) {
                if ($fileinfo->isFile() && in_array($fileinfo->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi'])) {
                    $files[] = 'outbound_application_' .$model->id.'/gallery/'.$fileinfo->getFilename();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'localDataProvider' => $localDataProvider,
            'hostDataProvider' => $hostDataProvider,
            'files' => $files,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new outbound model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'wizard';

        $model = new Outbound();
        $localUniversityCources = [new LocalUniversityCources()];
        $hostUniversityCources = [new HostUniversityCources()];

        // Check if the user already has an existing outbound record
        $existingModel = Outbound::findOne(['id' => Yii::$app->user->id]);
        if ($existingModel !== null) {
            Yii::$app->session->setFlash('sweetAlertError', true);
            return $this->redirect(['outbound/index']);
        }

        if ($this->request->isPost) {
            // Load main model attributes and scenario
            $model->load($this->request->post());
            if ($this->request->post('creating')) {
                $model->scenario = 'creating';
            }

            // Handle file uploads for the main model
            $fileAttributes = [
                'f_academic_transcript', 'f_program_brochure', 'f_latest_payslip',
                'f_other_latest_payslip', 'f_offer_letter'
            ];
            foreach ($fileAttributes as $attribute) {
                $model->$attribute = UploadedFile::getInstance($model, $attribute);
            }

            // Handle courses data
            $localCoursesData = Yii::$app->request->post('LocalUniversityCources', []);
            $hostCoursesData = Yii::$app->request->post('HostUniversityCources', []);
            $localUniversityCources = [];
            $hostUniversityCources = [];

            foreach ($localCoursesData as $index => $localData) {
                $modelLocalCourse = new LocalUniversityCources();
                $modelLocalCourse->load($localData, '');
                $localUniversityCources[] = $modelLocalCourse;
            }
            foreach ($hostCoursesData as $index => $hostData) {
                $modelHostCourse = new HostUniversityCources();
                $modelHostCourse->load($hostData, '');
                $hostUniversityCources[] = $modelHostCourse;
            }

            if($model->english_proficiency != 'Other'){
                $model->third_language = null;
            }
//            if($model->mobility_program === 'Other'){
//                $model->mobility_program = $model->mobility_program_other;
//            }
//            if($model->host_scholarship === 'No'){
//                $model->host_scholarship_amount = null;
//            }

            // Set user ID for new record
            $model->id = Yii::$app->user->id;

            // Determine status based on button clicked
            if ($this->request->post('saving')) {
                $model->status = null;
            } else if ($this->request->post('creating')) {
                $model->status = Variables::application_init;
                $model->created_at = date('Y-m-d H:i:s');
            }

            $model->uploadFiles(Yii::$app->user->id);
            $valid = Model::validateMultiple($localUniversityCources) && Model::validateMultiple($hostUniversityCources) && $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    // Save main model
                    if ($model->save(false)) {
                        foreach ($localUniversityCources as $modelLocalCourse) {
                            $modelLocalCourse->application_id = $model->id;
                            if (!$modelLocalCourse->save(false)) {
                                $transaction->rollBack();
                                Yii::error('Local Course not saved: ' . json_encode($modelLocalCourse->errors));
                                return $this->render('create', [
                                    'model' => $model,
                                    'modelsLocalCourses' => $localUniversityCources,
                                    'modelsHostCourses' => $hostUniversityCources,
                                ]);
                            }
                        }
                        foreach ($hostUniversityCources as $modelHostCourse) {
                            $modelHostCourse->application_id = $model->id;
                            if (!$modelHostCourse->save(false)) {
                                $transaction->rollBack();
                                Yii::error('Host Course not saved: ' . json_encode($modelHostCourse->errors));
                                return $this->render('create', [
                                    'model' => $model,
                                    'modelsLocalCourses' => $localUniversityCources,
                                    'modelsHostCourses' => $hostUniversityCources,
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
                Yii::error('Validation failed: ' . json_encode($model->errors) . ' ' . json_encode($localUniversityCources) . ' ' . json_encode($hostUniversityCources));
            }
        }

        // Render the creation form with the model and courses data
        return $this->render('create', [
            'model' => $model,
            'modelsLocalCourses' => (empty($localUniversityCources)) ? [new LocalUniversityCources()] : $localUniversityCources,
            'modelsHostCourses' => (empty($hostUniversityCources)) ? [new HostUniversityCources()] : $hostUniversityCources
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

        if ($model->status !== 3 && $model->status !== null) {
            Yii::$app->session->setFlash('sweetAlertError', true);
            return $this->redirect(['outbound/index']);
        }

        // Check if the record exists
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

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

            // Handle save/update based on button clicked
            if ($this->request->post('saving')) {
                $model->status = null;
            } else if ($this->request->post('creating')) {
                $model->scenario = 'creating';
                $model->status = Variables::application_init;
                $model->created_at = date('Y-m-d H:i:s');
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
    public function actionUpload($id){

        $model = $this->findModel($id);

        $model->scenario = 'uploader';
        if ($this->request->isPost && $model->load($this->request->post())) {



            if(in_array($model->status,[
                Variables::application_files_not_complete,
                Variables::redirected_to_student_UPLOAD_files
            ])){
                $model->status = Variables::application_files_uploaded;
                $model->uploadFiles(Yii::$app->user->id);
            }elseif ($model->status == Variables::application_reminder_sent){
                $model->status = Variables::application_files_uploaded_final;
                $model->uploadMultipleFiles(Yii::$app->user->id);
            }

            if ($model->save()) {
                return $this->redirect(['index']);
            }

        }
        return $this->renderAjax('upload', [
            'model' => $model,
        ]);
    }

    public function actionDownloader($filePath)
    {
        $uploadPath = Yii::getAlias('@common/uploads/outbound_application_') . Yii::$app->user->id . '/';
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
        $uploadPath = Yii::getAlias('@common/uploads/outbound_application_') . Yii::$app->user->id . '/';
        $fullPath = $uploadPath . $filePath;

        if (file_exists($fullPath)) {
            Yii::$app->response->sendFile($fullPath);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }
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

    public function actionGetStates($country)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $states = State::find()
            ->where(['country_id' => $country])
            ->all();
        return ArrayHelper::map($states, 'name', 'name');
    }
}
