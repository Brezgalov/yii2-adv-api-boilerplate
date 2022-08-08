<?php

$https = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'];
$homeUrl = ($https ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}";

$config = [
    'id' => 'api-suite',
    'name' => $_ENV['APP_NAME'] ?? 'myApiApp',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'root',
    'aliases' => [
        '@vendor' => __DIR__ . '/../../vendor',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'cookieValidationKey' => $_ENV['APP_KEY'],
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
