<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
<style>
.btn-group {
  display: flex !important;
}
</style>
<div id="report_container" class="row">
    <div class="col-xs-12 widget-container-col ui-sortable" id="report_main">


    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                      'title' => Yii::t('app','Sale Invoices'),
                      'headerIcon' => 'ace-icon fa fa-signal',
                      'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
        ));?>

        <?php if (Yii::app()->user->hasFlash('info')): ?>
            <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
        <?php endif; ?>

    <div id="report_header">

        <?php $this->renderPartial('_search',array('report'=>$report,'date_view'=>$date_view)); ?>

        <?php 
        $url = Yii::app()->createUrl('saleitem/receipt');
        $link = CHtml::link('Click this.', $url, array('target'=>'_blank'));
        ?>
    </div>

        <br>

    <div id="report_body">
        
            <?php $this->widget('EExcelView',array(
                    'id'=>'sale-grid',
                    'fixedHeader' => true,
                    //'responsiveTable' => true,
                    'type'=>TbHtml::GRID_TYPE_BORDERED,
                    'htmlOptions'=>array('class'=>'table-responsive panel'),
                    'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
                    'dataProvider'=>$report->saleInvoice(),
                    'summaryText' =>'<p class="text-info"> Invoice From ' . $from_date . ' To ' . $to_date . '</p>', 
                    'columns'=>array(
                            array('name'=>'id',
                                  'header'=>Yii::t('app','Invoice ID'),
                                  'value'=>'$data["id"]',
                            ),
                            array('name'=>'sale_time',
                                  'header'=>Yii::t('app','Sale Time'),
                                  'value'=>'$data["sale_time"]',
                                  //'value'=>'CHtml::link($data["sale_time"], Yii::app()->createUrl("saleitem/admin",array("id"=>$data["id"])))',
                                  //'type'=>'raw',
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
                            array('name'=>'quantity',
                                  'header'=>Yii::t('app','QTY'), 
                                  'value' =>'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                                  'htmlOptions'=>array('style' => 'text-align: right;'),
                                  'headerHtmlOptions'=>array('style' => 'text-align: right;'),
                            ),
                            array('name'=>'employee_id',
                                  'header'=>Yii::t('app','Sold By'), 
                                  'value'=>'$data["employee_name"]',
                            ),
                            array('name'=>'customer_id',
                                  'header'=>Yii::t('app','Sold To'), 
                                  'value'=>'$data["customer_name"]',
                            ),
                            array('name'=>'remark',
                                  'header'=>Yii::t('app','Remark'), 
                                  'value'=>'$data["remark"]',
                            ),
                            array('name'=>'status',
                                  'header'=>Yii::t('app','Status'), 
                                  'value'=>'$data["status_f"]',
                            ),
                            array('class'=>'bootstrap.widgets.TbButtonColumn',
                                  //'header'=>'Invoice Detail',
                                  'template'=>'<div class="btn-group">{view}{print}{cancel}{edit}</div>',
                                  //'htmlOptions'=>array('class'=>'hidden-phone visible-desktop btn-group'),
                                  'buttons' => array(
                                      'view' => array(
                                        'click' => 'updateDialogOpen',
                                        'label'=>'Detail',
                                        'url'=>'Yii::app()->createUrl("report/SaleInvoiceItem", array("sale_id"=>$data["id"],"employee_id"=>$data["employee_id"]))',
                                        'options' => array(
                                            'data-update-dialog-title' => Yii::t( 'app', 'Invoice Detail' ),
                                            //'class'=>'label label-important',
                                            'title'=>Yii::t('app','Invoice Detail'),
                                            'class'=>'btn btn-xs btn-info',
                                            'id'=>uniqid(),  
                                            'on'=>false,
                                        ),
                                        //'htmlOptions' => array('id'=>uniqid()),
                                      ),
                                      'print' => array(
                                        'label'=>'print',
                                        'icon'=>'glyphicon-print',
                                        'url'=>'Yii::app()->createUrl("saleItem/Receipt", array("sale_id"=>$data["id"]))',
                                        'options' => array(
                                            'target'=>'_blank',
                                            'title'=>Yii::t('app','Invoice Printing'),
                                            'class'=>'btn btn-xs btn-success',
                                        ), 
                                        'visible'=>'Yii::app()->user->checkAccess("invoice.print")',   
                                      ),
                                      'cancel' => array(
                                        'label'=>'cancel',
                                        'icon'=>'glyphicon-trash',
                                        'url'=>'Yii::app()->createUrl("sale/delete", array("id"=>$data["id"], "customer_id"=>$data["client_id"]))',
                                        'options' => array(
                                            'title'=>Yii::t('app','Cancel Invoice'),
                                            'class'=>'btnCancelInvoice btn btn-xs btn-danger',
                                        ),
                                        'visible'=>'$data["status"]=="1" && Yii::app()->user->checkAccess("invoice.delete")',
                                      ),
                                      'edit' => array(
                                        'label'=>'edit',
                                        'icon'=>'glyphicon-edit',
                                        'url'=>'Yii::app()->createUrl("SaleItem/EditSale", array("sale_id"=>$data["id"],"customer_id" => $data["customer_name"],"paid_amount"=>$data["paid_amount"]))',
                                        'options' => array(
                                            'title'=>Yii::t('app','Edit Invoice'),
                                            'class'=>'btn btn-xs btn-warning',
                                        ),
                                        'visible'=>'$data["status"]=="1" && Yii::app()->user->checkAccess("invoice.update")',
                                      ),
                                   ),
                             ),
                    ),
            )); ?> 
        
    </div>
    
    <?php $this->endWidget(); ?>    
    
    </div>
</div>

<div class="waiting"><!-- Place at bottom of page --></div>
  

