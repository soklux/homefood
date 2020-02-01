<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'invoice_selected_form',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'action'=>Yii::app()->createUrl('salePayment/removeInvoice/'),
)); ?>
 
        <div class="">
            <label class="col-sm-3 control-label required" for="SalePayment_sale_id">  </label>
            <div class="col-sm-9">
                <span style="font-size:16px;font-weight:bold;color:orangered">
                    <?php echo TbHtml::link('Invoice ID #' . $sale_id,$this->createUrl('Report/SaleInvoiceItem/',array('sale_id'=>$sale_id , 'employee_id' => $employee_id)), array(
                        'class'=>'update-dialog-open-link',
                        'data-update-dialog-title' => Yii::t('app','Invoice Detail'),
                    )); ?>

                   <?=  ' [ Balance : ' . $invoice_balance . ' ]' ?>
                    
                </span>    
                
                <?php echo TbHtml::linkButton(Yii::t( 'app', '' ),array(
                    'color'=>TbHtml::BUTTON_COLOR_WARNING,
                    'size'=>TbHtml::BUTTON_SIZE_MINI,
                    'icon'=>'glyphicon-remove white',
                    'class'=>'btn btn-sm detach-invoice',
                )); ?>
            </div>
        </div>
        
        <br /> <br />
        
<?php $this->endWidget(); ?>
