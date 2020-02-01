<?php
/* @var $this UnitMeasurableController */
/* @var $model UnitMeasurable */
?>

<?php
$this->breadcrumbs=array(
	'Unit Measurables'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UnitMeasurable', 'url'=>array('index')),
	array('label'=>'Create UnitMeasurable', 'url'=>array('create')),
	array('label'=>'Update UnitMeasurable', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UnitMeasurable', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UnitMeasurable', 'url'=>array('admin')),
);
?>

<h1>View UnitMeasurable #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'name',
		'created_at',
		'updated_at',
	),
)); ?>