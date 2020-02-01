<?php
/* @var $this CustomerGroupController */
/* @var $model CustomerGroup */
?>

<?php
$this->breadcrumbs=array(
	'Customer Groups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerGroup', 'url'=>array('index')),
	array('label'=>'Create CustomerGroup', 'url'=>array('create')),
	array('label'=>'View CustomerGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomerGroup', 'url'=>array('admin')),
);
?>

    <h1>Update CustomerGroup <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>