<?php

namespace atom\cms\models;

use yii\db\ActiveRecord;

class Notification extends ActiveRecord
{
    public static function tableName()
    {
        return 'notification';
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->created_at = gmdate('Y-m-d H:i:s');
        return true;
    }
}
