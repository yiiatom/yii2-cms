<?php

namespace atom\cms\models;

use Yii;
use atom\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->authKey = \Yii::$app->getSecurity()->generateRandomString();
        }
        $this->modified_at = gmdate('Y-m-d H:i:s');
        if ($insert) {
            $this->created_at = $this->modified_at;
        }
        return true;
    }

    public function setPassword($value)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($value);
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function getDisplayName()
    {
        return $this->username;
    }
}
