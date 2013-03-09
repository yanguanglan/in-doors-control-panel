<?php
/* @var $this HubController */

$this->pageTitle=Yii::app()->name . ' / Хаб / Общий чат';

?>

<h4>Просмотр сообщений общего чата</h4>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
  'ajaxUpdate' => false,
	'columns'=>array(
		array(
      'name'=>'date',
      'type' => 'raw',
      'value'=>'Yii::app()->dateFormatter->format("yyyy-MM-dd&nb\'s\'p;HH:mm:ss", $data->date)',
      'sortable' => false,
      
      'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(  
                                'model'=>$model,   
                                'attribute'=>'date',  
                                'language'=>'ru',  
                                'options'=>array(  
                                        'showAnim'=>'fold',  
                                        'dateFormat'=>'yy-mm-dd',  
                                        'changeMonth' => 'true',  
                                        'changeYear'=>'true',  
                                        'showButtonPanel' => 'true',  
                                ),),true),
       
    ),
		array(
      'name'=>'ip',
      'type' => 'raw',
      'value'=>'long2ip($data->ip);',
      'sortable' => false,
    ),
		array(
      'name' => 'nick',
      'type' => 'text',
      'sortable' => false,
    ),
    array(
      'name' => 'msg',
      'type' => 'text',
      'sortable' => false,
    ),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
      'template' => '{update}{delete}',
      'visible' => Yii::app()->user->name==="admin",
      'buttons' => array(
        'update' => array(
          'label' => 'Изменить',
          'url' => 'Yii::app()->createUrl("hub/chat/update", array("id" => $data->id))',
        ),
        'delete' => array(
          'label' => 'Удалить',
          'url' => 'Yii::app()->createUrl("hub/chat/delete", array("id" => $data->id))',
        ),
      ),
		),
  ),
)); ?>
