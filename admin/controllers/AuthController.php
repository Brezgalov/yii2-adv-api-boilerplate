<?php

namespace admin\controllers;

use admin\components\Auth\Pages\LoginPage;
use admin\components\Auth\Services\LogoutService;
use admin\components\Theme\Actions\RenderAction;
use Brezgalov\ApiHelpers\v2\ApiGetAction;
use Brezgalov\ApiHelpers\v2\Formatters\RedirectBackFormatter;
use Brezgalov\ApiHelpers\v2\Formatters\RenderOrRedirectFormatter;
use yii\helpers\Url;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actions()
    {
        return [
            'login' => [
                'class' => RenderAction::class,
                'service' => [
                    'class' => LoginPage::class,
                    'submitUrl' => Url::toRoute('login-submit'),
                ],
                'methodName' => LoginPage::METHOD_FOR_DISPLAY_PAGE,
                'title' => 'Login',
                'view' => 'auth/login',
            ],
            'login-submit' => [
                'class' => RenderAction::class,
                'service' => [
                    'class' => LoginPage::class,
                    'submitUrl' => Url::toRoute('login-submit'),
                ],
                'methodName' => LoginPage::METHOD_FOR_SUBMIT,
                'title' => 'Login',
                'view' => 'auth/login',
                'formatter' => [
                    'class' => RenderOrRedirectFormatter::class,
                    'redirectUrl' => Url::toRoute('root/index'),
                ],
            ],
            'logout' => [
                'class' => ApiGetAction::class,
                'service' => LogoutService::class,
                'methodName' => LogoutService::METHOD_LOGOUT,
                'formatter' => RedirectBackFormatter::class,
            ],
        ];
    }
}