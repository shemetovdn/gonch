<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@webroot/files';

    public $js = [
        'js/modernizr.custom.js',
        'js/classie.js',
        'js/progressButton.js',
        'js/jquery-1.12.0.min.js',
        'js/owl.carousel.min.js',
        'js/bootstrap.min.js',
        'js/jquery.mCustomScrollbar.js',
        'js/dialogFx.js',
        'js/scripts.js',
        'js/cart.js',
        'js/product-desc-slid-down.js',
        'js/left-menu.js',
    ];

    public $css = [
        'css/bootstrap.min.css',
        'css/bootstrap-theme.min.css',
        'css/font-awesome.min.css',
        'css/jquery.mCustomScrollbar.css',
        'css/owl.carousel.css',
        'css/component.css',
        'css/style.css',
        'css/dev.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
