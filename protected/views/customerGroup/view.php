<?php
/* @var $this CustomerGroupController */
/* @var $model CustomerGroup */
?>

<?php
$this->breadcrumbs=array(
	'Customer Groups'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CustomerGroup', 'url'=>array('index')),
	array('label'=>'Create CustomerGroup', 'url'=>array('create')),
	array('label'=>'Update CustomerGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CustomerGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomerGroup', 'url'=>array('admin')),
);
?>

<h1>View CustomerGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'group_name',
		'status',
	),
)); ?>