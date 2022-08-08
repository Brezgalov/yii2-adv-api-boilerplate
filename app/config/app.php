<?php

defined('MINUTE') or define('MINUTE', 60);
defined('HOUR') or define('HOUR', 3600);
defined('DAY') or define('DAY', 86400);

defined('DATETIME_FORMAT') or define('DATETIME_FORMAT', 'Y-m-d H:i:s');

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',

        '@admin' => __DIR__ . '/../',
        '@app' => __DIR__ . '/../',
        '@api' => __DIR__ . '/../../api',
        '@console' => __DIR__ . '/../',
        '@tests' => '@app/tests',
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
                'host' => $_ENV['SMTP_HOST'],
                'username' => $_ENV['SMTP_USERNAME'],
                'password' => $_ENV['SMTP_PASSWORD'],
                'port' => $_ENV['SMTP_PORT'], // 465 commonly
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
                        'to'      => require 'error_emails.php',
                        'subject' => 'ERROR ' . @$_ENV['APP_NAME'],
                    ],
                ],
            ],
        ],
        'db' => $db,
        'db_test' => require 'test_db.php',
    ],
    'params' => $params,
];