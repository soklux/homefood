<?php
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_LIST,
    'submenuHtmlOptions'=>array('class'=>'submenu'),
    'encodeLabel' => false,
    'items' => array(
            array('label'=>'<span class="menu-text">' . sysMenuDashboard() . '</span>', 'icon'=>'menu-icon fa fa-tachometer', 'url'=>Yii::app()->urlManager->createUrl('dashboard/view'),
                'active'=>$this->id .'/'. $this->action->id=='dashboard/view'?true:false,
                'visible'=> Yii::app()->user->checkAccess('report.index')
            ),
            array('label'=>'<span class="menu-text">' . sysMenuItem() . '</span>', 'icon'=>'menu-icon fa fa-coffee', 'url'=>Yii::app()->urlManager->createUrl('item/admin'),
                'active'=> $this->id == 'item' ,
                'visible'=> Yii::app()->user->checkAccess('item.index') || Yii::app()->user->checkAccess('item.create') || Yii::app()->user->checkAccess('item.update') || Yii::app()->user->checkAccess('item.delete')),
            array('label'=>'<span class="menu-text">' . sysMenuInventory() .'</span>', 'icon'=>'menu-icon fa fa-desktop','url'=>Yii::app()->urlManager->createUrl('receivingItem/index'),
                'active'=>$this->id .'/'. $this->action->id=='receivingItem/index',
                'visible'=> Yii::app()->user->checkAccess('transaction.receive') || Yii::app()->user->checkAccess('transaction.return') || Yii::app()->user->checkAccess('transaction.adjustin') || Yii::app()->user->checkAccess('transaction.adjustout') || Yii::app()->user->checkAccess('transaction.count') ,
                'items'=>array(
                    array('label'=> sysMenuInventoryAdd(),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'adjustment_in')),'active'=>$this->id .'/'. $this->action->id.'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/adjustment_in','visible'=>Yii::app()->user->checkAccess('transaction.adjustin')),
                    array('label'=> sysMenuInventoryMinus(),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'adjustment_out')),'active'=>$this->id .'/'. $this->action->id.'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/adjustment_out','visible'=>Yii::app()->user->checkAccess('transaction.adjustout')),
                    array('label'=> sysMenuInventoryCount(),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'physical_count')),'active'=>$this->id .'/'. $this->action->id.'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/physical_count','visible'=>Yii::app()->user->checkAccess('transaction.count')),
            )),
            array('label'=>'<span class="menu-text">' . sysMenuPurchase() .'</span>', 'icon'=>'menu-icon fa fa-money','url'=>Yii::app()->urlManager->createUrl('receivingItem/index'),
                'active'=>$this->id .'/'. $this->action->id=='receivingItem/index',
                'visible'=> Yii::app()->user->checkAccess('transaction.receive') || Yii::app()->user->checkAccess('transaction.return') || Yii::app()->user->checkAccess('transaction.adjustin') || Yii::app()->user->checkAccess('transaction.adjustout') || Yii::app()->user->checkAccess('transaction.count') ,
                'items'=>array(
                    array('label'=> sysMenuPurchaseReceive(),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'receive')), 'active'=>$this->id .'/'. $this->action->id .'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/receive','visible'=>Yii::app()->user->checkAccess('transaction.receive')),
                    array('label'=> sysMenuPurchaseReturn(), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'return')),'active'=>$this->id .'/'. $this->action->id .'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/return','visible'=>Yii::app()->user->checkAccess('transaction.return')),
                    //array('label'=> Yii::t('app','Adjustment In'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'adjustment_in')),'active'=>$this->id .'/'. $this->action->id.'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/adjustment_in','visible'=>Yii::app()->user->checkAccess('transaction.adjustin')),
                    //array('label'=> Yii::t('app','Adjustment Out'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'adjustment_out')),'active'=>$this->id .'/'. $this->action->id.'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/adjustment_out','visible'=>Yii::app()->user->checkAccess('transaction.adjustout')),
                    //array('label'=> Yii::t('app','Physical Count'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('receivingItem/index',array('trans_mode'=>'physical_count')),'active'=>$this->id .'/'. $this->action->id.'/'.Yii::app()->request->getQuery('trans_mode')=='receivingItem/index/physical_count','visible'=>Yii::app()->user->checkAccess('transaction.count')),
            )),
            //array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Payment')). '</span>', 'icon'=>'menu-icon fa fa-heart', 'url'=>Yii::app()->urlManager->createUrl('sale/Invoice'), 'active'=>$this->id .'/'. $this->action->id=='sale/Invoice','visible'=>Yii::app()->user->checkAccess('payment.index')),
            array('label'=>'<span class="menu-text">' . sysMenuSale() . '</span>', 'icon'=> sysMenuSaleIcon(),
                'url'=>Yii::app()->urlManager->createUrl('saleItem/saleOrder'),
                'active' =>$this->id .'/'. $this->action->id=='saleItem/saleOrder',
                'visible'=> Yii::app()->user->checkAccess('sale.edit') || Yii::app()->user->checkAccess('sale.discount') || Yii::app()->user->checkAccess('sale.editprice') ),
            array('label'=>'<span class="menu-text">' . sysMenuInvoice() . '</span>', 'icon'=> sysMenuInvoiceIcon(),
                'url'=>Yii::app()->urlManager->createUrl('saleItem/saleInvoice'),
                'active'=>$this->id .'/'. $this->action->id=='saleItem/saleInvoice',
                'visible'=> Yii::app()->user->checkAccess('sale.edit') || Yii::app()->user->checkAccess('sale.discount') || Yii::app()->user->checkAccess('sale.editprice') ),
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Payment')) . '</span>', 'icon'=>'menu-icon fa fa-heart',
                'url'=>Yii::app()->urlManager->createUrl('salePayment/index'),
                'active'=>$this->id .'/'. $this->action->id=='salePayment/index',
                'visible'=>Yii::app()->user->checkAccess('payment.index')),
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Supplier Payment')) . '</span>', 'icon'=>'menu-icon fa fa-credit-card', 'url'=>Yii::app()->urlManager->createUrl('receivingPayment/index'),
                'active'=>$this->id .'/'. $this->action->id=='receivingPayment/index',
                'visible'=>Yii::app()->user->checkAccess('payment.index')),
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'Report')) .'</span>', 'icon'=>'menu-icon fa fa-signal', 'url'=>Yii::app()->urlManager->createUrl('report/reporttab'),
                'active'=>$this->id =='report',
                'visible'=> Yii::app()->user->checkAccess('report.index') || Yii::app()->user->checkAccess('invoice.index') || Yii::app()->user->checkAccess('invoice.print') || Yii::app()->user->checkAccess('invoice.delete') || Yii::app()->user->checkAccess('invoice.update') ,
                'items'=>array(
                    array('label'=> Yii::t('app','Sale Invoice'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleInvoice',
                        'visible'=> Yii::app()->user->checkAccess('invoice.index') || Yii::app()->user->checkAccess('invoice.print') || Yii::app()->user->checkAccess('invoice.delete') || Yii::app()->user->checkAccess('invoice.update')
                    ),
                    array('label'=> Yii::t('app','Sale Daily'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleDaily'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleDaily',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Sale Hourly'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleHourly'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleHourly',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Sale Summary'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleSummary'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleSummary',
                        'visible'=> Yii::app()->user->checkAccess('report.index') 
                    ),
                    array('label'=> Yii::t('app','Sale By Sale Rep'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleSumBySaleRep'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleSumBySaleRep',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Sale Weekly By Customer'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleWeeklyByCustomer'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleWeeklyByCustomer',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Outstanding Balance'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/outstandingInvoice'),
                        'active'=>$this->id .'/'. $this->action->id =='report/outstandingInvoice',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Profit Daily Sum'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/ProfitDailySum'),
                        'active'=>$this->id .'/'. $this->action->id =='report/ProfitDailySum',
                        'visible'=> Yii::app()->user->checkAccess('report.profit')
                    ),
                    array('label'=> Yii::t('app','Payment Receive'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/PaymentReceiveByEmployee'),
                        'active'=>$this->id .'/'. $this->action->id =='report/PaymentReceiveByEmployee',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Best Selling Item'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/TopItem'),
                        'active'=>$this->id .'/'. $this->action->id =='report/TopItem',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Sale Item Summary'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/SaleItemSummary'),
                        'active'=>$this->id .'/'. $this->action->id =='report/SaleItemSummary',
                        'visible'=> Yii::app()->user->checkAccess('report.index')
                    ),
                    array('label'=> Yii::t('app','Item Expiry'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/itemExpiry'),
                        'active'=>$this->id .'/'. $this->action->id =='report/itemExpiry',
                        'visible'=> Yii::app()->user->checkAccess('report.index')  || Yii::app()->settings->get('item', 'itemExpireDate')=='1' 
                        ),
                    array('label'=> Yii::t('app','Inventory'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/Inventory'),
                        'active'=>$this->id .'/'. $this->action->id =='report/Inventory',
                        'visible'=> Yii::app()->user->checkAccess('report.index') 
                    ),
                    array('label'=>Yii::t('app','Transaction'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/Transaction'),
                        'active'=>$this->id .'/'. $this->action->id =='report/Transaction',
                        'visible'=> Yii::app()->user->checkAccess('report.index') 
                    ),
                    /*array('label'=>Yii::t('app','Total Asset'), 'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/ItemAsset'),
                        'active'=>$this->id .'/'. $this->action->id =='report/ItemAsset',
                        'visible'=> Yii::app()->user->checkAccess('report.index'),
                    ),*/
                    array('label'=>Yii::t('app','User Log Summary'),'icon'=> 'menu-icon fa fa-caret-right', 'url'=>Yii::app()->urlManager->createUrl('report/UserLogSummary'),
                        'active'=>$this->id .'/'. $this->action->id =='report/UserLogSummary',
                        'visible'=> Yii::app()->user->isAdmin,
                    ),
            )),
            array('label'=>'<span class="menu-text">'. strtoupper(Yii::t('app','PIM')) . '</span>', 'icon'=>'menu-icon fa fa-group','url'=>Yii::app()->urlManager->createUrl('client/admin'),
                           'active'=>$this->id=='employee' || $this->id=='supplier' || $this->id=='client' || $this->id=='publisher',
                           'visible'=> Yii::app()->user->checkAccess('store.update') || Yii::app()->user->checkAccess('employee.index') || Yii::app()->user->checkAccess('client.index'),
                           'items'=>array(
                               array('label'=>Yii::t('app', 'Customer') , 'icon'=> TbHtml::ICON_USER, 'url'=>Yii::app()->urlManager->createUrl('client/admin'),
                                   'active'=>$this->id =='client',
                                   'visible'=> Yii::app()->user->checkAccess('client.index') || Yii::app()->user->checkAccess('client.create') || Yii::app()->user->checkAccess('client.update') || Yii::app()->user->checkAccess('client.delete')
                               ),
                               array('label'=>Yii::t('app', 'Employee'), 'icon'=> TbHtml::ICON_USER, 'url'=>Yii::app()->urlManager->createUrl('employee/admin'),
                                   'active'=>$this->id =='employee', //'active'=>$this->id .'/'. $this->action->id=='employee/admin',
                                   'visible'=> Yii::app()->user->checkAccess('employee.index') || Yii::app()->user->checkAccess('employee.create') || Yii::app()->user->checkAccess('employee.update') || Yii::app()->user->checkAccess('employee.delete')
                               ),
                               //array('label'=>Yii::t('app', 'Publisher'), 'icon'=> TbHtml::ICON_USER, 'url'=>Yii::app()->urlManager->createUrl('publisher/admin'), 'active'=>$this->id .'/'. $this->action->id=='publisher/admin','visible'=>Yii::app()->user->checkAccess('supplier.index')),
                               array('label'=>Yii::t('app','Supplier'), 'icon'=> TbHtml::ICON_USER, 'url'=>Yii::app()->urlManager->createUrl('supplier/admin'),
                                   'active'=>$this->id == 'supplier',
                                   'visible'=> Yii::app()->user->checkAccess('supplier.index') || Yii::app()->user->checkAccess('supplier.create') || Yii::app()->user->checkAccess('supplier.update') || Yii::app()->user->checkAccess('supplier.delete')
                               ),
            )),
            array('label'=>'<span class="menu-text">'. strtoupper(Yii::t('app','Setting')) . '</span>', 'icon'=>'menu-icon fa fa-cogs','url'=>Yii::app()->urlManager->createUrl('settings/index'),
                           'active'=>$this->id=='priceTier' || strtolower($this->id)=='default' || $this->id=='store' || $this->id=='settings' || $this->id=='location' || $this->id=='category',
                           'visible'=>Yii::app()->user->checkAccess('store.update'),
                           'items'=>array(
                               array('label'=>Yii::t('app', 'Category'), 'icon'=> TbHtml::ICON_LIST, 'url'=>Yii::app()->urlManager->createUrl('category/admin'),
                                   'active'=>$this->id =='category',
                                   'visible'=> Yii::app()->user->checkAccess('item.index') || Yii::app()->user->checkAccess('item.create') || Yii::app()->user->checkAccess('item.update') || Yii::app()->user->checkAccess('item.delete')),
                               array('label'=>Yii::t('app','Price Tier'),'icon'=> TbHtml::ICON_ADJUST, 'url'=>Yii::app()->urlManager->createUrl('priceTier/admin'),
                                   'active'=>$this->id .'/'. $this->action->id=='priceTier/admin',
                                   'visible'=>Yii::app()->user->checkAccess('store.update')),
                               //array('label'=>Yii::t('app','Location'),'icon'=> TbHtml::ICON_MAP_MARKER, 'url'=>Yii::app()->urlManager->createUrl('location/admin'), 'active'=>$this->id .'/'. $this->action->id=='location/admin','visible'=>Yii::app()->user->checkAccess('store.update')),
                               array('label'=>Yii::t('app','Shop Setting'),'icon'=> TbHtml::ICON_COG, 'url'=>Yii::app()->urlManager->createUrl('settings/index'),
                                   'active'=>$this->id=='settings',
                                   //'visible'=> Yii::app()->user->isAdmin
                               ),
                               //'visible'=>Yii::app()->user->checkAccess('store.update')),
                               //array('label'=>Yii::t('app','Branch'),'icon'=> TbHtml::ICON_HOME, 'url'=>Yii::app()->urlManager->createUrl('store/admin'), 'active'=>$this->id .'/'. $this->action->id=='store/admin','visible'=>Yii::app()->user->checkAccess('store.update')),
                               //array('label'=>Yii::t('app','Database Backup'),'icon'=> TbHtml::ICON_HDD, 'url'=>Yii::app()->urlManager->createUrl('backup/default/index'),'active'=> $this->id =='default'),
            )),
            array('label'=>'<span class="menu-text">' . strtoupper(Yii::t('app', 'About US')) . '</span>', 'icon'=>'menu-icon fa fa-info-circle', 'url'=>Yii::app()->urlManager->createUrl('site/about'), 'active'=>$this->id .'/'. $this->action->id=='site/about'),
    ), 
)); 
?>

<!-- #section:basics/sidebar.layout.minimize -->
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

<!-- /section:basics/sidebar.layout.minimize -->
<script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>