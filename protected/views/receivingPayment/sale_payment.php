<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'id'=>'sale-payment-grid',
        'type' => 'striped',
	'dataProvider'=>$model->search($id),
	//'filter'=>$model,
        'template'=>"{items}",
	'columns'=>array(
		//'id',
		array('name'=>'sale_id',
                      'header'=>Yii::t('app','Invoice ID'),
                ),
		'payment_type',
		'payment_amount',
		'give_away',
		'date_paid',
		/*
		'note',
		'modified_date',
		*/
	),
)); ?>