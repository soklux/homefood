<?php
/* @var $this CustomerGroupController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Customer Groups',
);

$this->menu=array(
	array('label'=>'Create CustomerGroup','url'=>array('create')),
	array('label'=>'Manage CustomerGroup','url'=>array('admin')),
);
?>

<h1>Customer Groups</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>