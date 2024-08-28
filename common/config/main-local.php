<?php

return [
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=10.101.243.185;port=5432;dbname=postgres',
            'username' => 'ac_iosys_usr',
            'password' => 'In0ut_5ys',
            'schemaMap' => [
                'pgsql'=> [
                    'class'=>'yii\db\pgsql\Schema',
                    'defaultSchema' => 'ac_iosys'
                ]
            ],
            'on afterOpen' => function($event) {
                $event->sender->createCommand('SET search_path TO ac_iosys;')->execute();
            }
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'test24testy24test@gmail.com',
                'password' => 'lbst ieyq ydqb jlvp ',
                'port' => 587,
                'encryption' => 'tls',
                'scheme' => 'smtp',
            ],
        ],
    ],
];
