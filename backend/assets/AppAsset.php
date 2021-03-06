<?php

namespace backend\assets;

// use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends \yiister\gentelella\assets\Asset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/index.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yiister\gentelella\assets\ThemeAsset',
        'yiister\gentelella\assets\ExtensionAsset',
    ];
}
