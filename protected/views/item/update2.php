<?php
$this->breadcrumbs=array(
    sysMenuItem() =>array('admin'),
    'Update',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Update Item'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form_basic2', array(
            'model'=>$model,
            'brand' => $brand,
            'supplier' => $supplier,
            'measurable'=>$measurable,
            'categories'=>$categories,
            'product_types'=>$product_types,
            'product_models'=>$product_models,
            'item_image'=>$item_image,
            'image'=>$image
            ),
        true),
    'headerButtons' => array(
        TbHtml::buttonGroup(
            array(
                array('label' => Yii::t('app','Return Item'),
                    'url' =>Yii::app()->createUrl('Item/Admin'),
                    'icon'=>'ace-icon fa fa-undo white'
                ),
                array('label' => Yii::t('app','Previous'),
                    'url' =>Yii::app()->createUrl('Item/PreviousId',array(
                            'id' => $model->id)
                    ),
                    'icon'=>'ace-icon fa fa-arrow-left icon-on-left"',
                    'htmlOptions' => array('disabled' => $previous_disable),
                ),
                array('label' => Yii::t('app','Next'),
                    'url' =>Yii::app()->createUrl('item/NextId', array(
                            'id' => $model->id )
                    ),
                    'icon'=>'ace-icon fa fa-arrow-right icon-on-right"',
                    'htmlOptions' => array('disabled' => $next_disable)
                ),
            ),
            array('color'=>TbHtml::BUTTON_COLOR_INVERSE,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        ),
    )
)); ?>

<?php $this->endWidget(); ?>