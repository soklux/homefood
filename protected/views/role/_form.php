<div class="col-xs-12 widget-container-col" id="widget-container-col-2">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'role-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?= $form->textFieldControlGroup($model,'name',array('class'=>'span3','maxlength'=>45)); ?>

    <?= $form->textAreaControlGroup($model, 'description', array('rows' => 2, 'cols' => 10, 'class' => 'span3')); ?>

    <?php
    $permission_items = array (
        array('header_title' => 'Item',
                'grid_items' => array (
                      array('grid_title' => 'Item',  'permission' => 'item', 'control_name' => 'items'),
                      array('grid_title' => 'Price Book', 'permission' => 'pricebook', 'control_name' => 'pricebooks'),
                      array('grid_title' => 'Category', 'permission' => 'category', 'control_name' => 'categories'),
                ),
        ),
        array('header_title' => 'Sale',
            'grid_items' => array (
                array('grid_title' => 'Item',  'permission' => 'item', 'control_name' => 'items'),
                array('grid_title' => 'Price Book', 'permission' => 'pricebook', 'control_name' => 'pricebooks'),
                array('grid_title' => 'Category', 'permission' => 'category', 'control_name' => 'categories'),
            )
        ),
    );

    ?>

    <?php /*foreach($permission_items as $key => $value): */?><!--

        <?php /*$this->renderPartial('//role/_permission', array(
                'user' => $model,
                'header_title' => $value['header_title'],
                'grid_items' => $value['grid_items']
            ));
        */?>

    --><?php /*endforeach */?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
        )); ?>
    </div>

<?php $this->endWidget(); ?>
</div>



