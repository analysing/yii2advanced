<?php

namespace api\models;

/**
* User
*/
class User extends \common\models\User
{
    public $password;

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['username', 'password', 'email'], 'trim'],
            [['username'], 'string', 'min' => 4, 'max' => 20],
            [['username'], 'unique', 'message' => 'This username has already been taken.'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique', 'message' => 'This email has already been taken.'],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 6],
        ];
    }
}