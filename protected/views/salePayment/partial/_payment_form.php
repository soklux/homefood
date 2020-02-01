<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'sale-payment-form',
    'enableAjaxValidation'=>false,
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'action' => $this->createUrl('SavePayment'),
)); ?>

<?php //echo $form->textFieldControlGroup($model,'total_due',array('class'=>3,'disabled'=>true,'value'=>$balance)); ?>

<?php echo $form->textFieldControlGroup($model,'payment_amount',array('value' => $invoice_balance, 'class'=>'3 payment-amount-txt','autocomplete'=>'off')); ?>

<?php //echo $form->textFieldControlGroup($model,'date_paid',array('value'=>date('d-m-Y H:i:s'),'span'=>3,'disabled'=>true)); ?>

<?php echo $form->textAreaControlGroup($model,'note',array('rows'=>1,'class'=>2)); ?>

    <div class="form-group form-actions">
        <label class="col-sm-3 control-label required" for="SalePayment_payment_amount"> </label>
        <div class="col-sm-9">
            <?php
            echo TbHtml::linkButton(Yii::t('app', 'Save'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'class' => 'save-payment',
                'id' => 'save_payment_button',
                'disabled' => $save_button,
                'title' => Yii::t('app', 'Save Payment'),
            )); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>