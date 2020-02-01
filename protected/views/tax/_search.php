<?php
/* @var $this TaxController */
/* @var $model Tax */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'taxt_name',array('span'=>5,'maxlength'=>128)); ?>

                    <?php echo $form->textFieldControlGroup($model,'rate',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'status',array('span'=>5,'maxlength'=>1)); ?>

                    <?php echo $form->textFieldControlGroup($model,'created_at',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'updated_at',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'deleted_at',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'created_by',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'updated_by',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'deleted_by',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->