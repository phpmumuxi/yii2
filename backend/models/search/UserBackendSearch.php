<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserBackend;

/**
 * UserBackendSearch represents the model behind the search form about `backend\models\UserBackend`.
 */
class UserBackendSearch extends UserBackend
{

//额外增加属性
    public function attributes()
    {
        return array_merge(parent::attributes(),['nick_name']);     
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at','is_status','nick_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserBackend::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
              //分页
             // 'pagination'=>[
             //     'pagesize'=>10
             // ]
            //排序 
             // 'sort'=>[
             //     'defaultOrder'=>[
             //             //'id'=>SORT_DESC,
             //             'id'=>SORT_ASC,
             //      ],
             //      'attributes'=>['id','username'],
             // ],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // 验证失败不显示数据,但是有表格
          //   $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            //我们搜索输入框中输入的格式一般是 2016-01-01 而非时间戳
            //输出2016-01-01无非是想搜索这一天的数据，因此代码如下
            // if ($this->created_at) {
            //     $createdAt = strtotime($this->created_at);
            //     $createdAtEnd = $createdAt + 24*3600;
            //     $query->andWhere("created_at >= {$createdAt} AND created_at <= {$createdAtEnd}");
            // }
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'is_status', $this->is_status])
            ->andFilterWhere(['like', 'email', $this->email]);

        // $dataProvider->sort->attributes['id']=
        // [
        //      'asc'=>['id'=>SORT_ASC],
        //      'desc'=>['id'=>SORT_DESC],
        // ];

        return $dataProvider;
    }

    /**
     *  下拉筛选
     *  @column string 字段
     *  @value mix 字段对应的值，不指定则返回字段数组
     *  @return mix 返回某个值或者数组
     */
    public static function dropDown ($column, $value = null)
    {
        $dropDownList = [            
            "is_status"=> [
                "0"=>"禁用",
                "1"=>"通过",
            ],
            //有新的字段要实现下拉规则，可像上面这样进行添加
            // ......
        ];
        //根据具体值显示对应的值
        if ($value !== null) 
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        //返回关联数组，用户下拉的filter实现
        else
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
    }
}
