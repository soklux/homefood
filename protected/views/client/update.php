<?php
$this->breadcrumbs=array(
	Yii::t('app','Customer')=>array('admin'),
	Yii::t('app','Update'),
);
?>

<?php if( Yii::app()->user->hasFlash('warning') || Yii::app()->user->hasFlash('success') ):?>
    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php endif; ?> 

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Update Customer'),
              'headerIcon' => 'ace-icon fa fa-user',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_form', array('model'=>$model, 'contact' => $contact, 'has_error' => $has_error,'client_image'=>$client_image), true),
 )); ?>  

<?php $this->endWidget(); ?>