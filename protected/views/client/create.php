<?php
$this->breadcrumbs=array(
    Yii::t('app','Customer')=>array('admin'),
    Yii::t('app','Create'),
);
?>

<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Create Customer'),
              'headerIcon' => 'ace-icon fa fa-user',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_form', array('model'=>$model, 'contact' => $contact, 'has_error' => $has_error,'client_image'=>isset($client_image) ? $client_image : array()), true),
 )); ?>  

<?php $this->endWidget(); ?>