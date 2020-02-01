<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'client_form',
            'method'=>'post',
            'action' => Yii::app()->createUrl('salePayment/SelectCustomer/'),
            'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>
    
        <div class="">
            <label class="col-sm-3 control-label required"  for="SalePayment_client">  Search Customer </label>
            <div class="col-sm-9">
                <?php 
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model'=>$model,
                            'attribute'=>'client_id',
                            'source'=>$this->createUrl('request/suggestClient'), 
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
                                    $("#SalePayment_client_id").val(ui.item.id);
                                    $("#client_form").ajaxSubmit({target: "#payment_container", beforeSubmit: paymentBeforeSubmit, success : clientScannedSuccess});
                                }',
                            ),
                        ));
                ?>
            </div>
        </div>
        <br /> <br /> <br>
         
<?php $this->endWidget(); ?>

