<?php
$this->breadcrumbs=array(
    'Price Book' =>array('/priceBook/admin'),
    'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','New Price Book'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'headerButtons' => array(
        TbHtml::buttonGroup(
            array(
                array('label' => Yii::t('app','Cancel'),'url' => Yii::app()->createUrl('/priceBook/admin'),'icon'=>'fa fa-window-close  white','id'=>'btn-review'),
            ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        ),
    ),
    'content' => $this->renderPartial('_form', array(
            'model' =>$model,
            'outlet' =>$outlet,
            'items' =>$items,
            'customer_group' => $customer_group,
    ), true),
)); ?>

<?php $this->endWidget(); ?>

