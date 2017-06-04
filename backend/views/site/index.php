<?php

/* @var $this yii\web\View */

$this->title = '后台应用管理';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>系统信息</h1>

        <p class="lead">欢迎使用</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Yii2详情</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>服务器操作系统:</h2>

                <p><?=PHP_OS; ?><br/>
                 <?=date('Y-m-d H:i:s'); ?>
                </p>
                
            </div>
            <div class="col-lg-4">
                <h2>PHP运行模式:</h2>

                <p><?=strtoupper(php_sapi_name()); ?></p>
                
            </div>
            <div class="col-lg-4">
                <h2>WEB 服务器:</h2>

                <p><?=$_SERVER['SERVER_SOFTWARE']; ?></p>
                
            </div>
        </div>

    </div>
</div>
