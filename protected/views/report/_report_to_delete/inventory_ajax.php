<?php $this->widget('EExcelView',array(
	'id'=>'rpt-inventory-grid',
        'fixedHeader' => true,
        //'responsiveTable' => true,
        'htmlOptions'=>array('class'=>'table-responsive panel'),
        'type'=> 'bordered striped',
	'dataProvider'=>$report->inventory($filter),
        //'summaryText' =>'<p class="text-info" align="left">'. Yii::t("app","Inventories") .'</p>', 
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'columns'=>array(
		array('name'=>'name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["name"]'
                ),
                array('name'=>'supplier',
                      'header'=>Yii::t('app','Supplier'),
                      'value'=>'$data["supplier"]'
                ),
                array('name'=>'unit_price',
                      'header'=>Yii::t('app','Retail Price'),
                      'value'=>'$data["unit_price"]',
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
		array('name'=>'quantity',
                      'header'=>Yii::t('app','On Hand'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'cost_price',
                      'value'=>'$data["cost_price"]',
                      'header'=>Yii::t('app','Average Cost'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                 array('name'=>'reorder_level',
                      'value'=>'$data["reorder_level"]',
                      'header'=>Yii::t('app','Reorder Qty'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                /*
		array('class'=>'bootstrap.widgets.TbButtonColumn',
                      //'header'=>'Invoice Detail',
                      'template'=>'{detail}',
                      'htmlOptions'=>array('width'=>'10px'),
                      'buttons' => array(
                          'detail' => array(
                            'click' => 'updateDialogOpen',
                            'label'=>Yii::t('app','details'),
                            'url'=>'Yii::app()->createUrl("Inventory/admin", array("item_id"=>$data["id"]))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t( 'app', 'Stock History' ),
                                'class'=>'label label-important',
                                'title'=>'Inventory Details',
                              ), 
                          ),
                       ),
                 ),
                 * 
                 */
	),
)); ?>