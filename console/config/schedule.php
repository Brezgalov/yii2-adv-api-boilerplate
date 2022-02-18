<?php

/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

$phpPath = @$_ENV['PHP_PATH'];
$yiiPath = @$_ENV['YII_PATH'];

if (empty($phpPath) || empty($yiiPath)) {
    return;
}

// test cron
//$schedule->exec("{$phpPath} {$yiiPath} test")->everyNMinutes(4);