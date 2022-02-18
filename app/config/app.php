<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return [
    'aliases' => [
        '@app' => __DIR__ . '/../',
        '@api' => __DIR__ . '/../../api',
    ],
    'bootstrap' => [
        'log',
    ],
    'components' => [
        'mutex' => \yii\mutex\FileMutex::class,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'support@kto-vezet.ru',//"no-reply@zernovozam.ru",
                'password' => 'ntmqmdygxozltvdy',//'xYZDCRCd4',//"6R2iusGfNv",
                'port' => "465",
                'encryption' => "ssl",
            ]
        ],
        'log'     => [
            'traceLevel' => 3,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'   => 'yii\log\EmailTarget',
                    'mailer'  => 'mailer',
                    'levels'  => ['error'],
                    'except'  => [
                        'yii\web\HttpException:401',
                        'yii\web\HttpException:403',
                        'yii\web\HttpException:404',
                    ],
                    'message' => [
                        'from'    => ['support@kto-vezet.ru'],
                        'to'      => ['brezgalov.developer@gmail.com'],
                        'subject' => 'ERROR ' . @$_ENV['APP_NAME'] .  ' ( CONSOLE )',
                    ],
                ],
            ],
        ],
        'db' => $db,
        'db_test' => require 'test_db.php',
    ],
    'params' => $params,
];