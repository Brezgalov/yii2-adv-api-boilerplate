<?php

namespace admin\components\Auth\Services;

use yii\base\Model;
use admin\components\Auth\Models\AdminIdentity;
use yii\web\User;

class LoginService extends Model
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @var User
     */
    public $userComp;

    /**
     * @var bool
     */
    private $_admin = false;

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
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getAdmin();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        return $this->userComp->login($this->getAdmin(), $this->rememberMe ? 30 * DAY : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return AdminIdentity|null
     */
    public function getAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = AdminIdentity::findByUsername($this->username);
        }

        return $this->_admin;
    }
}