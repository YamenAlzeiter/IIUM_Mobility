<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class wizard extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/wizard.css',
        'css/tabler-icons.css',

    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/sweetalert2@11',
//        'js/main.js',
//        'js/bs-init.js',
        'js/form-wizard.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}

