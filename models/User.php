<?php

namespace atom\cms\models;

use Yii;
use atom\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;

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
        $this->modifiedAt = gmdate('Y-m-d H:i:s');
        if ($insert) {
            $this->createdAt = $this->modifiedAt;
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

    public function getDisplayName($oldAttributes = false): string
    {
        $username = $oldAttributes ? $this->getOldAttribute('username') : $this->username;
        $firstName = $oldAttributes ? $this->getOldAttribute('firstName') : $this->firstName;
        $lastName = $oldAttributes ? $this->getOldAttribute('lastName') : $this->lastName;

        $name = trim($firstName . ' ' . $lastName);
        return $name ?: $username;
    }

    public function isPasswordExpired(): bool
    {
        return $this->passwordExpireAt && ($this->passwordExpireAt < gmdate('Y-m-d H:i:s'));
    }

    public function getDataProvider($config = [], $hideAdmin = false)
    {
        if (!isset($config['query'])) {
            $config['query'] = static::find();
        }
        if ($hideAdmin) {
            $config['query']->andWhere(['<>', 'username', 'admin']);
        }
        return new ActiveDataProvider($config);
    }
}
