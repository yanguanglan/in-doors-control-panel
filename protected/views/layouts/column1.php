<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="container">

<?php if(isset($this->breadcrumbs)):?>
<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
  'links'=>$this->breadcrumbs,
)); ?>
<?php endif?>

<?php echo $content; ?>

<div id="footer">
  &copy; <?php echo date('Y'); ?> - ООО Волгоком.<br/>
</div><!-- footer -->

</div><!-- content -->

</div><!-- container -->

<?php $this->endContent(); ?>