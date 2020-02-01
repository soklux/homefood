<div class="row">
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true, // display a larger alert block?
        'fade' => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts' => array( // configurations per alert type
            'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'),
            'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'),
        ),
    )); ?>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'employee-form',
        //'enableAjaxValidation'=>true,
        //'action'=>$this->createUrl('Item/Create'),
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>true,
            'validateOnType'=>true,
        ),
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,

    )); ?>

    <div>
        <div class="col-sm-5">

            <h4 class="header blue">
                <i class="ace-icon fa fa-info-circle blue"></i><?= Yii::t('app', 'Employee Basic Information') ?>
            </h4>
            <p class="help-block"><?= Yii::t('app', 'Fields with'); ?> <span
                        class="required">*</span> <?= Yii::t('app', 'are required'); ?></p>

            <?php $this->renderPartial('_basic', array(
                    'model' => $model,
                    'form' => $form,
                )
            )
            ?>

        </div>

        <div class="col-sm-7">

            <h4 class="header blue">
                <i class="ace-icon fa fa-location-arrow blue"></i><?= Yii::t('app', 'Employee Address Information') ?>
            </h4>

            <?php $this->renderPartial('//address/_address', array(
                    'model' => $model,
                    'form' => $form,
                )
            )
            ?>
        </div>
    </div>

    <div>
        <div class="col-sm-12">

            <h4 class="header blue">
                <i class="ace-icon fa fa-key blue"></i><?= Yii::t('app', 'Employee Login Info') ?>
            </h4>

            <?php $this->renderPartial('//rbacUser/_login_form',array(
                'model' => $model,
                'user' => $user,
                'form' => $form,
                'disabled' => $disabled,
            ));?>

        </div>

    </div>

    <div>
        <div class="col-sm-12">

            <h4 class="header blue bolder">
                <i class="ace-icon fa fa-gavel blue"></i><?= Yii::t('app', 'Employee Permissions and Access'); ?>
            </h4>

            <?php /*print_r($auth_items) */?>

            <?php
            $permission_items = array (
                array('header_title' => 'Items', 'header_icon' => sysMenuItemIcon(),
                    'grid_items' => array (
                        array('grid_title' => 'Item',  'permission' => 'item.', 'control_name' => 'items'),
                        array('grid_title' => 'Price Book', 'permission' => 'pricebook.', 'control_name' => 'pricebooks'),
                        array('grid_title' => 'Category', 'permission' => 'category.', 'control_name' => 'categories'),
                    ),
                ),
                array('header_title' => 'Sales', 'header_icon' => 'fa fa-cart-arrow-down',
                    'grid_items' => array (
                        array('grid_title' => 'Sale Order',  'permission' => 'sale', 'control_name' => 'saleorders'),
                        array('grid_title' => 'Invoice',  'permission' => 'invoice', 'control_name' => 'invoices'),
                        array('grid_title' => 'Sale Order Delivery',  'permission' => 'shipmentorder', 'control_name' => 'shipmentorders'),
                        array('grid_title' => 'Customer Payment', 'permission' => 'customerpayment.', 'control_name' => 'customerpayments'),
                    )
                ),
                array('header_title' => 'Contacts', 'header_icon' => sysMenuUserIcon(),
                    'grid_items' => array (
                        array('grid_title' => 'Customer',  'permission' => 'customer.', 'control_name' => 'customers'),
                        array('grid_title' => 'Customer Group',  'permission' => 'customergroup.', 'control_name' => 'customergroups'),
                        array('grid_title' => 'Employee',  'permission' => 'employee.', 'control_name' => 'employees'),
                        array('grid_title' => 'Supplier', 'permission' => 'supplier.', 'control_name' => 'suppliers'),
                    )
                ),
                array('header_title' => 'Inventory', 'header_icon' => 'fa fa-desktop',
                    'grid_items' => array (
                        array('grid_title' => 'Stock count',  'permission' => 'stockcount.', 'control_name' => 'stockcounts'),
                        array('grid_title' => 'Stock Transfer', 'permission' => 'stocktransfer.', 'control_name' => 'stocktransfers'),
                    )
                ),
                array('header_title' => 'Purchases', 'header_icon' => 'fa fa-money',
                    'grid_items' => array (
                        array('grid_title' => 'Purchase Order',  'permission' => 'purchaseorder.', 'control_name' => 'purchaseorders'),
                        array('grid_title' => 'Purchase Receive', 'permission' => 'purchasereceive.', 'control_name' => 'purchasereceives'),
                        array('grid_title' => 'Purchase Return', 'permission' => 'purchasereturn.', 'control_name' => 'purchasereturns'),
                    )
                ),
            );

            $permission_items_ctl = array (
                array('header_title' => 'Reports', 'header_icon' => 'fa fa-signal',
                    'grid_items' => array (
                        array('grid_title' => 'Report',  'permission' => 'report', 'control_name' => 'reports'),
                    ),
                ),
                array('header_title' => 'Settings', 'header_icon' => 'fa fa-cogs',
                    'grid_items' => array (
                        array('grid_title' => 'Setting',  'permission' => 'setting', 'control_name' => 'settings'),
                    ),
                )
            );

            ?>

            <?php foreach($permission_items as $key => $value): ?>

                <?php $this->renderPartial('//role/grid/_permission', array(
                    'model' => $model,
                    'user' => $user,
                    'header_title' => $value['header_title'],
                    'header_icon' => $value['header_icon'],
                    'grid_items' => $value['grid_items'],
                    'auth_items' => $auth_items,
                )); ?>

            <?php endforeach; ?>

            <?php foreach($permission_items_ctl as $key => $value): ?>

                <?php $this->renderPartial('//role/control/_permission', array(
                    'model' => $model,
                    'user' => $user,
                    'header_title' => $value['header_title'],
                    'header_icon' => $value['header_icon'],
                    'grid_items' => $value['grid_items']
                )); ?>

            <?php endforeach; ?>


            <div class="form-actions">
                <?= TbHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), array(
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                )); ?>
            </div>

        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php Yii::app()->clientScript->registerScript('setFocus', '$("#Employee_first_name").focus();'); ?>
