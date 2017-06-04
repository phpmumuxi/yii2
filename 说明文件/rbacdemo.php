1、首先我们要在 组件里面配置一下 Rbac ，如下所示(common/config/main-local.php或者main.php)。

'authManager' => [
    'class' => 'yii\rbac\DbManager',
    'itemTable' => 'auth_item',
    'assignmentTable' => 'auth_assignment',
    'itemChildTable' => 'auth_item_child',
],

当然，在配置里面也可以设置 默认角色，只是我没写。Rbac 支持两种类，PhpManager 和 DbManager ，这里我使用 DbManager 。
yii migrate --migrationPath=@yii/rbac/migrations/
运行此命令生成权限数据表

2、配置完毕， 下面我们尝试着创建一个 许可 Permiassion,代码如下

public function createPermission($item)
{
    $auth = Yii::$app->authManager;
    $createPost = $auth->createPermission($item);
    $createPost->description = '创建了 ' . $item . ' 许可';
    $auth->add($createPost);
}

3、好的， 许可我们就创建完成了，下面我们创建一个 角色吧 roles

public function createRole($item)
{
    $auth = Yii::$app->authManager;
    $role = $auth->createRole($item);
    $role->description = '创建了 ' . $item . ' 角色';
    $auth->add($role);
}

4、好的，就是这么简单，不要激动，下面更简单，给角色分配许可，上代码

static public function createEmpowerment($items)
{
    $auth = Yii::$app->authManager;
    $parent = $auth->createRole($items['name']);
    $child = $auth->createPermission($items['description']);
    $auth->addChild($parent, $child);
}

5、好的，分配许可也创建完成了，我操，太尼玛简单了，继续上代码，给角色分配用户

static public function assign($item)
{
    $auth = Yii::$app->authManager;
    $reader = $auth->createRole($item['name']);
    $auth->assign($reader, $item['description']);
}

6、好的好的，就是这么简单，我自己都他妈不敢相信啊，你相信吗？？？ 最后一步，验证用户是否有权限

public function beforeAction($action)
{
    $action = Yii::$app->controller->action->id;
    if(\Yii::$app->user->can($action)){
        return true;
    }else{
        throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
    }
}

