<?php
/* @var $this BillingController */

$this->pageTitle=Yii::app()->name.' - Информация о пользователе';

?>

<?php
//echo print_r($dataProvider, true);
?>

<div><a href="<?php echo Yii::app()->request->getUrlReferrer(); ?>">Вернуться к списку</a></div>

<?php if (!empty($data)): ?>
<div class="view">

<table class="table table-bordered">
<tbody>
<tr>
	<td>Идентификатор пользователя</td>
	<td><?php echo CHtml::encode($data->id); ?></td>
</tr>
<tr>
	<td>Полное имя</td>
	<td><?php echo CHtml::encode($data->full_name); ?></td>
</tr>
<tr>
	<td>Логин</td>
	<td><strong><?php echo CHtml::encode($data->login); ?></strong></td>
</tr>
<tr>
	<td>Пароль</td>
	<td><strong><?php echo CHtml::encode($data->password); ?></strong></td>
</tr>
<tr>
	<td>Фактический адрес</td>
	<td><?php echo CHtml::encode($data->actual_address); ?></td>
</tr>
<tr>
	<td>Домашний телефон</td>
	<td><?php echo CHtml::encode($data->home_telephone); ?></td>
</tr>
<tr>
	<td>Мобильный телефон</td>
	<td><?php echo CHtml::encode($data->mobile_telephone); ?></td>
</tr>
<tr>
	<td>E-Mail</td>
	<td><?php echo CHtml::encode($data->email); ?></td>
</tr>
<tr>
	<td>Дата подключения</td>
	<td><?php echo Yii::app()->dateFormatter->format('d MMMM yyyy', $data->connect_date); ?></td>
</tr>
<tr>
	<td>Идентификатор основного счёта</td>
	<td><?php echo CHtml::encode($data->basic_account); ?></td>
</tr>
<tr>
	<td>Баланс</td>
	<td><strong><?php echo CHtml::encode(round($data->basicAccount->balance, 2)); ?></strong> руб</td>
</tr>
<tr>
  <td>Подключенные тарифы</td>
  <td>
  <?php
  $atls = $data->basicAccount->tarifLinks;
  foreach ($atls as $atl) {
    echo $atl->tarif->name . "<br>";
  }
  ?>
  </td>
</tr>
<tr>
  <td>Подключенные услуги</td>
  <td>
  <?php
  $srvs = $data->serviceLinks;
  foreach ($srvs as $srv) {
//    echo $srv->id;
//    echo $srv->iptrafficServiceLink->id;
    $ipgrps = $srv->iptrafficServiceLink->ipGroups;
    foreach($ipgrps as $ipgrp) {
      //echo $ipgrp->ip_group_id;
      echo 'Имя: <b>' . CHtml::encode($ipgrp->uname) . '</b> Пароль: <b>' . CHtml::encode($ipgrp->upass) . '</b><br>';
    }
  }
  
  ?>
  </td>
</tr>
</tbody>
</table>

</div>
<?php endif; ?>
