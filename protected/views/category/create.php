<?php
$this->breadcrumbs=array(
	'Categories'=>array('admin'),
	'Create',
);

$arr = Category::model()->buildTree($parent);
$option=Category::model()->buildOptions($arr,null);

?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app', 'New Category'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array(
        'model' => $model,
        'parent' => $parent,
        'arr' => $arr,
        'cateId'=>$cateId
    ), true),
)); ?>

<?php $this->endWidget(); ?>



<?php $this->renderPartial('partial/_action',array('option'=>$option,'cid'=>0)) ?>

