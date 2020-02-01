<?php
$this->breadcrumbs=array(
    Yii::t('app','Outlet')=>array('admin'),
    Yii::t('app','Create'),
);
?>

<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Create Outlet'),
    'headerIcon' => 'ace-icon fa fa-building',
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array('model'=>$model, 'tax' => $tax), true),
)); ?>

<?php $this->endWidget(); ?>