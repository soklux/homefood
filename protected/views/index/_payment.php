<?php
$this->breadcrumbs=array(
	Yii::t('app','Payment')=>array('salePayment/index'),
	Yii::t('app','Index'),
);

?>

<div id="payment_container">
    
    <?php $this->renderPartial('_search', array('model' => $model,)); ?>
 
    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                  'title' => Yii::t('app','Payment') . ' :  '  .  $cust_fullname,
                  'headerIcon' => 'ace-icon fa fa-credit-card',
                  'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    )); ?>    

        <?php
        if (isset($warning)) {
            echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, $warning);
        }
        ?>

        <div class="row">
            <div class="sidebar-nav" id="client_cart">
                <?php  
                    if ($cust_fullname=='') {
                        $this->renderPartial('_client', array('model' => $model)); 
                    } else {
                        $this->renderPartial('_client_selected', array('model' => $model, 
                                'balance' => $balance,
                                'client_id' => $client_id,
                                'cust_fullname' => $cust_fullname
                                )
                        ); 
                    }
                ?>
            </div>
        </div>

        <div id="sale_payment_cart">

            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'sale-payment-form',
                    'enableAjaxValidation'=>false,
                    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'action' => $this->createUrl('savepayment'),
            )); ?>

                    <?php //echo $form->errorSummary($model); ?>

                    <?php //echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR,''); ?>

                    <?php //echo $form->textFieldControlGroup($model,'total_due',array('class'=>3,'disabled'=>true,'value'=>$balance)); ?>

                    <?php echo $form->textFieldControlGroup($model,'payment_amount',array('class'=>'3 payment-amount-txt','autocomplete'=>'off')); ?>

                    <?php //echo $form->textFieldControlGroup($model,'date_paid',array('value'=>date('d-m-Y H:i:s'),'span'=>3,'disabled'=>true)); ?>

                    <?php echo $form->textAreaControlGroup($model,'note',array('rows'=>1,'class'=>2)); ?>

                    <div class="form-group form-actions">
                        <label class="col-sm-3 control-label required" for="SalePayment_payment_amount"> </label>
                        <div class="col-sm-9">    
                            <?php
                                echo TbHtml::linkButton(Yii::t('app', 'Save'), array(
                                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                                    //'icon' => 'glyphicon glyphicon-off white',
                                    //'url' => Yii::app()->createUrl('SaleItem/CompleteSale/'),
                                    'class' => 'save-payment',
                                    'id' => 'save_payment_button',
                                    'disabled' => $save_button,
                                    'title' => Yii::t('app', 'Save Payment'),
                            )); ?> 
                        </div>
                    </div>

            <?php $this->endWidget(); ?>
                
    </div>
    
    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs',
        'placement'=>'above', // 'above', 'right', 'below' or 'left'
        'tabs'=>array(
            array('label'=>Yii::t('app','Outstanding Invoice'),'id'=>'tab_1', 'content'=>$this->renderPartial('_invoice', array('model'=>$model,'client_id'=>$client_id,'balance'=>$balance),true),'active'=>true),
            array('label'=>Yii::t('app','Paid Invoice'),'id'=>'tab_2', 'content'=>$this->renderPartial('_invoice_his', array('model'=>$model,'client_id'=>$client_id,'balance'=>$balance),true)),
            array('label'=>Yii::t('app','Payment History'),'id'=>'tab_3', 'content'=>$this->renderPartial('_sale_payment', array('model'=>$model,'client_id'=>$client_id,'balance'=>$balance),true)),            
        ),
        //'events'=>array('shown'=>'js:loadContent')
    )); ?>
        
  <?php $this->endWidget(); ?>
    
    <?php if ($cust_fullname=='') { ?>     
        <?php Yii::app()->clientScript->registerScript('setFocus', '$("#SalePayment_client_id").focus();'); ?>
    <?php } ?>
                
</div><!-- form -->

<div class="waiting"><!-- Place at bottom of page --></div>