<?php
/* @var $this UnitMeasurableController */
/* @var $model UnitMeasurable */
?>

<?php
$this->breadcrumbs=array(
	'Unit Measurables'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UnitMeasurable', 'url'=>array('index')),
	array('label'=>'Manage UnitMeasurable', 'url'=>array('admin')),
);
?>

<h1>Create UnitMeasurable</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>