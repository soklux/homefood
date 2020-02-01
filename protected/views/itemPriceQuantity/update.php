<?php
/* @var $this ItemPriceQuantityController */
/* @var $model ItemPriceQuantity */

$this->breadcrumbs=array(
	'Item Price Quantities'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ItemPriceQuantity', 'url'=>array('index')),
	array('label'=>'Create ItemPriceQuantity', 'url'=>array('create')),
	array('label'=>'View ItemPriceQuantity', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ItemPriceQuantity', 'url'=>array('admin')),
);
?>

<h1>Update ItemPriceQuantity <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>