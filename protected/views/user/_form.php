

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
    //'action'=>$this->createUrl('Item/Create'),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <?= $form->textFieldControlGroup($model,'email',array('class'=>'span3','maxlength'=>45)); ?>

    <?= $form->textFieldControlGroup($model,'user_name',array('class'=>'span3','maxlength'=>45)); ?>

    <?= $form->passwordFieldControlGroup($model,'password',array('class'=>'span4','maxlength'=>128,'placeholder'=>Yii::t('app','Password'),'autocomplete'=>'off','data-required'=>'true')); ?>

    <?= $form->passwordFieldControlGroup($model,'password_confirm',array('class'=>'span4','maxlength'=>128,'placeholder'=>Yii::t('app','Password'),'autocomplete'=>'off','data-required'=>'true')); ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
        )); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->