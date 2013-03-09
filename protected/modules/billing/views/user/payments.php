<?php

$this->pageTitle=Yii::app()->name . ' - Платежи';

$this->breadcrumbs = array('Платежи');

?>

<?php

$this->widget('bootstrap.widgets.TbGridView', array(
  'type' => 'striped bordered condensed',
  'template' => '{items}',
  'dataProvider' => $dataProvider,
  'columns' => array(
    array(
      'name' => 'Метод',
      'value' => '$data["method"]',
    ),
    array(
      'name' => 'Сумма',
      'value' => '$data["pay"]',
    ),
    array(
      'name' => 'Валюта',
      'value' => '$data["curr"]',
    ),
    array(
      'name' => 'Фактически',
      'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy в HH:mm", $data["actual_date"])',
    ),
  ),
));

?>
