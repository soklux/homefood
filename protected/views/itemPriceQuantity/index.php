<?php
/* @var $this ItemPriceQuantityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Item Price Quantities',
);

$this->menu=array(
	array('label'=>'Create ItemPriceQuantity', 'url'=>array('create')),
	array('label'=>'Manage ItemPriceQuantity', 'url'=>array('admin')),
);
?>

<h1>Item Price Quantities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
