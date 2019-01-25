<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ie10-viewport-bug-workaround.css',
        'css/signin.css',
    ];
    public $js = [
        'js/ie10-viewport-bug-workaround.js',
        'js/ie-emulation-modes-warning.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
