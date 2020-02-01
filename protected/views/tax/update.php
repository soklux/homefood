<?php
$this->breadcrumbs=array(
    Yii::t('app','Tax')=>array('admin'),
    Yii::t('app','Update'),
);
?>

<?php if( Yii::app()->user->hasFlash('warning') || Yii::app()->user->hasFlash('success') ):?>
    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php endif; ?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Update Tax'),
    'headerIcon' => 'ace-icon fa fa-taxi',
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array('model'=>$model), true),
)); ?>

<?php $this->endWidget(); ?>