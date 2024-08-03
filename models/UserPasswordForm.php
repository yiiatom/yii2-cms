<?php

namespace atom\cms\models;

use yii\base\Model;

class UserPasswordForm extends Model
{
    public string $password = '';
    public string $confirm = '';
    public bool $changeAfterLogin = true;

    private User $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function rules()
    {
        return [
            [['password', 'confirm'], 'required'],
            ['confirm', 'compare', 'compareAttribute' => 'password'],
            ['changeAfterLogin', 'boolean'],
        ];
    }

    public function getUser(): User
    {
        return $this->_user;
    }

    public function process(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->passwordExpireAt = $this->changeAfterLogin ? gmdate('Y-m-d H:i:s') : null;
        return $user->save(false);
    }
}
