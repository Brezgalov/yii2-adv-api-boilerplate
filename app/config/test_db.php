<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => sprintf(
        'mysql:host=%s;port=%s;dbname=%s',
        $_ENV['DB_HOST_TEST'] ?? '',
        $_ENV['DB_PORT_TEST'] ?? '',
        $_ENV['DB_NAME_TEST'] ?? ''
    ),
    'username' => $_ENV['DB_USER_TEST'] ?? '',
    'password' => $_ENV['DB_PASS_TEST'] ?? '',
    'charset' => 'utf8mb4',
];
