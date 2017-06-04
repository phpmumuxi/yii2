<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    //'homeUrl'=>'/admin',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'=>'site/index',
   // 'layout'=>false,
  //  'language'=>'zh-CN',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [        
            'class' => 'mdm\admin\Module', 
            //'layout' => 'left-menu',//yii2-admin的导航菜单  
        ],
    ],
    'aliases' => [    
        '@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [   //可以不受rbac控制的，一直放行的家伙,是允许访问的action
        //下面列出的节点，所有人都可以访问，针对未登录用户的配置也可以移至这里
            //controller/action
          // '*',    
           //'admin/*',
          // 'site/*', 
        ]
    ],
    'components' => [
        
        'authManager' => [        
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['未登录用户'],    
        ],
        
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-green-light',
                    ],
                ],
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
            //看了源码是（在 yii\web\UrlManager）
           //$baseUrl = $this->showScriptName || !$this->enablePrettyUrl ? $this->getScriptUrl() : $this->getBaseUrl();
           // 'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'backend\models\UserBackend',
            //cookie验证的关键,只有为true的时候才会储存cookie
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,// 这个是生成路由 ?r=site/about ---->   /site/about
            'showScriptName' => false,// 这个是生成url的时候，去掉index.php
            'rules' => [
            ],
//           'rules' => [
//                'posts' => 'post/index', 
//                'post/<id:\d+>' => 'post/view',
//                '<controller:(post|comment)>/<id:\d+>/<action:(create|update|delete)>' 
//                    => '<controller>/<action>',
//                'DELETE <controller:\w+>/<id:\d+>' => '<controller>/delete',
//                'http://<user:\w+>.digpage.com/<lang:\w+>/profile' => 'user/profile',
//            ]
            //'suffix'=>'.html',
        ],

        //根据Theme,静态设置设置主题
        // 'view' => [
        //     'theme' => [
        //         // 'basePath' => '@app/themes/spring',
        //         // 'baseUrl' => '@web/themes/spring',
        //         //basePath和baseUrl分别是对资源的目录和资源的url进行配置
        //         'pathMap' => [ 
        //             '@app/views' => [ //（@app是指应用所在的顶级目录）backend下创建目录 themes/spring
        //                 '@app/themes/spring', //路径的一个映射,@app/view路径替换为@app/themes/spring
        //                 '@app/themes/christmas',
        //                 //定义多个映射关系,只需要把chrismas主题配置到属组的第一项即可，因为前面的优先级比后面高，如果前面的模版找不到才会用下面的spring主题模版。spring我们来年可以继续使用，如果当前项目还存在的话。
        //             ]
        //         ],
        //     ],
        // ],
        
    ],
    'params' => $params,
];
