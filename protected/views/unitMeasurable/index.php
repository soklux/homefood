<?php
/* @var $this UnitMeasurableController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Unit Measurables',
);

$this->menu=array(
	array('label'=>'Create UnitMeasurable','url'=>array('create')),
	array('label'=>'Manage UnitMeasurable','url'=>array('admin')),
);
?>

<h1>Unit Measurables</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>