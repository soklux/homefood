<?php
$this->breadcrumbs=array(
	'Rbac Users',
);

$this->menu=array(
	array('label'=>'Create RbacUser','url'=>array('create')),
	array('label'=>'Manage RbacUser','url'=>array('admin')),
);
?>

<h1>Rbac Users</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'rbac-user-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'user_name',
        'group_id',
        'employee_id',
        'user_password',
        'deleted',
        /*
        'status',
        'date_entered',
        'modified_date',
        'created_by',
        */
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
