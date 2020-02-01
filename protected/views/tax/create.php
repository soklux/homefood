<?php
$this->breadcrumbs=array(
    Yii::t('app','Tax')=>array('admin'),
    Yii::t('app','Create'),
);
?>

<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Create Tax'),
    'headerIcon' => 'ace-icon fa fa-taxi',
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array('model'=>$model), true),
)); ?>

<?php $this->endWidget(); ?>