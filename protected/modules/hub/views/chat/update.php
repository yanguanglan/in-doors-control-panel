<?php
$this->pageTitle=Yii::app()->name.' - Редактирование сообщения';
$this->breadcrumbs = array('Хаб' => array('index'), 'Сообщение №' . $model->id);
?>

<!--<div><a href="<?php echo Yii::app()->request->getUrlReferrer(); ?>">Вернуться к списку</a></div>-->
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
));
?>

<fieldset>
<legend>Редактирование сообщения</legend>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->uneditableRow($model, 'id'); ?>
<?php echo $form->uneditableRow($model, 'date'); ?>
<?php echo $form->uneditableRow($model, 'ip'); ?>
<?php echo $form->uneditableRow($model, 'nick'); ?>
<?php echo $form->textAreaRow($model, 'msg', array('class'=>'span8', 'rows'=>5,
  'hint' => 'Актуально для истории "Последние сообщения чата"')); ?>
</fieldset>

<div class="control-group">
<div class="controls">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
      'buttonType'=>'submit',
      'label'=>'Сохранить'
    )); ?>
</div>
</div>
 
<?php $this->endWidget(); ?>
