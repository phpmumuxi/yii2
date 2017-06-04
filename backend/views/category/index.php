<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            
        [
          'attribute' => 'id',
          // 'label' => 'ID', 
          'headerOptions' => ['width' => '120px']
        ],
         
        [
          'attribute' => 'cat_name',          
          'headerOptions' => ['width' => '400px']
        ],  
            
        [
          'attribute' => 'parent_id',           
          'headerOptions' => ['width' => '120px']
        ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
