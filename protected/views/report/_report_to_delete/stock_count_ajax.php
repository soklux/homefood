<div id="rpt-stockcount-grid">

<?php $this->widget('EExcelView',array(
	'id'=>'stockcount-grid',
        'fixedHeader' => true,
        'responsiveTable' => true,
        'type'=>TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$report->StockCount($filter),
        //'summaryText' =>'<p class="text-info" align="left">'. Yii::t("app","Inventories") .'</p>', 
        'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
	'columns'=>array(
		array('name'=>'name',
                      'header'=>Yii::t('app','Item Name'),
                      'value'=>'$data["name"]'
                ),
                array('name'=>'quantity',
                      'header'=>Yii::t('app','On Hand'),
                      'htmlOptions'=>array('style' => 'text-align: right;'),
                      'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'modified_date',
                      'header'=>Yii::t('app','Last Counted date'),
                      //'htmlOptions'=>array('style' => 'text-align: right;'),
                      //'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                ),
                array('name'=>'next_count_date',
                      'header'=>Yii::t('app','Next Schedule'),
                      //'htmlOptions'=>array('style' => 'text-align: right;'),
                      //'headerHtmlOptions'=>array('style' => 'text-align: right;'),
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

</div>
