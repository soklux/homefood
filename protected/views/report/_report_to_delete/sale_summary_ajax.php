<?php $this->widget('EExcelView',array(
        'id'=>'sale-summary-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	    'dataProvider'=>$report->saleSummary(),
        //'filter'=>$filtersForm,
        'summaryText' =>'<p class="text-info" align="left">' . Yii::t('app','Sales Summary') . Yii::t('app','From') . ':  ' . $from_date . '  ' . Yii::t('app','To') . ':  ' . $to_date . '</p>', 
	    'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
        'columns'=>array(
		array('name'=>'no_of_invoice',
                      'header'=>Yii::t('app','No. of Invoices'),
                      'value'=>'$data["no_of_invoice"]',
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','Quantity Sold'),
                      'value' =>'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
		array('name'=>'sub_total',
                      'header'=>Yii::t('app','Sub Total'),
                      'value' =>'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'discount',
                      'header'=>Yii::t('app','Discount'),
                      'value' =>'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'total',
                      'header'=>Yii::t('app','Total'),
                      'value' =>'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
	),
)); ?>