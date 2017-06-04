<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    /* public function registerAssetFiles($view)
    {
         //加一个最新的版本号，使浏览器获取最新的css和js，不用缓存的
         $version='1.0.03';
         $this->css=[
             "css/site.css?v={$version}",
         ];
         $this->js=[
             'js/index.js',
         ];
         parent::registerAssetFiles($view);
    }*/
}
