<?php

/**
 * @param $url
 * @return string
 */
function swaggerPath($url) {
    return \Yii::$app->request->baseUrl . $url;
}

return [
    'openapi' => '3.0.1',
    'info' => [
        'description' => @$_ENV['APP_NAME'],
        'version' => '1.0.0',
        'title' => @$_ENV['APP_NAME'],
    ],
    'servers' => [],
    'components' => [
        'schemas' => require(__DIR__ . '/swagger/definitions/index.php'),
//        'securitySchemes' => [
//            'bearerAuth' => [
//                'type' => 'http',
//                'scheme' => 'bearer',
//            ],
//        ],
    ],
    'tags' => [
    ],
    'paths' => require(__DIR__ . '/swagger/paths/index.php'),
];
