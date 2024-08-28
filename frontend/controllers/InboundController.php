<?php

namespace frontend\controllers;

use common\models\EmailTemplates;
use common\models\Inbound;
use common\models\InboundHostUniversityCourses;
use Exception;
use PharIo\Manifest\Email;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\Variables;
use yii\db\Expression;
use yii\filters\AccessControl;

use yii\web\ForbiddenHttpException;

use yii\web\Response;
use yii\web\UploadedFile;

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
                            'roles' => ['inbound'],
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
        $model = Inbound::findOne(Yii::$app->user->id);

        if ($model === null) {
            // Pass a flag to the view to indicate no record exists
            return $this->render('index', [
                'model' => null,
            ]);
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
        return $this->render('index', [
            'model' => $model,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inbound model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'wizard';

        $model = new Inbound();
        $mail = EmailTemplates::find()->where(['id' => Variables::newApplication])->one();
        $modelsCourses = [new InboundHostUniversityCourses()];

        // Check if the user already has an existing Inbound record
        $existingModel = Inbound::findOne(['id' => Yii::$app->user->id]);
        if ($existingModel !== null) {
            Yii::$app->session->setFlash('sweetAlertError', true);
            return $this->redirect(['inbound/index']);
        }

        if ($this->request->isPost) {
            // Load main model attributes and scenario
            $model->load($this->request->post());
            if ($this->request->post('creating')) {
                $model->scenario = 'creating';
            }

            // Handle file uploads for the main model
            $model->f_recommendation_letter = UploadedFile::getInstance($model, 'f_recommendation_letter');
            $model->f_passport = UploadedFile::getInstance($model, 'f_passport');
            $model->f_latest_passport_photo = UploadedFile::getInstance($model, 'f_latest_passport_photo');
            $model->f_latest_academic_transcript = UploadedFile::getInstance($model, 'f_latest_academic_transcript');
            $model->f_confirmation_letter = UploadedFile::getInstance($model, 'f_confirmation_letter');
            $model->f_sponsorship_letter = UploadedFile::getInstance($model, 'f_sponsorship_letter');

            // Handle courses data
            $coursesData = Yii::$app->request->post('InboundHostUniversityCourses', []);
            $modelsCourses = [];

            foreach ($coursesData as $index => $data) {
                $modelCourse = new InboundHostUniversityCourses();
                $modelCourse->load($data, '');
                $modelsCourses[] = $modelCourse;
            }

            // Set user ID for new record
            $model->id = Yii::$app->user->id;

            // Determine status based on button clicked
            if ($this->request->post('saving')) {
                $model->status = null;
            } else if ($this->request->post('creating')) {
                $model->status = Variables::application_init;
                $model->created_at = date('Y-m-d H:i:s');
            }
            $model->id = Yii::$app->user->id;
            $model->uploadFiles($model->id);

            $valid = Model::validateMultiple($modelsCourses) && $model->validate();

            if ($valid) {

                if($model->language_english_test_name == 'Other'){
                    $model->language_english_test_name = $model->language_english_test_name_other;
                }
                if($model->financial_funding == 'Other'){
                    $model->financial_funding = $model->financial_funding_other;
                }
                if($model->propose_program_type == 'Other'){
                    $model->propose_program_type = $model->propose_program_type_other;
                }

                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    // Save main model
                    if ($model->save()) { // Save without validation
                        if($model->status === Variables::application_init)

                        foreach ($modelsCourses as $modelCourse) {
                            $modelCourse->application_id = $model->id;
                            if (!$modelCourse->save(false)) { // Save without validation
                                $transaction->rollBack();
                                Yii::error('Course not saved: ' . json_encode($modelCourse->errors));
                                return $this->render('create', [
                                    'model' => $model,
                                    'modelsCourses' => $modelsCourses,
                                ]);
                            }
                        }

                        $transaction->commit();
                        if ($model->status == Variables::application_init){
                            Yii::$app
                                ->mailer
                                ->compose(['html' => '@backend/views/email/emailTemplate.php'], [
                                    'subject' => $mail->subject,
                                    'body' => $mail->body,
                                ])
                                ->setFrom(['noReply@iium.edy.my' => 'IIUM Mobility System'])
                                ->setTo(Variables::$ioEmail)
                                ->setSubject($mail->subject)
                                ->send();
                        }
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

        // Render the creation form with the model and courses data
        return $this->render('create', [
            'model' => $model,
            'modelsCourses' => (empty($modelsCourses)) ? [new InboundHostUniversityCourses()] : $modelsCourses
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
        $mail = EmailTemplates::find()->where(['id' => Variables::newApplication])->one();

        if ($model->status !== 7 && $model->status !== null) {
            Yii::$app->session->setFlash('sweetAlertError', true);
            return $this->redirect(['inbound/index']);
        }
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
                $model->created_at = date('Y-m-d H:i:s');
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

                        if ($model->status == Variables::application_init){
                            Yii::$app
                                ->mailer
                                ->compose(['html' => '@backend/views/email/emailTemplate.php'], [
                                    'subject' => $mail->subject,
                                    'body' => $mail->body,
                                ])
                                ->setFrom(['noReply@iium.edy.my' => 'IIUM Mobility System'])
                                ->setTo(Variables::$ioEmail)
                                ->setSubject($mail->subject)
                                ->send();
                        }

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

    public function actionUpload($id){

        $model = $this->findModel($id);
        $model->scenario = 'uploader';

        if ($this->request->isPost && $model->load($this->request->post())) {


            $model->status = Variables::application_files_uploaded_inbound;
            $model->uploadFiles(Yii::$app->user->id);

            if ($model->save()) {
                return $this->redirect(['index']);
            }

        }
        return $this->renderAjax('upload', [
            'model' => $model,
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

    public function actionDownloader($filePath, $id)
    {
        $uploadPath = Yii::getAlias('@common/uploads/inbound_application_') . $id . '/';
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
        $uploadPath = Yii::getAlias('@common/uploads/inbound_application_') . $id . '/';
        $fullPath = $uploadPath . $filePath;

        if (file_exists($fullPath)) {
            Yii::$app->response->sendFile($fullPath);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }
    }

    private function sendEmail($model, $template)
    {
        $mail = EmailTemplates::findOne($template);

        if ($osc != null) {
            $body = $mail->body;
            $mailer = Yii::$app->mailer->compose([
                'html' => '@backend/views/email/email-template.php'
            ], [
                'subject' => $mail->subject,
                'recipientName' => $osc->username,
                'body' => $body
            ])->setFrom(['noReplay@iium.edy.my' => 'IIUM'])->setTo($osc->email)->setSubject($mail->subject);
            $mailer->send();
        }

    }
}
