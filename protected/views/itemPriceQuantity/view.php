<?php
/* @var $this ItemPriceQuantityController */
/* @var $model ItemPriceQuantity */

$this->breadcrumbs=array(
	'Item Price Quantities'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ItemPriceQuantity', 'url'=>array('index')),
	array('label'=>'Create ItemPriceQuantity', 'url'=>array('create')),
	array('label'=>'Update ItemPriceQuantity', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ItemPriceQuantity', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ItemPriceQuantity', 'url'=>array('admin')),
);
?>

<h1>View ItemPriceQuantity #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_id',
		'from_quatity',
		'to_quantity',
		'unit_price',
		'start_date',
		'end_date',
	),
)); ?>
