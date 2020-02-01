<?php
$this->breadcrumbs=array(
	Yii::t('app','User') => array('rbacUser/Update/'. $model->id),
	$model->id,
);

?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' =>Yii::t('app','View User') . ' : ' . '<span style="color:blue">' . ucwords($model->user_name) .'</span>',
              'headerIcon' => 'ace-icon fa fa-search',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
 )); ?>  

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_name',
		'group_id',
		'employee_id',
		//'user_password',
		'deleted',
		'status',
		'date_entered',
		'modified_date',
		'created_by',
	),
)); ?>

<?php $this->endWidget(); ?>