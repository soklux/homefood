<?php
$this->breadcrumbs=array(
    sysMenuItem() =>array('admin'),
    'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','New Item'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array(
            'model'=>$model,
            'cateId' => $cateId
    ), true),
)); ?>

<?php $this->endWidget(); ?>


<?php /*$this->renderPartial('_form', array(
    'model' => $model,
    'price_tiers' => $price_tiers,
    'item_price_quantity' => $item_price_quantity));
*/?>

<?php //$this->renderPartial('//layouts/partial/_form_js'); ?>
