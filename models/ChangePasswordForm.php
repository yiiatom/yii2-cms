<?php

namespace atom\cms\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $confirm;

    private $_user = false;

    public function rules()
    {
        return [
            [['password', 'newPassword', 'confirm'], 'required'],
            ['confirm', 'compare', 'compareAttribute' => 'newPassword'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    public function process()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->setPassword($this->newPassword);
            $user->passwordExpireAt = null;
            return $user->save(false);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Yii::$app->user->identity;
        }

        return $this->_user;
    }
}
