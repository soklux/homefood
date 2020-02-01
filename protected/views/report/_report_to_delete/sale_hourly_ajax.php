<?php $this->widget('yiiwheels.widgets.grid.WhGridView',array(
        'id'=>'sale-hourly-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->salehourly(),
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Hourly Sales') . Yii::t('app','On') . ':  ' . $to_date . '</p>', 
	'columns'=>array(
		array('name'=>'hours',
                      'header'=>Yii::t('app','Hour'),
                      'value'=>'$data["hours"]'
                ),
                array('name'=>'qty',
                      'header'=>Yii::t('app','Quantity'),
                      'value'=>'number_format($data["qty"],Common::getDecimalPlace(), ".", ",")',
                      'footer'=>number_format($report->saleHourlyTotalQty(),Common::getDecimalPlace(), ".", ","),
                ),
		array('name'=>'amount',
                      'header'=>Yii::t('app','Amount'),
                      'value'=>'number_format($data["amount"],Common::getDecimalPlace(), ".", ",")',
                      'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleHourlyTotalAmount(),Common::getDecimalPlace(), ".", ","),
                ),
	),
)); ?>