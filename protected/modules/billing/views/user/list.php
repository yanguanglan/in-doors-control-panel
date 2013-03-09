<?php
/* @var $this BillingController */

$this->pageTitle=Yii::app()->name;

Yii::app()->clientScript->registerScript('search', "
$('.extended-search').click(function(){
	$('.search-form').toggle();
	return false;
});
/*
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('post-grid', {
		data: $(this).serialize()
	});
	return false;
});
*/
");
?>

<h4>Пользователи</h4>
<?php echo CHtml::link('Расширенный поиск', '#', array('class'=>'extended-search')); ?>
<div class="search-form wide form" style="display:none">
<?php 
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions'=>array('class'=>'well'),
));

echo $form->textFieldRow($formModel, 'login', array('class'=>'span2'));
echo $form->textFieldRow($formModel, 'full_name', array('class'=>'span4'));
echo $form->textFieldRow($formModel, 'actual_address', array('class'=>'span6'));
echo $form->textFieldRow($formModel, 'ip', array('hint' => 'По IP ищет только тех, кто подключен <b>без</b> VPN', 'class' => 'span2'));
?>
<div class="control-group">
<div class="controls">
<?php
$this->widget('bootstrap.widgets.TbButton', array(
  'buttonType'=>'submit',
  'type' => 'primary',
  'htmlOptions'=>array('name'=>'search'),
  'label'=>'Найти'
));
/*
$this->widget('bootstrap.widgets.TbButton', array(
  'buttonType'=>'reset',
  'label'=>'Очистить'
));
*/
?>
</div>
</div>  
<?php
$this->endWidget();
?>
</div><!-- search-form -->

<div>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
  'dataProvider' => $dataProvider,
//  'template' => "{summary}\n{pager}\n{items}\n{pager}",
  'columns' => array(
    array(
      'name' => 'Логин',
      'value' => '$data["login"]',
    ),
    array(
      'name' => 'Полное имя',
      'value' => '$data["full_name"]',
    ),
    array(
      'name' => 'Фактический адрес',
      'value' => '$data["actual_address"]',
    ),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
      'template' => '{view}',
      'buttons' => array(
        'view' => array(
          'label' => 'Подробнее...',
          'visible'=>'true;',
          'url' => 'Yii::app()->createUrl("billing/user/info", array("id" => $data["id"]))',
        ),
      ),
		),
  ),
)); ?>
</div>
