<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'supplier_selected_form',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'action'=>Yii::app()->createUrl('receivingPayment/removeSupplier/'),
)); ?>
 
        <div class="">
            <label class="col-sm-3 control-label required" for="SalePayment_payment_amount">  </label>
            <div class="col-sm-9">
                <span style="font-size:20px;font-weight:bold;color:brown">
                    <?php echo TbHtml::link(ucwords($fullname),$this->createUrl('supplier/view/',array('id'=>$supplier_id)), array(
                        'class'=>'update-dialog-open-link',
                        'data-update-dialog-title' => Yii::t('app','Supplier Information'),
                    )); ?>
                
                <?php echo '( ' . Yii::t('app','Total Due') . ' : ' . number_format($balance,Common::getDecimalPlace()) . ' )'; ?>
                    
                </span>    
                
                <?php echo TbHtml::linkButton(Yii::t( 'app', '' ),array(
                    'color'=>TbHtml::BUTTON_COLOR_WARNING,
                    'size'=>TbHtml::BUTTON_SIZE_MINI,
                    'icon'=>'glyphicon-remove white',
                    'class'=>'btn btn-sm detach-supplier',
                )); ?>
            </div>
        </div>
        
        <br /> <br /> <br>
        
<?php $this->endWidget(); ?>
