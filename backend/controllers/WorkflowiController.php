<?php

namespace backend\controllers;

use common\helpers\Variables;
use common\models\Inbound;
use common\models\InboundHostUniversityCourses;


use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function Psy\debug;

/**
 * WorkflowoController implements the CRUD actions for outbound model.
 */
class WorkflowiController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public $layout = 'blank';
    public function beforeAction($action)
    {
        $request = Yii::$app->getRequest();
        $id = $request->get('id');
        $token = $request->get('token');

        // Validate ID as integer and ensure it's not null
        $id = intval($id); // Convert to integer

        if ($action->id !== 'error' && !$this->isValidToken($id, $token)) {
            $model = $this->findModel($id);
            $this->layout = 'main';

            throw new ForbiddenHttpException(
                "The Applicant
            <span class='text-bg-light fw-bolder'>{$model->name}</span>
            has already been Processed.
            <br />
            Current Applicant Status: {$model->status}"
            );
        }

        Yii::$app->params['currentId'] = $id;
        Yii::$app->params['currentToken'] = $token;

        return parent::beforeAction($action);

    }


    protected function isValidToken($id, $token)
    {
        if ($id === null || $token === null) {
            return false;
        }

        $model = $this->findModel($id);
        return $model->token === $token;
    }

    /**
     * Lists all outbound models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $model = Inbound::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('You do not have any records yet');
        }

        $hostCourses = InboundHostUniversityCourses::find()
            ->with('application')
            ->where(['application_id' => $model->id])
            ->asArray()
            ->all();

        $hostDataProvider = new ArrayDataProvider([
            'allModels' => $hostCourses,
            'pagination' => [
                'pageSize' => 10, // Adjust the page size if needed
            ],
        ]);
        return $this->render('index', [
            'model' => $model,
            'hostDataProvider' => $hostDataProvider
        ]);
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
     * Updates an existing outbound model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->token  = null;

            // Call the uploadFiles method to handle the file uploads
            $model->uploadFiles($model->id);

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the outbound model based on its primary key value.
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

    public function actionDownloader($filePath)
    {
        $id = Yii::$app->params['currentId'];

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

    public function actionDownload($filePath)
    {
        $id = Yii::$app->params['currentId'];
        $uploadPath = Yii::getAlias('@common/uploads/inbound_application_') . $id . '/';
        $fullPath = $uploadPath . $filePath;

        if (file_exists($fullPath)) {
            Yii::$app->response->sendFile($fullPath);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }
    }
}

