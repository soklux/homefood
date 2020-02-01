<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Supplier Payment') => array('receivingPayment/index'),
    Yii::t('app', 'Index'),
);

?>

<div id="payment_container">
    
    <?php $this->renderPartial('_search', array('model' => $model,)); ?>
 
    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                  'title' => Yii::t('app','Supplier Payment') . ' :  '  .  $fullname,
                  'headerIcon' => 'ace-icon fa fa-credit-card',
                  'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    )); ?>    

        <?php
        if (isset($warning)) {
            echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, $warning);
        }
        ?>

        <div class="row">
            <div class="sidebar-nav" id="supplier_cart">
                <?php  
                    if ($fullname=='') {
                        $this->renderPartial('_supplier', array('model' => $model));
                    } else {
                        $this->renderPartial('_supplier_selected', array('model' => $model,
                                'balance' => $balance, 
                                'supplier_id' => $supplier_id,
                                'fullname' => $fullname
                                )
                        ); 
                    }
                ?>
            </div>
        </div>

        <div id="payment_cart">

            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'receiving-payment-form',
                    'enableAjaxValidation'=>false,
                    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'action' => $this->createUrl('savePayment'),
            )); ?>

                    <?php //echo $form->errorSummary($model); ?>

                    <?php //echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR,''); ?>

                    <?php //echo $form->textFieldControlGroup($model,'total_due',array('class'=>3,'disabled'=>true,'value'=>$balance)); ?>

                    <?php echo $form->textFieldControlGroup($model,'payment_amount',array('class'=>'3 payment-amount-txt','autocomplete'=>'off')); ?>

                    <?php //echo $form->textFieldControlGroup($model,'date_paid',array('value'=>date('d-m-Y H:i:s'),'span'=>3,'disabled'=>true)); ?>

                    <?php echo $form->textAreaControlGroup($model,'note',array('rows'=>1,'class'=>2)); ?>

                    <div class="form-group form-actions">
                        <label class="col-sm-3 control-label required" for="RecvPayment_payment_amount"> </label>
                        <div class="col-sm-9">    
                            <?php
                                echo TbHtml::linkButton(Yii::t('app', 'Save'), array(
                                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                                    //'icon' => 'glyphicon glyphicon-off white',
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
            array('label'=>Yii::t('app','Outstanding Invoices'),'id'=>'tab_1', 'content'=>$this->renderPartial('_invoice', array('model'=>$model,'supplier_id'=>$supplier_id,'balance'=>$balance),true),'active'=>true),
            array('label'=>Yii::t('app','Paid Invoice'),'id'=>'tab_2', 'content'=>$this->renderPartial('_invoice_his', array('model'=>$model,'supplier_id'=>$supplier_id,'balance'=>$balance),true)),
            array('label'=>Yii::t('app','Payment History'),'id'=>'tab_3', 'content'=>$this->renderPartial('_receive_payment', array('model'=>$model,'supplier_id'=>$supplier_id,'balance'=>$balance),true)),
        ),
        //'events'=>array('shown'=>'js:loadContent')
    )); ?>
        
  <?php $this->endWidget(); ?>
    
    <?php if ($fullname=='') { ?>
        <?php Yii::app()->clientScript->registerScript('setFocus', '$("#ReceivingPayment_supplier_id").focus();'); ?>
    <?php } ?>
                
</div><!-- form -->

<div class="waiting"><!-- Place at bottom of page --></div>