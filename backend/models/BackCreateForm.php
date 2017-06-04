<?php
namespace backend\models;

use yii\base\Model;
use backend\models\UserBackend;

/**
 * Signup form
 */
class BackCreateForm extends Model
{
    public $username;
    public $email;
    public $password;
    
    public $created_at;
    public $updated_at;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            // unique表示唯一性，targetClass表示的数据模型 这里就是说UserBackend模型对应的数据表字段username必须唯一
            ['username', 'unique', 'targetClass' => '\backend\models\UserBackend', 'message' => '用户名已注册'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\UserBackend', 'message' => '邮箱已被注册'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            // default 默认在没有数据的时候才会进行赋值
            [['created_at', 'updated_at'], 'default', 'value' => time()],
        ];
    }

    public function attributeLabels()
    {
        return [
            
            'username' => '用户名至少2位',           
            'password' => '密码长度最少6位',
            'email' => '填写正确地邮箱格式',
            
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        // 调用validate方法对表单数据进行验证，验证规则参考上面的rules方法
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserBackend();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        // 生成 "remember me" 认证key
        //生成随机的auth_key，用于cookie登陆。
        $user->generateAuthKey();
        $user->created_at = $this->created_at; 
        $user->updated_at = $this->updated_at;
         // save(false)的意思是：不调用UserBackend的rules再做校验并实现数据入库操作
        // 这里这个false如果不加，save底层会调用UserBackend的rules方法再对数据进行一次校验，因为我们上面已经调用Signup的rules校验过了，这里就没必要在用UserBackend的rules校验了
        return $user->save(false) ? $user : null;
    }
}
