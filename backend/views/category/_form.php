 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => true,'style'=>'width:300px']) ?>

    <?php $model->parent_id =$model->id ; ?>
    <?= $form->field($model, 'parent_id')->dropDownList($model->ParentNames, ['prompt'=>'请选择','style'=>'width:200px'])->label('父级名称'); ?>

    <!-- 第二种默认值做法 -->
    <!-- <?php /* $sql='select * from Category';
      $data=common\models\Category::findBySql($sql)->asArray()->all(); ?>
     <?= $form->field($model, 'parent_id')->dropDownList(yii\helpers\ArrayHelper::map($data,'id','cat_name'), ['prompt'=>'请选择','style'=>'width:200px','options'=>['id'=>['Selected'=>true]]])->label('父级名称'); */?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
