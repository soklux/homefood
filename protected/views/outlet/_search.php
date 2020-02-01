<?php
/* @var $this OutletController */
/* @var $model Outlet */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('\TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5,'maxlength'=>10)); ?>

                    <?php echo $form->textFieldControlGroup($model,'outlet_name',array('span'=>5,'maxlength'=>128)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tax_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'address1',array('span'=>5,'maxlength'=>128)); ?>

                    <?php echo $form->textFieldControlGroup($model,'address2',array('span'=>5,'maxlength'=>128)); ?>

                    <?php echo $form->textFieldControlGroup($model,'village_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'commune_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'district_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'city_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'country_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'state',array('span'=>5,'maxlength'=>128)); ?>

                    <?php echo $form->textFieldControlGroup($model,'postcode',array('span'=>5,'maxlength'=>10)); ?>

                    <?php echo $form->textFieldControlGroup($model,'email',array('span'=>5,'maxlength'=>128)); ?>

                    <?php echo $form->textFieldControlGroup($model,'phone',array('span'=>5,'maxlength'=>32)); ?>

                    <?php echo $form->textFieldControlGroup($model,'status',array('span'=>5,'maxlength'=>1)); ?>

                    <?php echo $form->textFieldControlGroup($model,'created_at',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'updated_at',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'deleted_at',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->