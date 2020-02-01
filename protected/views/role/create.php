<?php

$this->breadcrumbs=array(
    'Role'=>array('Admin'),
    'Create',
);

?>


<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' =>Yii::t('app','Create Role'),
    'headerIcon' => 'ace-icon fa fa-user-circle-o',
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array('model' => $model), true),
)); ?>

<?php $this->endWidget(); ?>


<!--
<?php /*$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' =>Yii::t('app','Create Role'),
    'headerIcon' => 'ace-icon fa fa-user-circle-o',
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_table', array('model' => $model), true),
)); */?>

--><?php /*$this->endWidget(); */?>
