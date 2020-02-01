
<div class="col-xs-12 widget-container-col summary_header">
    <div class="infobox infobox-green">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-money"></i>
        </div>
        <div class="infobox-data">
            <span class="infobox-data-number"><?=  $report->totalSaleSPD(); ?></span>
            <div class="infobox-content"><?= CHtml::link('Today\'s Sale', Yii::app()->createUrl("report/SaleDaily")); ?></div>
        </div>
    </div>

    <div class="infobox infobox-purple">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-money"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?= $report->totalSale2Date('WEEK'); ?></span>

            <div class="infobox-content">This Week Sales</div>
        </div>
    </div>

    <div class="infobox infobox-pink">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-money"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?= $report->totalSale2Date('MONTH'); ?></span>

            <div class="infobox-content">This Month Sales</div>
        </div>
    </div>

    <div class="infobox infobox-blue">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-money"></i>
        </div>

        <div class="infobox-data">
            <span class="infobox-data-number"><?= $report->totalSale2Y(); ?></span>

            <div class="infobox-content">This Year Sales</div>
        </div>
    </div>

    <div class="infobox infobox-blue">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-users"></i>
        </div>
        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $report->countCustomer(); ?></span>

            <div class="infobox-content"><?php echo CHtml::link('Total Customers', Yii::app()->createUrl("client/admin")); ?></div>
        </div>
    </div>

    <div class="infobox infobox-green">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-user icon-animated-vertical"></i>
        </div>
        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $report->count2dNewCust(); ?></span>

            <div class="infobox-content"><?php echo CHtml::link('New Customer Today', Yii::app()->createUrl("client/admin")); ?></div>
        </div>
    </div>

    <div class="infobox infobox-orange2">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-square-o"></i>
        </div>
        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo $report->countStock('=0'); ?></span>

            <div class="infobox-content"><?php echo CHtml::link(Yii::t('app;','Out of Stock'), Yii::app()->createUrl("report/inventory",array('filter'=>'outstock'))); ?></div>
        </div>
    </div>

    <div class="infobox infobox-red">
        <div class="infobox-icon">
            <i class="ace-icon fa fa-minus-square icon-animated-bell""></i>
        </div>
        <div class="infobox-data">
            <span class="infobox-data-number"><?php echo -$report->countStock('<0'); ?></span>

            <div class="infobox-content"><?php echo CHtml::link(Yii::t('app;','Negative Stock'), Yii::app()->createUrl("report/inventory")); ?></div>
        </div>
    </div>

</div>

