<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '添加新管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">    

    <p></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')
                         ->label('用户名:')
                         ->textInput(['autofocus' => true,'placeholder' => $model->getAttributeLabel('username')]) ?>

                <?= $form->field($model, 'email')
                         ->label('邮箱:')
                         ->textInput(['placeholder' => $model->getAttributeLabel('email')])?>

                <?= $form->field($model, 'password')
                         ->label('密码:')
                         ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

                <div class="form-group">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
