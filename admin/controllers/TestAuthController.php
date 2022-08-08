<?php

namespace admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class TestAuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['guest'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['admin'],
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionAdmin()
    {
        return $this->renderContent("id is: " . \Yii::$app->user->getId());
    }

    public function actionGuest()
    {
        return $this->renderContent(\Yii::$app->user->isGuest ? "Guest" : "NotGuest");
    }
}