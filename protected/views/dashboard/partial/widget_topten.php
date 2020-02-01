<div class="row">
        <div class="col-xs-12 col-sm-6 widget-container-col">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-trophy"></i>
                        <?php echo Yii::t('app','This Year Top 10 Products ') . Yii::t('app','Ranked by AMOUNT'); ?>
                    </h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                            'id' => 'top-product-grid-qty',
                            'fixedHeader' => true,
                            'responsiveTable' => true,
                            'type' => TbHtml::GRID_TYPE_BORDERED,
                            'dataProvider' => $report->dashtopProductbyAmount(),
                            'summaryText' =>'',
                           /* 'summaryText' => '<p class="text-info" align="left">' . Yii::t('app',
                                    'This Year Top 10 Products ') . Yii::t('app',
                                    'Ranked by QUANTITY') . '</p>',*/
                            'columns' => array(
                                array(
                                    'name' => 'rank',
                                    'header' => Yii::t('app', 'Rank'),
                                    'value' => '$data["rank"]',
                                ),
                                array(
                                    'name' => 'item_name',
                                    'header' => Yii::t('app', 'Item Name'),
                                    'value' => '$data["item_name"]',
                                ),
                                array(
                                    'name' => 'qty',
                                    'header' => Yii::t('app', 'Quantity'),
                                    'value' => '$data["qty"]',
                                    //'footer'=>$report->paymentTotalQty() ,
                                ),
                                array(
                                    'name' => 'amount',
                                    'header' => Yii::t('app', 'Total Sales'),
                                    'value' => 'number_format($data["amount"],Common::getDecimalPlace())',
                                    //'footer'=>Yii::app()->getNumberFormatter()->formatCurrency($report->paymentTotalAmount(),'USD'),
                                ),
                            ),
                        )); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 widget-container-col">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-graduation-cap"></i>
                        <?php echo Yii::t('app', 'Best Customer '); ?>
                    </h5>

                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                            'id' => 'top-product-grid-amount',
                            'fixedHeader' => true,
                            'responsiveTable' => true,
                            'type' => TbHtml::GRID_TYPE_BORDERED,
                            'dataProvider' => $report->dbBestCustomer(),
                            'summaryText' => '',
                            /*'summaryText' => '<p class="text-info" align="left">' . Yii::t('app',
                                    'This Year Top 10 Products ') . Yii::t('app',
                                    'Ranked by AMOUNT') . '</p>',*/
                            'columns' => array(
                                array(
                                    'name' => 'rank',
                                    'header' => Yii::t('app', 'Rank'),
                                    'value' => '$data["rank"]',
                                ),
                                array(
                                    'name' => 'customer_name',
                                    'header' => Yii::t('app', 'Customer Name'),
                                    'value' => '$data["customer_name"]',
                                ),
                                array(
                                    'name' => 'amount',
                                    'header' => Yii::t('app', 'Purchase Amount'),
                                    'value' => 'number_format($data["amount"],Common::getDecimalPlace())',
                                    //'footer'=>Yii::app()->getNumberFormatter()->formatCurrency($report->paymentTotalAmount(),'USD'),
                                ),
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!--/row-->