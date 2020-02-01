<div class="col-xs-6">
    <h3 class="header smaller lighter green">🍌គ្រប់គ្រងផលិតផលរបស់អ្នក MANAGE YOUR PRODUCT</h3>

    <?php if (ckacc('item.create') || ckacc('item.update') || ckacc('item.delete') ) { ?>

        <?php echo TbHtml::linkButton(sysMenuItemAdd(), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm btn-purple',
            'icon' => 'ace-icon '. sysMenuItemIcon() . ' bigger-200',
            'url' => $this->createUrl('item/create'),
            'title' => t('Add New Item','app')
        )); ?>

        <?php echo TbHtml::linkButton(sysMenuItemView(), array(
            'class' => 'btn btn-app btn-sm btn-purple',
            'icon' => 'ace-icon fa fa-eye' . ' bigger-200',
            'url' => $this->createUrl('item/admin'),
            'title' => sysMenuItemView(),
        )); ?>

    <?php } else { ?>

        <?php echo TbHtml::linkButton(sysMenuItemAdd(), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm btn-purple',
            'icon' => 'ace-icon fa fa-ban',//'ace-icon '. sysMenuItemIcon() . ' bigger-200',
            'url' => $this->createUrl('item/create'),
            'title' => t('Add New Item','app'),
            'disabled' => true,
        )); ?>

        <?php echo TbHtml::linkButton(sysMenuItemView(), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm btn-purple',
            'icon' => 'ace-icon fa fa-ban',//'ace-icon fa fa-eye' . ' bigger-200',
            'url' => $this->createUrl('item/admin'),
            'title' => sysMenuItemView(),
            'disabled' => true,
        )); ?>

    <?php } ?>


</div>


<div class="col-xs-6">
    <h3 class="header smaller lighter green">🚠គ្រប់គ្រងបញ្ជីសារពើភណ្ឌរបស់អ្នក MANAGE YOUR INVENTORY</h3>

    <?php if (ckacc('stockcount.read') || ckacc('stockcount.create') || ckacc('stockcount.update') ) { ?>

        <?php echo TbHtml::linkButton('Count', array(
            //'color' => TbHtml::BUTTON_COLOR_LINK,
            'class' => 'btn btn-app btn-sm btn-warning',
            'icon' => 'ace-icon '. sysMenuInventoryCountIcon() . ' bigger-200',
            'url' => $this->createUrl('receivingItem/index', array(
                    'trans_mode' => 'physical_count',
            )),
            'title' => sysMenuInventoryCount()
        )); ?>

        <?php /*echo TbHtml::linkButton(sysMenuInventoryAdd(), array(
            'class' => 'btn btn-app btn-sm btn-warning',
            'icon' => 'ace-icon '. sysMenuInventoryAddIcon() . ' bigger-200',
            'url' => $this->createUrl('item/admin'),
            'title' => sysMenuInventoryAdd(),
        )); */?>

        <?php /*echo TbHtml::linkButton(sysMenuInventoryMinus(), array(
            //'color' => TbHtml::BUTTON_COLOR_LINK,
            'class' => 'btn btn-app btn-sm btn-warning',
            'icon' => 'ace-icon '. sysMenuInventoryMinusIcon() . ' bigger-200',
            'url' => $this->createUrl('item/admin'),
            'title' => sysMenuInventoryMinus(),
        )); */?>

    <?php } else { ?>
        <?php echo TbHtml::linkButton('Count', array(
            'color' => TbHtml::BUTTON_COLOR_DEFAULT,
            'class' => 'btn btn-app btn-sm btn-warning',
            'icon' => 'ace-icon fa fa-ban',//'ace-icon '. sysMenuInventoryCountIcon() . ' bigger-200',
            'url' => $this->createUrl('receivingItem/index', array(
                'trans_mode' => 'physical_count',
            )),
            'title' => sysMenuInventoryCount(),
            'disabled' => true,
        )); ?>
    <?php } ?>

</div>