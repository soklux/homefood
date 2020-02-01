<div class="col-xs-6">
    <h3 class="header smaller lighter green">🚀បង្កើនការលក់របស់អ្នក BOOST YOUR SALES</h3>

    <?php if (ckacc('sale.read') || ckacc('sale.create') || ckacc('sale.update') ) { ?>

        <?php echo TbHtml::linkButton(sysMenuSaleOrder(), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuSaleOrderIcon() . ' icon-animated-vertical ' . ' bigger-200',
            'url' => $this->createUrl('saleItem/create'),
            'title' => sysMenuSaleOrder() . ' Add',
        )); ?>

    <?php } else { ?>
        <?php echo TbHtml::linkButton(sysMenuSaleOrder(), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon fa fa-ban',//'ace-icon '. sysMenuSaleOrderIcon() . '  icon-animated-vertical ' . ' bigger-200',
            'url' => $this->createUrl('saleItem/create'),
            'title' => sysMenuSaleOrder() . ' Add',
            'disabled' => true,
        )); ?>
    <?php } ?>

    <?php if (ckacc('sale.validate')) { ?>

        <?php echo TbHtml::linkButton('Order 2 ✅', array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuSaleOrderToValidateIcon() . ' bigger-200',
            'url' => $this->createUrl('saleItem/create',array (
                'status' => param('sale_submit_status'),
                'user_id' => getEmployeeId(),
                'title' => sysMenuSaleOrderToValidate(),
            )),
            'title' => sysMenuSaleOrderToValidate()
        )); ?>

    <?php } else { ?>

        <?php echo TbHtml::linkButton('Order 2 ✅', array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon fa fa-ban',
            'url' => $this->createUrl('saleItem/create',array (
                'status' => param('sale_submit_status'),
                'user_id' => getEmployeeId(),
                'title' => sysMenuSaleOrderToValidate(),
            )),
            'title' => sysMenuSaleOrderToValidate(),
            'disabled' => true,
        )); ?>

    <?php } ?>
</div>

<div class="col-xs-6">

    <h3 class="header smaller lighter green">💵គ្រប់គ្រងវិក័យប័ត្ររបស់អ្នក MANAGE YOUR INVOICE</h3>

    <?php if (ckacc('sale.create') || ckacc('sale.update') || ckacc('sale.delete') ) { ?>

        <?php echo TbHtml::linkButton(sysMenuInvoice(), array(
            'color' => TbHtml::BUTTON_COLOR_SUCCESS,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuInvoiceIcon() . ' icon-animated-vertical ' . ' bigger-200',
            'url' => $this->createUrl('saleItem/create'),
        )); ?>

    <?php } else { ?>

        <?php echo TbHtml::linkButton(sysMenuInvoice(), array(
            'color' => TbHtml::BUTTON_COLOR_SUCCESS,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon fa fa-ban',//'ace-icon '. sysMenuInvoiceIcon() . ' icon-animated-vertical ' . ' bigger-200',
            'url' => $this->createUrl('saleItem/create'),
            'disabled' => true,
        )); ?>

    <?php } ?>

    <?php if (ckacc('report.account')) { ?>
        <?php echo TbHtml::linkButton('Revenue', array(
            'color' => TbHtml::BUTTON_COLOR_SUCCESS,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuInvoiceIcon() . ' bigger-200',
            'url' => $this->createUrl('report/profitDailySum'),
        )); ?>
    <?php } else { ?>
        <?php echo TbHtml::linkButton('Revenue', array(
            'color' => TbHtml::BUTTON_COLOR_SUCCESS,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon fa fa-ban',//'ace-icon '. sysMenuInvoiceIcon() . ' bigger-200',
            'url' => $this->createUrl('report/profitDailySum'),
            'disabled' => true,
        )); ?>
    <?php } ?>

</div>