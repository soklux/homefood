<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'supplier_form',
    'method' => 'post',
    'action' => Yii::app()->createUrl('receivingItem/selectSupplier/'),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<div id="comment_content">
    <?php echo $form->textFieldControlGroup($model,'comment',array('rows'=>1, 'cols'=>10,'class'=>'span1','maxlength'=>250,'id'=>'comment_id')); ?>
</div>

<?php $this->endWidget(); ?>

