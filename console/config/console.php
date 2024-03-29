<?php

$app = require (__DIR__ . '/../../app/config/app.php');

$config = \yii\helpers\ArrayHelper::merge($app, [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'schedule' => \omnilight\scheduling\Schedule::class,
    ],
    'params' => [],
    'controllerMap' => [
        'schedule' => \omnilight\scheduling\ScheduleController::class,
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => '@console/migrations'
        ],
    ],
]);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
