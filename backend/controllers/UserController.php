<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use yii\data\ActiveDataProvider;

class UserController extends Controller
{
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
                            'roles' => ['admin'],
                        ],
                        [
                            'allow' => false,
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $query = User::find()
            ->where(['status' => [User::STATUS_INACTIVE, User::STATUS_ACTIVE]])
            ->andWhere(['type' => ['staff', 'admin']]);

        $query->orderBy(['status' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false, // Disable default sorting to use custom sorting
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionApprove()
    {
        $id = Yii::$app->request->post('id');
        $user = User::findOne($id);
        if ($user) {
            $user->status = User::STATUS_ACTIVE;
            if ($user->save()) {
                return $this->asJson(['success' => true]);
            }
        }
        return $this->asJson(['success' => false]);
    }

    public function actionReject()
    {
        $id = Yii::$app->request->post('id');
        $user = User::findOne($id);
        if ($user) {
            $user->status = User::STATUS_INACTIVE; // Assuming status 0 is for rejected
            if ($user->save()) {
                return $this->asJson(['success' => true]);
            }
        }
        return $this->asJson(['success' => false]);
    }

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if ($user === null) {
            Yii::$app->session->setFlash('error', 'User not found.');
            return $this->redirect(['index']);
        }

        if (Yii::$app->request->post()) {
            $postData = Yii::$app->request->post('User');
            $role = $postData['type'];  // Get the new role from the form data

            // Update the user type
            $user->type = $role;
            if (!$user->save()) {
                Yii::$app->session->setFlash('error', 'Failed to update user type.');
                return $this->redirect(['index']);
            }

            // Revoke old roles and assign the new role
            $auth = Yii::$app->authManager;
            $auth->revokeAll($user->id); // Remove all current roles

            $newRole = $auth->getRole($role);
            if ($newRole && $auth->assign($newRole, $user->id)) {
                Yii::$app->session->setFlash('success', 'User role and type updated successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update user role.');
            }

            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'user' => $user,
        ]);
    }

}
