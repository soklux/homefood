<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'receive_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'client_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'employee_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sub_total',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'payment_type',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textAreaRow($model,'remark',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
