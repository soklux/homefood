<!-- <div>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-6 margin-3">
                        <div class="form-group">
                            <input type="hidden" class="txt-pro-id">
                            <label>Search Product</label>
                            <?php 
                                // $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                //         'model'=>$model,
                                //         'attribute'=>'item_id',
                                //         'source'=>$this->createUrl('request/suggestItemRecv'),
                                //         'htmlOptions'=>array(
                                //             'size'=>'12',
                                //             'class'=>'txt-pro-name form-control',
                                //             'onfocus'=>'this.select();'
                                //         ),
                                //         'options'=>array(
                                //             'showAnim'=>'fold',
                                //             'minLength'=>'1',
                                //             'delay' => 10,
                                //             'autoFocus'=> false,
                                //             'select'=>'js:function(event, ui) {
                                //                 event.preventDefault();
                                //                 $(".btn-count").prop("disabled",false);
                                //                 $(".txt-pro-name").val(ui.item.value);
                                //                 $(".txt-pro-id").val(ui.item.id);
                                //                 $(".txt-count").val(1);
                                //                 $(".txt-count").focus();
                                //                 // alert(ui.item.quantity)
                                //             }',
                                        ),
                                    ));
                                ?>
                        </div>
                    </div>
                    <div class="col-sm-3 margin-3">
                        <div class="form-group">
                            <label>Count</label>
                            <?php //echo CHtml::NumberField('InventoryCount','',array('class'=>'form-control txt-count','placeholder'=>'Count',)); ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <?php //echo CHtml::Button('Count',array('class'=>'btn btn-primary btn-count','onClick'=>'inventoryCount(1,"")','style'=>'margin-top:20px;'))?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div id="itemlookup" class="col-xs-12 col-sm-10">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('receivingItem/add'),
                'method'=>'post',
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
                'id'=>'add_item_form',
        )); ?>

            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute'=>'item_id',
                    'source'=>$this->createUrl('request/suggestItemRecv'),
                    'htmlOptions'=>array(
                        'size'=>'40'
                    ),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength'=>'1',
                        'delay' => 10,
                        'autoFocus'=> false,
                        'select'=>'js:function(event, ui) {
                            event.preventDefault();
                            $("#ReceivingItem_item_id").val(ui.item.id);
                            $("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: itemScannedSuccess(ui.item.id)});
                        }',
                    ),
                ));
            ?>

        <?php $this->endWidget(); ?>
    </div>