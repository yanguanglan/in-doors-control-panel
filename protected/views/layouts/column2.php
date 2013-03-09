<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="container">

<?php if(isset($this->breadcrumbs)):?>
<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
  'links'=>$this->breadcrumbs,
)); ?>
<?php endif?>

<div class="row">

<div class="span3">

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
  'title'=>'Operations',
));
$this->widget('zii.widgets.CMenu', array(
  'items'=>$this->menu,
  'htmlOptions'=>array('class'=>'operations'),
));
$this->endWidget();
?>

</div><!-- sidebar -->

<div class="span9">

<?php echo $content; ?>

</div><!-- content -->

</div>

</div><!-- content -->

<div id="footer">
  &copy; <?php echo date('Y'); ?> - ООО Волгоком.<br/>
</div><!-- footer -->

</div><!-- container -->

<?php $this->endContent(); ?>