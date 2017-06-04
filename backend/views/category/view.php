<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = $model->cat_name.'-'.$model->id;
$this->params['breadcrumbs'][] = ['label' => '分类列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除嘛?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cat_name',
            [
             'attribute' => '父级名称',
             //'lable'      => '',
             'value'     => function($model){
                 $Category = Category::findOne($model->id);
                   if($Category->parent_id==0){
                      return '顶级分类';
                   }else{
                      $CategoryPname = Category::findOne($Category->parent_id);               
                      return $CategoryPname->cat_name;
                   }               
             },
            ] 
        ],
    ]) ?>

</div>
