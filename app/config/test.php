<?php

$appCfg = require __DIR__ . '/app.php';

$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return \yii\helpers\ArrayHelper::merge($appCfg, [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
]);