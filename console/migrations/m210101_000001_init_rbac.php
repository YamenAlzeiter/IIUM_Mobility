<?php
use yii\db\Migration;

class m210101_000001_init_rbac extends Migration
{
    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Create roles
        $admin = $auth->createRole('admin');
        $staff = $auth->createRole('staff');
        $inboundStudent = $auth->createRole('inbound');
        $outboundStudent = $auth->createRole('outbound');
        $auth->add($admin);
        $auth->add($staff);
        $auth->add($inboundStudent);
        $auth->add($outboundStudent);

        // Create admin user
        $adminUser = new \common\models\User();
        $adminUser->username = 'admin';
        $adminUser->email = 'yamen.zeiter24@gmail.com';
        $adminUser->setPassword('admin'); // Change this to a secure password
        $adminUser->generateAuthKey();
        $adminUser->status = \common\models\User::STATUS_ACTIVE;
        if ($adminUser->save()) {
            $auth->assign($admin, $adminUser->id);
        }
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
