<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'client_selected_form',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'action'=>Yii::app()->createUrl('salePayment/removeCustomer/'),
)); ?>
 
        <div class="">
            <label class="col-sm-3 control-label required" for="SalePayment_payment_amount">  </label>
            <div class="col-sm-9">
                <span style="font-size:20px;font-weight:bold;color:brown">
                    <?php echo TbHtml::link($client_name,$this->createUrl('Client/View/',array('id'=>$client_id)), array(
                        'class'=>'update-dialog-open-link',
                        'data-update-dialog-title' => Yii::t('app','Customer Information'),
                    )); ?>

                    <?php if ($balance==-3.14159) {  ?>
                        <?php echo 'The account was not setup, plz update first'; ?>
                    <?php } else {  ?>
                        <?php echo '( ' . Yii::t('app','Total Due') . ' : ' . number_format($balance,Common::getDecimalPlace()) . ' )'; ?>
                    <?php } ?>
                    
                </span>    
                
                <?php echo TbHtml::linkButton(Yii::t( 'app', '' ),array(
                    'color'=>TbHtml::BUTTON_COLOR_WARNING,
                    'size'=>TbHtml::BUTTON_SIZE_MINI,
                    'icon'=>'glyphicon-remove white',
                    'class'=>'btn btn-sm detach-customer',
                )); ?>
            </div>
        </div>
        
        <br /> <br /> <br>
        
<?php $this->endWidget(); ?>
