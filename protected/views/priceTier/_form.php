<div class="form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
            'id'=>'price-tier-form',
            'enableAjaxValidation'=>false,
            'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'tier_name',array('span'=>5,'maxlength'=>30)); ?>

            <?php //echo $form->textFieldControlGroup($model,'modified_date',array('span'=>5)); ?>

            <?php //echo $form->textFieldControlGroup($model,'deleted',array('span'=>5)); ?>

        <div class="form-actions">
            <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
	</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->