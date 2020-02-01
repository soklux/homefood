<?php
$this->breadcrumbs=array(
	'Outlets'=>array('admin'),
	$model->id,
);

?>

<h1>View Outlet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'outlet_name',
		'tax_id',
		'address1',
		'address2',
		'village_id',
		'commune_id',
		'district_id',
		'city_id',
		'country_id',
		'state',
		'postcode',
		'email',
		'phone',
		'status',
		'created_at',
		'updated_at',
		'deleted_at',
	),
)); ?>