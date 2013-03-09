<?php
/* @var $this LogController */

$this->pageTitle=Yii::app()->name . ' / RADIUS error log';

?>

<h4 class="pull-left">RADIUS error log</h4>
<div class="pull-right">
<form method="get">
<div class="input-append">
<?php
echo CHtml::dropDownList("lines", $count, array(
  '50' => '50', '100' => '100', '200' => '200'
), array('class' => 'span1', 'title' => 'Количество отображаемых строк'));
?>
<button class="btn" type="submit">&gt;</button>
</div>
</form>
</div>

<table class="table table-bordered table-condensed table-hover">
  <thead>
    <tr>
      <th>Тип</th>
      <th>Дата</th>
      <th>ID</th>
      <th>Подсистема</th>
      <th>Подробности</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($data as $row): ?>
    <?php if (isset($row['unknown'])): ?>
    <tr class="error" title="Неизвестная ошибка">
      <td colspan="5"><?php echo CHtml::encode($row['unknown']); ?></td>
    </tr>
    <?php else: ?>
    <?php
    switch ($row['type']) {
    case 'Warn':
      $rowClass = 'warning';
      break;
    case 'ERROR':
      $rowClass = 'error';
      break;
    default:
      $rowClass = 'info';
    }
    ?>
    <tr class="<?php echo $rowClass; ?>">
      <td><?php echo $row['type']; ?></td>
      <td><?php echo $row['date']; ?></td>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['subSystem']; ?></td>
      <td><?php echo CHtml::encode($row['details']); ?></td>
    </tr>
    <?php endif; ?>
  <?php endforeach; ?>
  </tbody>
</table>

