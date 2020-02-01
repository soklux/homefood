<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Item') => array('admin'),
    Yii::t('app', 'Create'),
);
?>

<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app', 'Create Item'),
    'headerIcon' => 'ace-icon fa fa-coffee',
    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form_image', array('model' => $model, 'price_tiers' => $price_tiers), true),
    'headerButtons' => array(
        TbHtml::buttonGroup(
            array(
                array(
                    'label' => Yii::t('app', ''),
                    'url' => Yii::app()->createUrl('Item/Admin'),
                    'icon' => 'ace-icon fa fa-undo white'
                ),
            ), array('color' => TbHtml::BUTTON_COLOR_INVERSE, 'size' => TbHtml::BUTTON_SIZE_SMALL)
        ),
    )
)); ?>

<?php $this->endWidget(); ?>
