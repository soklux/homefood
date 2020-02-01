<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'supplier_form',
            'method'=>'post',
            'action' => Yii::app()->createUrl('receivingPayment/selectSupplier/'),
            'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>
    
        <div class="">
            <label class="col-sm-3 control-label required"  for="SalePayment_client"><?php echo Yii::t('app','Search Supplier'); ?> </label>
            <div class="col-sm-9">
                <?php 
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model'=>$model,
                            'attribute'=>'supplier_id',
                            'source'=>$this->createUrl('request/suggestSupplier'),
                            'htmlOptions'=>array(
                                'size'=>'60',
                                'placeholder'=>Yii::t('app','Type Name or Phone Number'),
                            ),
                            'options'=>array(
                                'showAnim'=>'fold',
                                'minLength'=>'1',
                                'delay' => 10,
                                'autoFocus'=> false,
                                'select'=>'js:function(event, ui) {
                                    event.preventDefault();
                                    $("#ReceivingPayment_supplier_id").val(ui.item.id);
                                    $("#supplier_form").ajaxSubmit({target: "#payment_container", beforeSubmit: paymentBeforeSubmit, success : scannedSuccess});
                                }',
                            ),
                        ));
                ?>
            </div>
        </div>
        <br /> <br /> <br>
         
<?php $this->endWidget(); ?>

