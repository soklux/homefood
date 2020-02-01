<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'id' => 'item-form',
        'enableAjaxValidation' => false,
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php $this->renderPartial('_header', array('model' => $model)) ?>


<br> <br>

    <div id="report_grid" class="tabbable">
        <?php $this->widget('bootstrap.widgets.TbTabs', array(
            'type' => 'tabs',
            'placement' => 'above',
            'id' => 'tabs',
            'tabs' => array(
                array('label' =>  t('Basic','app'),
                    'id' => 'tab_1',
                    'icon' => sysMenuItemIcon(),
                    'content' => $this->renderPartial('_tab_basic' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        //'price_quantity_range' => $price_quantity_range,
                        'form' => $form,
                        'title' => 'Basic'),true),
                    'active' => true,
                ),
                array('label' => sysMenuSale(),
                    'id' => 'tab_2',
                    'icon' => sysMenuSaleIcon(),
                    'content' => $this->renderPartial('_tab_sale' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'item_price_quantity' => $item_price_quantity,
                        'form' => $form,
                        'title' => sysMenuSale()),true),
                ),
            ),
        ));
        ?>

    </div>
<?php $this->endWidget(); ?>