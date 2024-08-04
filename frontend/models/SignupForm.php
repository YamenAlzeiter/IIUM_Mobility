<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Exception;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $type;
    public $matric_number;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['type', 'required'], // Ensure studentType is required
            ['type', 'in', 'range' => ['inbound', 'outbound']], // Validate studentType values

            ['matric_number', 'string'],
            ['matric_number', 'required',
                'when' => function ($model) {
                    Yii::info('Current type: ' . $model->type);
                    return $model->type === 'outbound';
                },'whenClient' => "function (attribute, value) {
                    return $('#signupform-type').val() === 'outbound';
                }"
            ]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User whether the creating new account was successful and email was sent
     * @throws Exception
     * @throws \Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->type = $this->type;

        // Set specific attributes based on type
        if ($this->type === 'outbound') {
            $user->matric_number = $this->matric_number;
        }

        if ($user->save()) {

            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->type);
            $auth->assign($role, $user->id);

            // Send email for verification
            $this->sendEmail($user);

            return $user; // Return the saved user model
        }
    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
