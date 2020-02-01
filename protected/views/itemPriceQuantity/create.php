<?php
/* @var $this ItemPriceQuantityController */
/* @var $model ItemPriceQuantity */

$this->breadcrumbs=array(
	'Item Price Quantities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ItemPriceQuantity', 'url'=>array('index')),
	array('label'=>'Manage ItemPriceQuantity', 'url'=>array('admin')),
);
?>

<h1>Create ItemPriceQuantity</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>