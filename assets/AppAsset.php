<?php

namespace atom\cms\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/app/dist';

    public $css = [
        'main.css',
    ];

    public $js = [
        'main.js',
    ];

    public $depends = [
        'atom\cms\assets\FontAwesomeAsset',
        'yii\web\YiiAsset',
    ];
}
