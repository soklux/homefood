<?php
/* @var $this CustomerGroupController */
/* @var $model CustomerGroup */
?>

<?php
$this->breadcrumbs=array(
	'Customer Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerGroup', 'url'=>array('index')),
	array('label'=>'Manage CustomerGroup', 'url'=>array('admin')),
);
?>

<h1>Create CustomerGroup</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>