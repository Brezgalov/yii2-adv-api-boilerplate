<?php

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@console' => __DIR__ . '/../',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'schedule' => \omnilight\scheduling\Schedule::class,
    ],
    'params' => [],
    'controllerMap' => [
        'schedule' => \omnilight\scheduling\ScheduleController::class,
//        'fixture' => [ // Fixture generation command line.
//            'class' => 'yii\faker\FixtureController',
//        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
