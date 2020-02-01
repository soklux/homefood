<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'tax-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>true,
            'validateOnType'=>true,
        ),
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'tax_name',array('span'=>5,'maxlength'=>128)); ?>

            <?php echo $form->textFieldControlGroup($model,'rate',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->