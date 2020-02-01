<?php
	$this->breadcrumbs = array(
	    Yii::t('app', ucfirst('physical Count')) => array('index?trans_mode=physical_count'),
	    Yii::t('app', 'List'),
	);
?>
<div class="row" id="<?= $main_div_id ?>">
    <div class="col-xs-12 widget-container-col ui-sortable">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'List of ' . ucfirst(get_class($model))),
            'headerIcon' => sysMenuItemIcon(),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>
            
        	<!-- Admin Header layouts.admin._header -->
            <div class="page-header">
                <?php if(Yii::app()->user->checkAccess('stockcount.create')):?>
                <?php echo TbHtml::linkButton(Yii::t('app', 'Add New'), array(
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                    'size' => TbHtml::BUTTON_SIZE_SMALL,
                    'icon' => 'ace-icon fa fa-plus white',
                    'url' =>  $this->createUrl('inventoryCountCreate'),
                )); ?>
                <?php endif;?>
            </div>
            <!-- Flash message layouts.partial._flash_message -->
            <?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

            <!-- Grid Table Filterable layouts.admin._grid_filter -->
            <?php $this->renderPartial('//layouts/admin/_grid', array(
                'model' => $model,
                'data_provider' => $data_provider ,
                'grid_id' => $grid_id,
                'page_size' => $page_size,
                'grid_columns' => $grid_columns,
            )); ?>
            <hr>
            <?php $baseUrl = Yii::app()->theme->baseUrl;?>
            <img src="<?=$baseUrl?>/flowimages/inventory count.png" width="90%">
        <?php $this->endWidget(); ?>

        <!-- Grid Table layouts.admin._footer -->
        <?php $this->renderPartial('//layouts/admin/_footer',array(
            'main_div_id' => $main_div_id,
            'grid_id' => $grid_id,
        ));?>

    </div>
</div>