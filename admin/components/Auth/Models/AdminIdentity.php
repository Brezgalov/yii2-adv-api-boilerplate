<?php

namespace admin\components\Auth\Models;

use app\models\User;
use yii\base\BaseObject;
use yii\web\IdentityInterface;

class AdminIdentity extends BaseObject implements IdentityInterface
{
    public $id;
    public $username;
    public $password;

    private static $data = [
        1 => [
            'id' => 1,
            'username' => 'admin',
            'password' => 'admin',
        ],
        2 => [
            'id' => 2,
            'username' => 'demo',
            'password' => 'demo',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$data[$id]) ? new static(self::$data[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$data as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
