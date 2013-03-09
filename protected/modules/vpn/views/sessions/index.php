<?php
/* @var $this SessionsController */

$this->pageTitle=Yii::app()->name . ' / VPN сессии';

?>

<h4>Просмотр текущих VPN сессий</h4>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider,
  'ajaxUpdate' => false,
	'columns'=>array(
		array(
      'name' => 'Интерфейс',
      'type' => 'text',
      'value' => '$data["ifname"]',
    ),
		array(
      'name' => 'Имя',
      'type' => 'text',
      'value' => '$data["username"]',
    ),
		array(
      'name' => 'Вызывающий IP',
      'type' => 'text',
      'value' => '$data["csid"]',
    ),
    array(
      'name' => 'IP',
      'type' => 'text',
      'value' => '$data["ip"]',
    ),
    array(
      'name' => 'Скорость, Кбит',
      'type' => 'text',
      'value' => '$data["rate"]',
    ),
    array(
      'name' => 'Тип',
      'type' => 'raw',
      'value' => '$data["type"]',
    ),
    array(
      'name' => 'Состояние',
      'type' => 'text',
      'value' => '$data["state"]',
    ),
    array(
      'name' => 'Длительность',
      'type' => 'text',
      'value' => '$data["uptime"]',
    ),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
      'template' => '{delete}',
      'visible' => Yii::app()->user->name==="admin",
      'buttons' => array(
        'delete' => array(
          'label' => 'Разорвать',
          'url' => 'Yii::app()->createUrl("vpn/sessions/kill", array("ifname" => $data["ifname"]))',
        ),
      ),
		),
  ),
)); ?>
