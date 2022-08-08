<?php

use admin\components\Auth\Models\AdminIdentity;

$https = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'];
$homeUrl = ($https ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}";

$config = [
    'id' => 'admin-suite',
    'name' => $_ENV['APP_NAME'] ?? 'myAdminApp',
    'basePath' => dirname(__DIR__),
    'viewPath' => __DIR__ . '/../components/Theme/Views',
    'controllerNamespace' => 'admin\controllers',
    'defaultRoute' => 'root/index',
    'aliases' => [
        '@vendor' => __DIR__ . '/../../vendor',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'view' => [
            'title' => 'Admin Panel',
        ],
        'request' => [
            'baseUrl' => '/admin',
            'cookieValidationKey' => $_ENV['APP_KEY'],
        ],
        'user' => [
            'identityClass' => AdminIdentity::class,
            'enableAutoLogin' => true,
            'loginUrl' => ["auth/login"],
        ],
        'errorHandler' => [
            'errorAction' => 'root/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => [],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
