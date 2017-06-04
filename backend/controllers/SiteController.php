<?php
namespace backend\controllers;

use Yii;
//use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\BackLoginForm;
use backend\controllers\BaseController;
use backend\models\UserBackend;
// use yii\caching\Cache;
/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','vlogin'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','clear-cache'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],

            /*  'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        // 当前rule将会针对这里设置的actions起作用，如果actions不设置，默认就是当前控制器的所有操作
                        'actions' => ['view', 'create', 'update', 'delete', 'signup'],
                        // 设置actions的操作是允许访问还是拒绝访问
                        'allow' => true,
                        // @ 当前规则针对认证过的用户; ? 所有方可均可访问
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        // 设置只允许操作的action
                        'verbs' => ['POST'],
                    ],
                ],
      //我们新增加的一条规则，设置了AccessRule::verbs属性即可。

注意哦，ACF 自上向下逐一检查规则，直到匹配到一个规则。也就是说如果你这里把verbs的actions index也添加一份到上面的那一条规则，verbs这条规则就相当于废掉了！

            ],*/

          /*  'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    // 当前rule将会针对这里设置的actions起作用，如果actions不设置，默认就是当前控制器的所有操作
                    'actions' => ['index', 'view', 'create', 'delete', 'signup'],
                    // 设置actions的操作是允许访问还是拒绝访问
                    'allow' => true,
                    // @ 当前规则针对认证过的用户; ? 所有用户均可访问
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['update'],
                    // 自定义一个规则，返回true表示满足该规则，可以访问，false表示不满足规则，也就不可以访问actions里面的操作啦
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->id == 1 ? true : false;
                    },
                    'allow' => true,
                ],
            ],
        ],*/

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        // 判断用户是访客还是认证用户 
    // isGuest为真表示访客，isGuest非真表示认证用户，认证过的用户表示已经登录了，这里跳转到主页面
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        // 实例化登录模型 common\models\LoginForm
        $model = new BackLoginForm();
        // 接收表单数据并调用LoginForm的login方法
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else { // 非post直接渲染登录表单
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * 伪登陆
     *
     * @return string
     */
     public function actionVlogin()
    {
        $id=Yii::$app->request->get('id',0);
         $info=UserBackend::findOne($id);       
         $duration=24*3600*30;       
        //cookie的value值是json数据  
         $values = json_encode([  
            $info['id'],  
            $info['auth_key'],  
            $duration,  
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);  
        //设置cookie的有效时间  
     
         $cookies = Yii::$app->response->cookies;

        // 在要发送的响应中添加一个新的cookie
        $cookies->add(new \yii\web\Cookie([
            'name' => '_identity-backend',
            'value' => $values,
            'expire' =>time()+$duration
        ]));
 
       $this->redirect('/');
    }
    
   /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load($this->post())) {            
            if ($user = $model->signup()) {
               
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
       // return $this->goHome();
    }

    /**
     * 
     *
     * 
     */

    public function actionClearCache()
    {
        Yii::$app->cache->flush();
        return $this->goHome();
    }
    
}
