<div class="col-xs-6">
    <h3 class="header smaller lighter green">👨‍👩‍👦‍👦ថែរក្សាអតិថិជនរបស់អ្នក TAKING CARE YOU CUSTOMER</h3>

    <?php if (ckacc('report.sale.analytic') ) { ?>
        <?php echo TbHtml::linkButton('CRM', array(
            //'color' => TbHtml::BUTTON_COLOR_LINK,
            'class' => 'btn btn-app btn-pink',
            'icon' => 'ace-icon fa fa-handshake-o' . ' bigger-200',
            'url' => $this->createUrl('report/saleWeeklyByCustomer'),
            'title' => t('Customer Relationship Management','app')
        )); ?>
    <?php } else { ?>
        <?php echo TbHtml::linkButton('CRM', array(
            'color' => TbHtml::BUTTON_COLOR_DEFAULT,
            'class' => 'btn btn-app btn-pink',
            'icon' => 'ace-icon fa fa-ban ',//'ace-icon fa fa-handshake-o' . ' bigger-200',
            'url' => $this->createUrl('report/saleWeeklyByCustomer'),
            'title' => t('Customer Relationship Management','app'),
            'disabled' => true,
        )); ?>
    <?php } ?>

</div>

<div class="col-xs-6">
    <h3 class="header smaller lighter green">🔮របាយការណ៏ថ្លាដូចកញ្ចក់ Crystal Clear + 360º Reports</h3>

    <?php if (ckacc('report.sale.analytic') ) { ?>
        <?php echo TbHtml::linkButton('Report', array(
            //'color' => TbHtml::BUTTON_COLOR_LINK,
            'class' => 'btn btn-app btn-pink',
            'icon' => 'ace-icon fa fa-lightbulb-o' . ' bigger-200',
            'url' => $this->createUrl('report/saleWeeklyByCustomer'),
            'title' => t('Crystal Clear 360º Reports','app')
        )); ?>
    <?php } ?>

</div>