<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
</head>

<body>

<?php
$this->widget('bootstrap.widgets.TbNavbar',array(
  'type' => 'inverse',
  'brand' => CHtml::encode(Yii::app()->name),
  'brandUrl' => Yii::app()->createAbsoluteUrl('/site/index'),
  'collapse' => true,
  'items' => array(
    array(
      'class' => 'bootstrap.widgets.TbMenu',
      'items' => array(
        array('label'=>'Биллинг', 'url'=>array('/billing/user/list'), 'visible'=>!Yii::app()->user->isGuest),
        array('label'=>'VPN', 'url' => '#', 'items' => array(
          array('label'=>'Текущие сессии', 'url'=>array('/vpn/sessions/index')),
          array('label'=>'RADIUS Ошибки', 'url'=>array('/vpn/log/radius')),
          array('label'=>'Состояние сервера', 'url'=>array('/vpn/state/index'), 'visible'=>(Yii::app()->user->name === "admin")),
        ), 'visible'=>!Yii::app()->user->isGuest),
        array('label'=>'Хаб', 'url'=>array('/hub/chat/history'), 'visible'=>!Yii::app()->user->isGuest),
        array('label'=>'Лог', 'url'=>array('/sitelog/index'), 'visible'=>(Yii::app()->user->name === "admin")),
        array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
        array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
      ),
    ),
  ),
));
?>


<?php echo $content; ?>


</body>

</html>
