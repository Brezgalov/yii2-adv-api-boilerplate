<?php

namespace admin\components\Auth\Pages;

use admin\components\Auth\Services\LoginService;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\IRegisterInput;
use yii\base\Model;

class LoginPage extends Model implements IRenderFormatterDTO, IRegisterInput
{
    const METHOD_FOR_DISPLAY_PAGE = 'getPage';
    const METHOD_FOR_SUBMIT = 'submitLoginForm';

    /**
     * @var LoginService
     */
    public $loginService;

    /**
     * @var string
     */
    public $submitUrl = '';

    /**
     * LoginPage constructor.
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->loginService)) {
            $this->loginService = \Yii::createObject(LoginService::class);
        }
    }

    /**
     * @param array $data
     */
    public function registerInput(array $data = [])
    {
        $this->loginService->load($data);
    }

    /**
     * @return array
     */
    public function getViewParams()
    {
        return [
            'model' => $this->loginService,
            'submitUrl' => $this->submitUrl,
        ];
    }

    /**
     * @return $this
     */
    public function getPage()
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function submitLoginForm()
    {
        if (!$this->loginService->login()) {
            $this->addErrors($this->createRoleService->getErrors());
        }

        return $this;
    }
}