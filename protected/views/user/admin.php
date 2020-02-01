<?php
$this->breadcrumbs = array(
    Yii::t('app', ucfirst(get_class($model))) => array('admin'),
    Yii::t('app', 'Manage'),
);
?>
<div class="row" id="<?= $main_div_id ?>">
    <div class="col-xs-12 widget-container-col ui-sortable">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'List of ' . ucfirst(get_class($model))),
            'headerIcon' => sysMenuUserIcon(),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>
        <!-- Admin Header layouts.admin._header -->
        <div class="page-header">
            <?php $this->renderPartial('//layouts/admin/_header',array(
                'model' => $model,
                'create_permission' => isset($create_permission) ? $create_permission : strtolower(get_class($model)) . '.create' ,
                'create_url' => isset($create_url) ? $create_url : 'Create',
                'archived_attr' =>  isset($archived_attr) ? $archived_attr : strtolower(get_class($model)) . '_archived',
                'grid_id' => $grid_id,
                'module_name' => isset($module_name) ? $module_name : ucfirst(get_class($model)),
            ));?>
        </div>

        <!-- Flash message layouts.partial._flash_message -->
        <?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

        <!-- Grid Table Filterable layouts.admin._grid_filter -->
        <?php $this->renderPartial('//layouts/admin/_grid_filter', array(
            'model' => $model,
            'data_provider' => $data_provider ,
            'grid_id' => $grid_id,
            'page_size' => $page_size,
            'grid_columns' => $grid_columns,
        )); ?>

        <?php $this->endWidget(); ?>

        <!-- Grid Table layouts.admin._footer -->
        <?php $this->renderPartial('//layouts/admin/_footer',array(
            'main_div_id' => $main_div_id,
            'grid_id' => $grid_id,
        ));?>

    </div>
</div>


