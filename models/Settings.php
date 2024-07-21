<?php

namespace atom\cms\models;

use atom\db\ActiveRecord;

class Settings extends ActiveRecord
{
    public static function tableName()
    {
        return 'settings';
    }
}
