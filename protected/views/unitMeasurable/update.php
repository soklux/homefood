<?php
/* @var $this UnitMeasurableController */
/* @var $model UnitMeasurable */
?>

<?php
$this->breadcrumbs=array(
	'Unit Measurables'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UnitMeasurable', 'url'=>array('index')),
	array('label'=>'Create UnitMeasurable', 'url'=>array('create')),
	array('label'=>'View UnitMeasurable', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UnitMeasurable', 'url'=>array('admin')),
);
?>

    <h1>Update UnitMeasurable <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>