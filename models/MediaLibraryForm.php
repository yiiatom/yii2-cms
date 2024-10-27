<?php

namespace atom\cms\models;

use Yii;
use yii\base\Model;

class MediaLibraryForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            ['file', 'file'],
        ];
    }

    public function process(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        $filename = Yii::getAlias('@webroot/public/') . $this->file->baseName . '.' . $this->file->extension;
        return $this->file->saveAs($filename);
    }
}
