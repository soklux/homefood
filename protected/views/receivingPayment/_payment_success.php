<?php
$this->breadcrumbs=array(
	Yii::t('app','Payment')=>array('salePayment/index'),
	Yii::t('app','Index'),
);

?>

<div class="form" id="payment_container">
 
<?php
 if (isset($warning)) {
     echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, $warning);
 }
 ?>    
    
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => $fullname,
              'headerIcon' => 'ace-icon fa fa-credit-card',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
)); ?>    
    
    <div class="sidebar-nav" id="client_cart">
        <div class="form-group">
            <label class="col-sm-3 control-label required" for="SalePayment_payment_amount">  </label>
            <div class="col-sm-9">
                <span style="font-size:18px;font-weight:bold;color:brown">
                    <?php echo TbHtml::link(ucwords($fullname),'#', array(
                        'class'=>'update-dialog-open-link',
                        'data-update-dialog-title' => Yii::t('app','Customer Information'),
                    )); ?>
                   
                <?php echo '(' . Yii::t('app','Total Due') . ' : ' . number_format($balance,Common::getDecimalPlace()) . ' )'; ?>
                    
                </span>    
                
            </div>
        </div>
    </div>

    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs',
        'placement'=>'above', // 'above', 'right', 'below' or 'left'
        'tabs'=>array(
            array('label'=>Yii::t('app','Outstanding Invoices'),'id'=>'tab_1', 'content'=>$this->renderPartial('_invoice', array('model'=>$model,'supplier_id'=>$supplier_id,'balance'=>$balance),true),'active'=>true),
            array('label'=>Yii::t('app','Paid Invoice'),'id'=>'tab_2', 'content'=>$this->renderPartial('_invoice_his', array('model'=>$model,'supplier_id'=>$supplier_id,'balance'=>$balance),true)),
            array('label'=>Yii::t('app','Payment History'),'id'=>'tab_3', 'content'=>$this->renderPartial('_receive_payment', array('model'=>$model,'supplier_id'=>$supplier_id,'balance'=>$balance),true)),
        ),
        //'events'=>array('shown'=>'js:loadContent')
    )); ?>
        
<?php $this->endWidget(); ?>
                            
</div><!-- form -->


<script>
$(document).ready(function () {
window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
    });
}, 2000); 
});
</script>