<div class="wizard-actions">
    <!-- <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        //'size'=>TbHtml::BUTTON_SIZE_SMALL,
    )); ?>
    <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        //'size'=>TbHtml::BUTTON_SIZE_SMALL,
    )); ?>
    <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        //'size'=>TbHtml::BUTTON_SIZE_SMALL,
    )); ?>
    <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        //'size'=>TbHtml::BUTTON_SIZE_SMALL,
    )); ?> -->
    <button type="submit" class="btn btn-primary" onClick="saveItem()">Save</button>
    <?php echo CHtml::ajaxSubmitButton('Save',CHtml::normalizeUrl(array('Item/SaveItem','render'=>true)),
        array(
            'dataType'=>'json',
            'type'=>'post',
            'success'=>'function(data) {
         $("#AjaxLoader").hide();  
        if(data.status=="success"){
         $("#formResult").html("form submitted successfully.");
         $("#item-form")[0].reset();
        }
         else{
        $.each(data, function(key, val) {
        $("#item-form #"+key+"_em_").html(val);                                                    
        $("#item-form #"+key+"_em_").show();
        });
        }       
    }',
            'beforeSend'=>'function(){                        
           $("#AjaxLoader").show();
      }'
        ),array('id'=>'mybtn','class'=>'btn btn-primary'));
    ?>
    

</div>
<style type="text/css">
        .item-name-error{
            margin-left: 120px;
            color:#ff0000;
        }
</style>