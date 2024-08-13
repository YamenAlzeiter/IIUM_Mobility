<?php

return [
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;dbname=moua',
            'username' => 'postgres',
            'password' => 'admin',
            'schemaMap' => [
                'pgsql'=> [
                    'class'=>'yii\db\pgsql\Schema',
                    'defaultSchema' => 'inbound_outbound'
                ]
            ],
            'on afterOpen' => function($event) {
                $event->sender->createCommand('SET search_path TO inbound_outbound;')->execute();
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
