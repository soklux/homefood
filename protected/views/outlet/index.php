<?php
/* @var $this OutletController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Outlets',
);

$this->menu=array(
	array('label'=>'Create Outlet','url'=>array('create')),
	array('label'=>'Manage Outlet','url'=>array('admin')),
);
?>

<h1>Outlets</h1>

<?php $this->widget('\TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>