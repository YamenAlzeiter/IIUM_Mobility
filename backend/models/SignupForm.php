<?php
namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\db\Exception;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->type = 'staff';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->status = User::STATUS_INACTIVE;
            if ($user->save()) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('staff');
                $auth->assign($role, $user->id);
                return $user;
            }
        }

        return null;
    }
}
