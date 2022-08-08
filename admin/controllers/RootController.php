<?php

namespace admin\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

class RootController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => '/error',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->renderContent('test');
    }
}