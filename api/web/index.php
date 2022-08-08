<?php

ini_set("date.timezone",'Europe/Moscow');

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(
    [
        __DIR__ . '/../../app',
        __DIR__ . '/..',
    ],
    '.env',
    false
);
$dotenv->load();

define('YII_ENV', $_ENV['APP_ENV'] ?: 'prod');
define('YII_DEBUG', $_ENV['APP_ENV'] !== 'prod');

require_once __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

$config = $config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../config/web.php',
    require __DIR__ . '/../../app/config/app.php'
);

$app = new \yii\web\Application($config);
$app->run();
