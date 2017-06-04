<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\UserBackend;
use backend\models\search\UserBackendSearch;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserBackendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-backend-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?php 
        //没有创建权限不显示按钮 
        if(Helper::checkRoute('create')) { 
             echo Html::a('添加管理员', ['create'], ['class' => 'btn btn-success']);
        }
        ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 

        //  表格加表头
        // 'caption' => '内容管理',
        // 'captionOptions' => ['style' => 'font-size: 16px; font-weight: bold; color: #000; text-align: center;'],  

        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'], 自增
            [
                'class'=>'yii\grid\CheckboxColumn',
                //$searchModel 当前行的对象， $key当前行的建，$index当前行的索引，$column数据列的对象
                'checkboxOptions' => function($searchModel, $key, $index, $column) {
                    return ['value' => $searchModel->id
                        //'value' => $key
                    ];
                }
            ],
               /* ActionColumn 显示操作按钮等
                CheckboxColumn 显示复选框
                RadioButtonColumn 显示单选框
                SerialColumn 显示行号*/    

            'id',
            // [
            //     "attribute" => "id",
            //     "value" => function ($model) { 
            //          return $model->id; 
            //     },
            //     //是否显示某列
            //     "visible" => intval(\Yii::$app->user->identity->id) == 3,                 
            // ],

             //字段内容换行
            // [
            //     'attribute' => 'username',
            //     'contentOptions' => ['style' => 'white-space: normal;', 'width' => '40%'],
            // ],

            //'username',
            [
                'attribute' => 'username',
                'contentOptions' => ['style' => 'white-space: normal;', 'width' => '20%'],
            ],

            // [
            //     'attribute' => 'username',
            //     'value' => function ($model) { 
            //     return Html::encode($model->username); 
            //     },
            //     'format' => 'raw',
            // ],

                 //链接可点击跳转案例
            // [
            //     'attribute' => 'username',
            //     'value' => function ($model) {
            //         return Html::a($model->username, "/order?id={$model->id}", ['target' => '_blank']);
            //     },
            //     'format' => 'raw',
            // ], 

                 //显示图片案例
            //   [
            //     'label' => '头像',
            //     'format' => [
            //     'image', 
            //     [
            //     'width'=>'84',
            //     'height'=>'84'
            //     ]
            //     ],
            //     'value' => function ($model) { 
            //     return $model->image; 
            //     }
            // ],
               
            [
                "attribute" => "is_status",
                "value" => function ($model) {
                //选中
                    return UserBackendSearch::dropDown("is_status", $model->is_status);
                },
                //下拉列表 
              // 1. "filter" => UserBackendSearch::dropDown("is_status"),//自定义的函数
                  "filter" => UserBackendSearch::dropDown("is_status"),
                 //在搜索条件（过滤条件）中使用下拉框来搜索
               //2. 'filter' => ['1'=>'正常','0'=>'已删除'],
                
              //  3. 'filter' => Html::activeDropDownList($searchModel,
                 //            'is_status',['1'=>'正常','0'=>'已删除'],
                 //            ['prompt'=>'全部']
                 // )
            ],

            'email:email',
            [
                 'attribute'=>'created_at',
                 'format'=>['date', 'php:Y-m-d H:i:s']
             ],
            //'created_at:datetime',  
            //注意存储时间格式date或datetime 还是int时间戳
            //1.'created_at:datetime',  
            // 2. [
            //     'attribute'=>'created_at',
            //     'format'=>['date', 'php:Y-m-d H:i:s']
            // ], 
            // 3. [
            //     'attribute'=>'created_at',
            //     'value'=>function($model){
            //         return date('Y-m-d H:i:s',$model->created_at);
            //     }
            // ],         
            'updated_at:datetime',            
           // ['class' => 'yii\grid\ActionColumn'],
            [
              'class' => 'yii\grid\ActionColumn',
              'header' => '操作',  
                        
            //根据权限显示按钮
              'template' => Helper::filterActionColumn('{view}{update}{delete}'), 
       
            ]
        ],
        'emptyText' => '没有筛选到任何内容哦',
        'emptyTextOptions'=>['style'=>'color:red;font-weight:bold'],
        // 'layout' => "{summary}\n{items}\n{pager}",  // GridView自上而下是简介，表格，分页
       // 'layout' => "{items}\n{pager}",
       // 'showOnEmpty'=>false, //当数据不存在的时候，表格是否出现
    ]); ?>
<?php 
 /*   echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],不需要显示前面的导航
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '100']
        ],
        [
            'attribute' => 'uid',
            'label' => '用户ID',
            'value' => function($model) {
                $user = Users::findOne(['id' => $model->uid]);
                return '[' . $user->id . ']' . $user->username;
            },
                    'headerOptions' => ['width' => '200']
                ],
                'title',
                [
                    'attribute' => 'status',
                    'label' => '状态',
                    'value' => function($model) {
                        return $model->status == 1 ? "开启" : "关闭";
                    },
                    'headerOptions' => ['width' => '100']
                ],
                ['class' => 'yii\grid\ActionColumn', 'header' => '操作', 'template' => '{view}{up} {update} {delete}', //删除图标直接去掉templated的元素就OK
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $url = "/qa/view?id=" . $model->id;
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看', 'target' => '_blank']);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'target' => '_blank']);
                        },
                        'up' => function ($url, $model) {
                             $url = "/qasss/view?id=" . $model->id;
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'target' => '_blank']);
                        }, 
                         //绑定事件
                        'test' => function($url, $model, $key){
                            return Html::a('<i class="fa fa-ban"></i> 测试按钮',
                                            "javascript:;",
                                            [
                                                //'id' => 'test',
                                                'class' => 'btn btn-primary btn-xs',
                                                "onclick" => "alert('操作id：".$model->id."')",
                                            ]
                                        );

                            },

                            $('.btn-xs').click(function(){
                                var url = "你的url";
                               $.getJSON(url,{},function(d){
                                   //返回后的逻辑
                                });     
                            });

                       "update-status" => function ($url, $model, $key) {
                                    return Html::a("更新状态", "javascript:;", ["onclick"=>"update_status(this, ".$model->id.");"]); },

                            ],
                            'headerOptions' => ['width' => '70']
                        ],
                    ],
                    'emptyText' => '没有筛选到任何内容哦',
                ]);*/
                ?>
</div>
