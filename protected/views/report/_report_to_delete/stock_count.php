<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Stock Counting'),
              'headerIcon' => 'ace-icon fa fa-signal',
              'headerButtons' => array(
                    TbHtml::buttonGroup(
                        array(
                            array('label' => Yii::t('app','Print & Sign'),'url' =>Yii::app()->createUrl('report/StockCountPrint/'),'icon'=>'ace-icon fa fa-print white'),
                        ),array('color'=>TbHtml::BUTTON_COLOR_PRIMARY,'size'=>TbHtml::BUTTON_SIZE_SMALL)
                    ),
              ),
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));?>

<?php $this->widget('bootstrap.widgets.TbNav', array(
        'type' => TbHtml::NAV_TYPE_PILLS,
        'htmlOptions'=>array('class'=>'btn-stockcount-opt'),
        'items' => array(
            array('label'=>Yii::t('app','Daily'), 'url'=>Yii::app()->urlManager->createUrl('report/StockCount',array('filter'=>1)),'active'=>true),
            array('label'=>Yii::t('app','Weekly'), 'url'=>Yii::app()->urlManager->createUrl('report/StockCount',array('filter'=>7))),
            array('label'=>Yii::t('app','Bi-Weekly'), 'url'=>Yii::app()->urlManager->createUrl('report/StockCount',array('filter'=>14))),
            array('label'=>Yii::t('app','Monthly'), 'url'=>Yii::app()->urlManager->createUrl('report/StockCount',array('filter'=>30))),
            array('label'=>Yii::t('app','All'), 'url'=>Yii::app()->urlManager->createUrl('report/StockCount',array('filter'=>'all'))),
            //array('label'=>'|', 'url'=>'#'),
            /*array('label'=>Yii::t('app','Fast Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'negative'))),
            array('label'=>Yii::t('app','Slow Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'negative'))),
            array('label'=>Yii::t('app','Non Moving'), 'url'=>Yii::app()->urlManager->createUrl('report/Inventory',array('filter'=>'negative'))),
             * 
            */
        ),
)); ?>

<?php
if (isset($warning)) {
    echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, $warning);
}
?>


<?php //$this->widget( 'ext.modaldlg.EModalDlg' ); ?>

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

<?php $this->endWidget(); ?>

<?php 
    Yii::app()->clientScript->registerScript( 'stockcountViewOption', "
        jQuery( function($){
            $('.btn-stockcount-opt li a').on('click', function(e) {
                e.preventDefault();
                var current_link=$(this);
                var url=current_link.attr('href');
                current_link.parent().parent().find('.active').removeClass('active');
                current_link.parent().addClass('active').css('font-weight', 'bold');
                $.ajax({url: url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                  $('#rpt-stockcount-grid').html(data.div);
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
                          }
                    });
                });
        });
      ");
 ?>

<div class="waiting"><!-- Place at bottom of page --></div>