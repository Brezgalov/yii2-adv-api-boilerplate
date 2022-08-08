<?php

namespace admin\components\Auth\Services;

use yii\base\Model;
use yii\web\User;

class LogoutService extends Model
{
    const METHOD_LOGOUT = 'logout';

    /**
     * @var User
     */
    public $userComp;

    /**
     * LoginService constructor.
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->userComp) && \Yii::$app->has('user')) {
            $this->userComp = \Yii::$app->get('user');
        }
    }

    /**
     * @return bool
     */
    public function logout()
    {
        $this->userComp->logout();

        return true;
    }
}