<?php

namespace api\controllers;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii2mod\swagger\SwaggerUIRenderer;

class DocsController extends Controller
{
    public function beforeAction($action)
    {
        $token = \Yii::$app->request->getQueryParam('token');

        if ($token !== ArrayHelper::getValue($_ENV, 'SWAGGER_ACCESS_TOKEN')) {
            throw new ForbiddenHttpException();
        }

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'swagger' => [
                'class' => SwaggerUIRenderer::class,
                'restUrl' => Url::to([
                    'docs/json',
                    'token' => \Yii::$app->request->getQueryParam('token'),
                ]),
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionJson()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $openapiDoc = require(\Yii::getAlias('@api/documentation/swagger.php'));

        return $openapiDoc;
    }
}