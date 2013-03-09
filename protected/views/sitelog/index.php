<?php
/* @var $this SiteLogController */
/* @var $dataProvider CActiveDataProvider */
?>

<h4>Лог</h4>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
	'dataProvider' => $model->search(),
  'filter' => $model,
  'ajaxUpdate' => false,
	'columns'=>array(
    array(
      'name' => 'logtime',
      'type' => 'raw',
      'value' => 'Yii::app()->dateFormatter->format("yyyy.MM.dd&nb\'s\'p;HH:mm", $data->logtime)',
      'filter' => false,
    ),
    array(
      'name' => 'level',
      'filter' => array('info' => 'info', 'warning' => 'warning', 'error' => 'error'),
    ),
    'category',
    array(
      'name' => 'message',
      'type' => 'raw',
      'value' => 'nl2br(CHtml::encode($data->message))',
    ),
  ),
)); ?>
