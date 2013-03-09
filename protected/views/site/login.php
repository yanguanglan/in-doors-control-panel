<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Авторизация';
?>

<h1>Авторизация</h1>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
  'type' => 'horizontal',
	'enableClientValidation'=>true,
  'htmlOptions'=>array('class'=>'well'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));

echo $form->textFieldRow($model, 'username', array('class'=>'span3'));
echo $form->passwordFieldRow($model, 'password', array('class'=>'span3'));
echo $form->checkboxRow($model, 'rememberMe');

?>

<div class="control-group">
<div class="controls">
<?php
$this->widget('bootstrap.widgets.TbButton', array(
  'buttonType'=>'submit',
  'label'=>'Вход'
));
?>
</div>
</div>  
<?php $this->endWidget(); ?>
</div><!-- form -->
