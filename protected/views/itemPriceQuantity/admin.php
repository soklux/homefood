<?php
/* @var $this ItemPriceQuantityController */
/* @var $model ItemPriceQuantity */

$this->breadcrumbs=array(
	'Item Price Quantities'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ItemPriceQuantity', 'url'=>array('index')),
	array('label'=>'Create ItemPriceQuantity', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#item-price-quantity-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Item Price Quantities</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-price-quantity-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'item_id',
		'from_quatity',
		'to_quantity',
		'unit_price',
		'start_date',
		/*
		'end_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
