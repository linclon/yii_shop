<?php
/*
 * 静态资源管理器:加载静态资源
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main frontend application asset bundle.
 */
class AddressAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/home.css',
        'style/address.css',
        'style/bottomnav.css',
        'style/footer.css',
    ];
    public $js = [
//        '/assets/384eba11/jquery.js',
        '/assets/8f82cac8/yii.js',
        '/assets/8f82cac8/yii.validation.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
