<?php
$this->breadcrumbs=array(
    t('Item','app') =>array('admin'),
    'Finder',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Item Finder'),
    'headerIcon' => sysMenuItemFinderIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_tree_view', array(
            'model'=>$model,
            // 'priceQty'=>$priceQty
    ), true),
)); ?>

<?php $this->endWidget(); ?>

