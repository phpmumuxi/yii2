表单部分

<?php $form = ActiveForm::begin([  
	'action' => ['save'], //提交地址(*可省略*)  
	'method'=>'post',    //提交方法(*可省略默认POST*)  
	'id' => 'form-save', //设置ID属性  
	'options' => [  
		'class' => 'form-horizontal', //设置class属性  
	],  
	'enableAjaxValidation' => true,  
	'validationUrl' => 'validate-view',  
]); ?>  
  
<?php echo $form->field($model,'company_name', ['inputOptions' => ['placeholder'=>'请输入商家名称','class' => 'form-control'], 'template'=>'<label for="inputCompanyName" class="col-sm-1 control-label"><span class="text-red">*</span> 商家名称</label><div class="col-md-8">{input}</div><label class="col-sm-3" for="inputError">{error}</label>'])->textInput()?>  
  
<?=Html::submitButton('保存',['class'=>'btn btn-primary']); ?>  
  
<?php ActiveForm::end(); ?>

其中：'enableAjaxValidation' => true, 必须设置，告诉表单用ajax提交

控制器（controller）部分

控制器分两部分，一部分是效验表单的正确性，另外一部分是保存

一、效验部分

public function actionValidateView()  
{  
	$model = new model();  
	$request = \Yii::$app->getRequest();  
	if ($request->isPost && $model->load($request->post())) {  
		\Yii::$app->response->format = Response::FORMAT_JSON;  
		return ActiveForm::validate($model);  
	}  
}

二、保存部分

public function actionSave()  
{  
	\Yii::$app->response->format = Response::FORMAT_JSON;  
	$params = Yii::$app->request->post();  
	$model = $this->findModel($params[id]);  
  
	if (Yii::$app->request->isPost && $model->load($params)) {  
		return ['success' => $model->save()];  
	}  
	else{  
		return ['code'=>'error'];  
	}  
}   

Ajax提交from表单

$(function(){
$(document).on('beforeSubmit', 'form#form-save', function () {
		var form = $(this);
		//返回错误的表单信息
		if (form.find('.has-error').length)
		{
			return false;
		}
		//表单提交
		$.ajax({
			url    : form.attr('action'),
			type   : 'post',
			data   : form.serialize(),
			success: function (response){
				if(response.success){
					alert('保存成功');
					window.location.reload();
				}
			},
			error  : function (){
				alert('系统错误');
				return false;
			}
		});
		return false;
	});
});
