<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //authManager有PhpManager和DbManager两种方式,    
		//PhpManager将权限关系保存在文件里,这里使用的是DbManager方式,将权限关系保存在数据库.    
        "authManager" => [        
            "class" => 'yii\rbac\DbManager',
        ],

         // 使用函数注册"search" 组件
        // 'search' => function () {
        //     return new app\components\SolrService;
        // },

    ],
    //全拦截路由, Web 应用临时调整到维护模式
   //  'catchAll' => ['site/offline'],
    
];
