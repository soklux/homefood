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
              'title' => $client_name,
              'headerIcon' => 'ace-icon fa fa-credit-card',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
)); ?>    
    
    <div class="sidebar-nav" id="client_cart">
        <div class="form-group">
            <label class="col-sm-3 control-label required" for="SalePayment_payment_amount">  </label>
            <div class="col-sm-9">
                <span style="font-size:18px;font-weight:bold;color:brown">
                    <?php echo TbHtml::link(ucwords($client_name),'#', array(
                        'class'=>'update-dialog-open-link',
                        'data-update-dialog-title' => Yii::t('app','Customer Information'),
                    )); ?>
                   
                <?php echo '(' . Yii::t('app','Total Due') . ' : ' . number_format($balance,Common::getDecimalPlace()) . ' )'; ?>
                    
                </span>    
                
            </div>
        </div>
    </div>

    <?php $this->renderPartial('partial/_invoice_payment_sub', array('model' => $model, 'client_id' => $client_id, 'balance' => $balance)); ?>
        
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