<?php

class ReportController extends Controller
{

    public $layout = '//layouts/column1';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'create',
                    'update',
                    'ReportTab',
                    'SaleInvoiceItem',
                    'SaleInvoice',
                    'SaleInvoiceAlert',
                    'SaleDaily',
                    'SaleReportTab',
                    'SaleSummary',
                    'Payment',
                    'TopItem',
                    'SaleHourly',
                    'Inventory',
                    'ItemExpiry',
                    'ProfitDailySum',
                    'ItemInactive',
                    'Transaction',
                    'TransactionItem',
                    'ItemAsset',
                    'SaleItemSummary',
                    'StockCount',
                    'StockCountPrint',
                    'UserLogSummary',
                    'UserLogDt',
                    'OutStandingInvoice',
                    'SaleSumBySaleRep',
                    'PaymentReceiveByEmployee',
                    'ProfitByInvoice',
                    'SaleInvoiceDetail',
                    'AllSaleInvoiceDetail',
                    'SaleWeeklyByCustomer',
                    'BalanceByCustomerId',
                    'saleOrderHistory',
                    'saleOrderApproval',
                    'SaleDelivery',
                    'viewOrderHistoryDetail',
                    'backupDB',
                    'AgedCustomerPurchase'
                ),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionReportTab()
    {

        $report = new Report;
        $report->unsetAttributes();  // clear any default values
        $date_view = 0; //indicate no date picker from_date & to_date, default view is today 
        $filter = 'all';
        $mfilter = '1';

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        $this->render('_report_tab', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date, 'date_view' => $date_view, 'filter' => $filter, 'mfilter' => $mfilter));
    }

    public function actionSaleReportTab()
    {

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('01-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            $this->renderPartial('_sale_report_tab', array('report' => $report), true, true);
            Yii::app()->end();
        } else {
            $this->render('_sale_report_tab', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionSaleInvoice()
    {
        authorized('report.sale');

        $grid_id = 'rpt-sale-invoice-grid';
        $title = 'Sale Invoice';

        $data = $this->commonData($grid_id,$title,'show');

        //$data['grid_columns'] = ReportColumn::getSaleInvoiceColumns();
        $data['grid_columns'] = ReportColumn::getSaleOrderHistoryColumns();
        //$data['data_provider'] = $data['report']->saleInvoice();
        $data['data_provider'] = $data['report']->saleInvoiceHis();

        $this->renderView($data);

    }

    public function actionSaleOrderApproval()
    {
        authorized('report.sale');

        $grid_id = 'rpt-sale-invoice-grid';
        $title = 'Sale Order Approval';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleOrderApprovalColumns();
        $data['data_provider'] = $data['report']->saleInvoiceApp();

        $this->renderView($data);

    }


    public function actionSaleOrderHistory()
    {
        authorized('report.sale');

        $grid_id = 'rpt-sale-invoice-grid';
        $title = 'Sale Order History';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleOrderHistoryColumns();
        $data['data_provider'] = $data['report']->saleInvoiceHis();

        $this->renderView($data);

    }

    public function actionSaleDelivery()
    {
        authorized('report.sale');

        $grid_id = 'rpt-sale-invoice-grid';
        $title = 'Sale Order History';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleDeliveryColumns();
        $data['data_provider'] = $data['report']->SaleDelivery();

        $this->renderView($data);
    }

    public function actionViewOrderHistoryDetail($sale_id, $customer_id,$employee_id='',$tran_type,$pdf=false,$email=false)
    {
            authorized('sale.read') || authorized('sale.create') ;

            $data = $this->receiptData($sale_id,$customer_id,$tran_type);

            if (count($data['items']) == 0) {
                $data['error_message'] = 'Sale Transaction Failed';
            }

            $this->renderRecipe($data);
            
            Yii::app()->shoppingCart->clearAll();

    }

    protected function receiptData($sale_id,$customer_id,$tran_type,$paid_amount=0)
    {
        $this->layout = '//layouts/column_receipt';

        Yii::app()->shoppingCart->setInvoiceFormat('format_hf');
        Yii::app()->shoppingCart->copyEntireSale($sale_id);

        $data = $this->sessionInfo();

        $data['sale_id'] = $sale_id;
        $data['customer_id'] = $customer_id;
        $data['paid_amount'] = $paid_amount;
        $data['status'] = $tran_type;
        $data['receipt_header_title_kh'] = $this->getInvoiceTitle(isset($_GET['tran_type']) ? $_GET['tran_type'] : $tran_type, 'kh');
        $data['receipt_header_title_en'] = $this->getInvoiceTitle(isset($_GET['tran_type']) ? $_GET['tran_type'] : $tran_type, 'en');
        $data['invoice_format'] = Yii::app()->shoppingCart->getInvoiceFormat();
        $data['invoice_prefix'] = $tran_type == param('sale_complete_status') ? 'INV' : 'SO';
        $data['filename'] = $data['invoice_prefix']. '_' . $sale_id . '_' . str_replace('/', '_', $data['transaction_date']);

        if (count($data['items']) == 0) {
            $data['error_message'] = 'Sale Transaction Failed';
        }

        return $data;

    }

    public function actionSaleInvoiceDetail($id)
    {
       authorized('report.sale');

        $report = new Report;

        $data['report'] = $report;
        $data['sale_id'] = $id;

        $data['grid_id'] = 'rpt-sale-invoice-grid';
        $data['title'] = Yii::t('app','Detail #') .' ' . $id  ;

        $data['grid_columns'] = ReportColumn::getSaleInvoiceDetailColumns();

        $report->sale_id = $id;
        $data['data_provider'] = $report->saleInvoiceDetail();

        $this->renderView($data);

    }

    public function actionAllSaleInvoiceDetail($id)
    {
       authorized('report.sale');

        $report = new Report;

        $data['report'] = $report;
        $data['sale_id'] = $id;

        $data['grid_id'] = 'rpt-sale-invoice-grid';
        $data['title'] = Yii::t('app','Detail #') .' ' . $id  ;

        $data['grid_columns'] = ReportColumn::getCustomerAllSaleInvoiceDetailColumns();
        
        $report->sale_id = $id;
        $data['data_provider'] = $report->allSaleInvoiceDetail($id);

        $this->renderView($data);

    }

    public function actionSaleDaily()
    {
        //$this->canViewReport();
        authorized('report.sale');


        $grid_id = 'rpt-sale-daily-grid';
        $title = 'Sale Daily';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleDailyColumns();
        $data['data_provider'] = $data['report']->saleDaily();

        $this->renderView($data);
    }

    public function actionSaleHourly()
    {
        //$this->canViewReport();
        authorized('report.sale');

        $grid_id = 'rpt-sale-hourly-grid';
        $title = 'Sale Hourly';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleHourlyColumns();
        $data['data_provider'] = $data['report']->saleHourly();

        $this->renderView($data);
    }

    public function actionSaleSummary()
    {
        //$this->canViewReport();
        authorized('report.sale');

        $grid_id = 'rpt-sale-summary-grid';
        $title = 'Sale Summary';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleSummaryColumns();
        $data['data_provider'] = $data['report']->saleSummary();

        $this->renderView($data);
    }

    public function actionSaleSumBySaleRep()
    {
        authorized('report.sale');

        $grid_id = 'rpt-sale-by-sale-rep-grid';
        $title = 'Sale Summary By Sale Rep';

        $data = $this->commonData($grid_id,$title,null,'_header_4');

        $data['grid_columns'] = ReportColumn::getSaleSumBySaleRepColumns();

        $data['data_provider'] = $data['report']->saleSummaryBySaleRep();

        $this->renderView($data);
    }

    public function actionSaleWeeklyByCustomer()
    {
        //$this->canViewReport();
        authorized('report.sale.analytic');


        $grid_id = 'rpt-sale-weekly-by-customer-grid';
        $title = 'Sale Weekly By Customer';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleWeeklyByCusotmer();
        $data['data_provider'] = $data['report']->saleWeeklyByCustomer();

        $this->renderView($data);
    }

    public function actionSaleInvoiceItem($sale_id, $employee_id)
    {
        if (Yii::app()->user->checkAccess('report.sale')) {
        
            $model = new SaleItem('search');
            $model->unsetAttributes();  // clear any default values

            $payment = new SalePayment('search');
            //$payment->unsetAttributes();
            //$employee=Employee::model()->findByPk((int)$employee_id);
            //$cashier=$employee->first_name . ' ' . $employee->last_name;

            if (isset($_GET['SaleItem']))
                $model->attributes = $_GET['SaleItem'];

            if (Yii::app()->request->isAjaxRequest) {

                Yii::app()->clientScript->scriptMap['*.js'] = false;
                //Yii::app()->clientScript->scriptMap['*.css'] = false;

                if (isset($_GET['ajax']) && $_GET['ajax'] == 'sale-item-grid') {
                    $this->render('sale_item', array(
                        'model' => $model,
                        'payment' => $payment,
                        'sale_id' => $sale_id,
                        'employee_id' => $employee_id
                    ));
                } else {
                    echo CJSON::encode(array(
                        'status' => 'render',
                        'div' => $this->renderPartial('sale_item', array('model' => $model, 'payment' => $payment, 'sale_id' => $sale_id, 'employee_id' => $employee_id), true, true),
                    ));

                    Yii::app()->end();
                }
            } else {
                $this->render('sale_item', array('model' => $model));
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    public function actionTransaction()
    {
        //$this->canViewReport();
        authorized('report.stock');

        $report = new Report;
        $report->unsetAttributes();  // clear any default values
        //$date_view = 0;

        if (!empty($_GET['Report']['sale_id'])) {
            $report->sale_id = $_GET['Report']['sale_id'];
        }

        if (isset($_GET['Report'])) {
            $from_date = $_GET['Report']['from_date'];;
            $to_date = $_GET['Report']['to_date'];;
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $data['report'] = $report;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['grid_id'] = 'sale-summary-grid';
        $data['title'] = 'Sale Summary' .' ' .  Yii::t('app','From') . ' ' . $from_date . '  ' . Yii::t('app','To') . ' ' . $to_date;

        $data['grid_columns'] = ReportColumn::getTransactionColumns();

        $report->from_date = $from_date;
        $report->to_date = $to_date;
        $data['data_provider'] = $report->saleSummary();

        $this->renderView($data,'index_2');


    }

    public function actionTransactionItem($receive_id, $employee_id, $remark)
    {
        $model = new ReceivingItem('search');
        $model->unsetAttributes();  // clear any default values
        //$employee=Employee::model()->findByPk((int)$employee_id);
        //$cashier=$employee->first_name . ' ' . $employee->last_name;

        if (isset($_GET['SaleItem']))
            $model->attributes = $_GET['SaleItem'];

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            //Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'receive-item-grid') {
                $this->render('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark));
        }
    }

    public function actionPayment()
    {
        //$this->canViewReport();
        authorized('report.account');

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            /*
              Yii::app()->clientScript->scriptMap['*.js'] = false;
              Yii::app()->clientScript->scriptMap['*.css'] = false;
              $this->renderPartial('sale_daily', array('report' => $report,'from_date'=>$from_date,'to_date'=>$to_date),false,true);
              Yii::app()->end();
             * 
             */
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('payment_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('payment', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionPaymentReceiveByEmployee()
    {
        //$this->canViewReport();
        authorized('report.account');

        $grid_id = 'rpt-payment-by-employee-grid';
        $title = 'Payment Receive By Employee';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getPaymentReceiveByEmployeeColumns();
        $data['data_provider'] = $data['report']->paymentReceiveByEmployee();

        $this->renderView($data);

    }

    public function actionProfitDailySum()
    {
        authorized('report.account');

        $grid_id = 'rpt-profit-daily-sum-grid';
        $title = 'Profit Daily Sum';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getProfitDailyColumns();
        $data['data_provider'] = $data['report']->profitDailySum();

        $this->renderView($data);
    }

    public function actionProfitByInvoice($id)
    {
        //$this->canViewReport();
        authorized('report.account');

        $report = new Report;

        $from_date = $id;

        $data['report'] = $report;
        $data['from_date'] = $from_date;
        //$data['to_date'] = $to_date;
        $data['grid_id'] = 'rpt-profit-by-invoice-grid';
        $data['title'] = 'Profit By Invoice' .' ' .  Yii::t('app','@') . ' ' . $from_date;

        $data['grid_columns'] = ReportColumn::getProfitByInvoiceColumns();

        $report->from_date = $from_date;
        //$report->to_date = $to_date;
        $data['data_provider'] = $report->profitByInvoice();

        $this->renderView($data);
    }

    public function actionTopItem()
    {
        authorized('report.sale');

        $grid_id = 'rpt-top-item-grid';
        $title = 'Top Item';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getTopItemColumns();
        $data['data_provider'] = $data['report']->topItem();

        $this->renderView($data);
    }

    public function actionItemExpiry($filter = '1')
    {
        //$this->canViewReport();
        authorized('report.stock');

        $grid_id = 'rpt-item-expiry-grid';
        $title = 'Item Expiry';

        $data = $this->commonData($grid_id,$title,null,'_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getItemExpiryHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getItemExpiryColumns();

        $data['data_provider'] = $data['report']->ItemExpiry($filter);

        $this->renderView($data);
    }

    public function actionInventory($filter = 'all')
    {
        //$this->canViewReport();
        authorized('report.stock');

        $grid_id = 'rpt-inventory-grid';
        $title = 'Inventory';

        $data = $this->commonData($grid_id,$title,'show','_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getInventoryHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getInventoryColumns();

        $data['data_provider'] = $data['report']->Inventory($filter);

        $this->renderView($data);

    }
    
    public function actionStockCount($filter = 1)
    {
        //$this->canViewReport();
        authorized('report.stock');

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->shoppingCart->setDayinterval($filter);

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'stockcount-grid') {
                $this->render('stock_count', array('report' => $report, 'filter' => $filter));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('stock_count_ajax', array('report' => $report, 'filter' => $filter), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('stock_count', array('report' => $report, 'filter' => $filter));
        }
    }
    
    public function actionStockCountPrint()
    {
        //$this->canViewReport();
        authorized('report.stock');
       
        $report = new Report;
        $data['report'] = $report;
        $data['filter'] = Yii::app()->shoppingCart->getDayinterval();
        $data['employee'] = ucwords(Yii::app()->session['emp_fullname']);
        $data['trans_date'] = Date('d-m-Y'); 
        $data['save_id'] = Item::model()->saveStockCount(Yii::app()->shoppingCart->getDayinterval());
        $data['items'] = Item::model()->stockItem(Yii::app()->shoppingCart->getDayinterval());
         
        if (count($data['items']) == 0) {
            $data['warning'] = Yii::t('app','There is no item to print...');
            $this->render('stock_count', $data);
        } else {
            $this->layout = '//layouts/column_receipt';
            $this->render('_stock_count_print', $data);
        }
         
    }

    public function actionItemInactive($mfilter = '1')
    {
        //$this->canViewReport();

        authorized('report.stock');

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'rpt-item-inactive-grid') {
                $this->render('item_expiry', array('report' => $report, 'mfilter' => $mfilter));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('item_inactive_ajax', array('report' => $report, 'mfilter' => $mfilter), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('item_inactive', array('report' => $report, 'mfilter' => $mfilter));
        }
    }

    public function actionItemAsset()
    {
        $report = new Report;
        $this->render('item_asset', array('report' => $report));
    }

    public function actionSaleItemSummary()
    {
        //$this->canViewReport();
        authorized('report.sale');

        $grid_id = 'rpt-sale-item-summary-grid';
        $title = 'Sale Item Summary';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleItemSummaryColumns();
        $data['data_provider'] = $data['report']->saleItemSummary();

        $this->renderView($data);
    }
    
    public function actionUserLogSummary($period = 'today')
    {
        $this->canViewReport();

        $report = new Report;
  
        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('user_log_sum_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('user_log_sum', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }
    
    public function actionUserLogDt($employee_id,$full_name)
    {
        $this->canViewReport();

        $model = new UserLog('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['UserLog']))
            $model->attributes = $_GET['UserLog'];

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;
     
            if (isset($_GET['ajax']) && $_GET['ajax'] == 'user-log-dt-grid') {
                $this->render('user_log_dt', array(
                    'model' => $model,
                    'employee_id' => $employee_id,
                    'full_name' => $full_name,
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('user_log_dt', array('model' => $model,'employee_id' => $employee_id,'full_name' => $full_name,), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('user_log_dt', array('model' => $model,'employee_id' => $employee_id,'full_name' => $full_name,));
        }
    }

    public function actionOutStandingInvoice()
    {
        //$this->canViewReport();
        authorized('report.account');

        $grid_id = 'rpt-outstanding-inv-grid';
        $title = 'Outstanding Balance';

        $data = $this->commonData($grid_id,$title,'show');


        $data['grid_columns'] = ReportColumn::getOutStandingInvoiceColumns();
        $data['data_provider'] = $data['report']->outstandingInvoice();

        $this->renderView($data);
    }

	public function actionSaleItemSumbyCust($period = 'today')
    {
        //$this->canViewReport();
        authorized('report.sale');

        $report = new Report;
        //$report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        $this->renderView($data);
    }

    public function actionBalanceByCustomerId($client_id,$balance)
    {

        $model = new SalePayment;

        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => false,
            'bootstrap.js' => false,
            'jquery.min.js' => false,
            'bootstrap.notify.js' => false,
        );

        echo CJSON::encode(array(
            'status' => 'render',
            'div' => $this->renderPartial('//salePayment/partial/_invoice_his', array(
                'model' => $model,
                'client_id' => $client_id,
                'balance' => $balance,
            ), true, true),
        ));
    }


    public function actionAgedCustomerPurchase($filter = '1')
    {
        //$this->canViewReport();
        authorized('report.stock');

        $grid_id = 'rpt-aged-customer-grid';
        $title = 'Aged Customer Purchase';

        $data = $this->commonData($grid_id,$title,null,'_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getAgedCustomerPurchaseHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getAgedCustomerPurchaseColumns();

        $data['data_provider'] = $data['report']->AgedCustomerPurchase($filter);

        $this->renderView($data);
    }

    protected function renderView($data, $view_name='index')
    {
        if (Yii::app()->request->isAjaxRequest && !isset($_GET['ajax']) ) {
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            Yii::app()->clientScript->scriptMap['*.js'] = false;

            $this->renderPartial('partial/_grid', $data);
        } else {
            $this->render($view_name, $data);
        }
    }

    protected function renderSubView($data)
    {
        $this->renderPartial('partial/_grid', $data);
    }

    protected function canViewReport()
    {
        if (!Yii::app()->user->checkAccess('report.index')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    protected function commonData($grid_id,$title,$advance_search=null,$header_view='_header',$grid_view='_grid')
    {
        $report = new Report;

        $data['report'] = $report;
        $data['from_date'] = isset($_GET['Report']['from_date']) ? $_GET['Report']['from_date'] : date('d-m-Y');
        $data['to_date'] = isset($_GET['Report']['to_date']) ? $_GET['Report']['to_date'] : date('d-m-Y');
        $data['search_id'] = isset($_GET['Report']['search_id']) ? $_GET['Report']['search_id'] : '';
        $data['employee_id'] = isset($_GET['Report']['employee_id']) ? $_GET['Report']['employee_id'] : '';
        $data['advance_search'] = $advance_search;
        $data['header_tab'] = '';

        $data['grid_id'] = $grid_id;
        $data['title'] = Yii::t('app', $title) . ' ' . Yii::t('app',
                'From') . ' ' . $data['from_date'] . '  ' . Yii::t('app', 'To') . ' ' . $data['to_date'];
        $data['header_view'] = $header_view;
        $data['grid_view'] = $grid_view;

        $data['report']->from_date = $data['from_date'];
        $data['report']->to_date = $data['to_date'];
        $data['report']->search_id = $data['search_id'];
        $data['report']->employee_id = $data['employee_id'];

        return $data;
    }

    protected function sessionInfo($data=array()) 
    {
        //$data = $this->invoiceData();

        //$data=array();
        //$data['receipt_biz_name'] = Yii::app()->params['biz_name'] !='' ? Yii::app()->params['biz_name'] . '/' : '';

        //$data['receipt_folder'] = Yii::app()->params['biz_name'] !='' ? Yii::app()->params['biz_name'] . '/' : '';
        $data['title']= getTransType() ==param('sale_submit_status') ? 'Order To Validate' : (getTransType()==param('sale_validate_status') ? 'Order To Invoice' : (getTransType()==param('sale_complete_status') ? 'Order To Deliver' : 'Sale Order'));
        $data['invoice_header_view'] = '_header';
        $data['invoice_header_body_view'] = '_header_body';
        $data['invoice_body_view'] = '_body';
        $data['invoice_body_footer_view'] = '_body_footer';
        $data['invoice_footer_view'] = '_footer';
        $data['invoice_no_prefix'] = Common::getInvoicePrefix();

        $sale_id = isset($_GET['sale_id']) ? $_GET['sale_id'] : null;

        //$data['invoice_folder'] = invFolderPath();
        $data['receipt_header_title_kh']=$this->getInvoiceTitle(isset($_GET['tran_type']) ? $_GET['tran_type'] : getTransType(),'kh');
        $data['receipt_header_title_en']=$this->getInvoiceTitle(isset($_GET['tran_type']) ? $_GET['tran_type'] : getTransType(),'en');
        /*$data['receipt_header_view'] =  '_header';
        $data['receipt_body_view'] =  '_body';
        $data['receipt_footer_view'] = null;*/

        $data['tran_type'] = getTransType();
        $tran_type=isset($_GET['tran_type']) ? $_GET['tran_type'] : $data['tran_type'];
        $data['url_back']='saleItem/list?tran_type='.$tran_type.'&user_id='.getEmployeeId().'&title='.$data['title'];
        $data['sale_header'] = isset($_GET['sale_id']) ? ($data['tran_type']==param('sale_complete_status') ? 'Edit Invoice':'Edit Sale Order') : ($data['tran_type']==param('sale_complete_status') ? 'Create Invoice':'Create Sale Order');
        $data['sale_header_icon'] = $data['tran_type']==param('sale_complete_status')? sysMenuInvoiceIcon():sysMenuSaleIcon();
        $data['sale_save_url'] = $data['tran_type']==param('sale_complete_status') ? 'saleItem/CompleteSale':'saleItem/CompleteSale';
        $data['sale_redirect_url'] = $data['tran_type']==param('sale_complete_status')? 'saleItem/SaleInvoice':'saleItem/SaleOrder';
        $data['color_style'] = $data['tran_type']==param('sale_complete_status')? TbHtml::BUTTON_COLOR_SUCCESS:TbHtml::BUTTON_COLOR_PRIMARY;

        $data['items'] = Yii::app()->shoppingCart->getCart();
        $data['count_item'] = Yii::app()->shoppingCart->getQuantityTotal();
        $data['payments'] = Yii::app()->shoppingCart->getPayments();
        $data['count_payment'] = count(Yii::app()->shoppingCart->getPayments());
        $data['payment_received'] = Yii::app()->shoppingCart->getPaymentsTotal();
        $data['sub_total'] = Yii::app()->shoppingCart->getSubTotal();
        $data['total_b4vat'] = Yii::app()->shoppingCart->getTotalB4Vat();
        $data['total'] = Yii::app()->shoppingCart->getTotal();
        $data['total_due'] = Yii::app()->shoppingCart->getTotalDue();
        $data['qtytotal'] = Yii::app()->shoppingCart->getQuantityTotal();
        //$data['amount_change'] = Yii::app()->shoppingCart->getAmountDue(); // This is only work for current invoice
        $data['amount_change'] = Yii::app()->shoppingCart->getTotalDue(); // Outstanding + Current Invoice / Hot Bill - Total Payment
        $data['customer_id'] = Yii::app()->shoppingCart->getCustomer();
        $data['comment'] = Yii::app()->shoppingCart->getComment();
        $data['employee_id'] = Yii::app()->shoppingCart->getEmployee() ? Yii::app()->shoppingCart->getEmployee() : Yii::app()->session['employeeid'];
        $data['salerep_id'] = Yii::app()->shoppingCart->getSaleRep();
        $data['transaction_date'] = date('d/m/Y',strtotime(Yii::app()->shoppingCart->getSaleTime())); //date('d/m/Y');
        $data['transaction_time'] = date('h:i:s',strtotime(Yii::app()->shoppingCart->getSaleTime())); //date('h:i:s');
        $data['session_sale_id'] = Yii::app()->shoppingCart->getSaleId();
        //$data['employee'] = ucwords(Yii::app()->session['emp_fullname']);
        $data['total_discount'] = Yii::app()->shoppingCart->getTotalDiscount();
        $data['total_gst'] = Yii::app()->shoppingCart->getTotalGST();
        $data['sale_mode'] = Yii::app()->shoppingCart->getSaleMode();
        $data['cust_term'] = Yii::app()->shoppingCart->getPaymentTerm();

        $data['disable_editprice'] = Yii::app()->user->checkAccess('sale.editprice') ? false : true;
        $data['disable_discount'] = Yii::app()->user->checkAccess('sale.discount') ? false : true;
        $data['colspan'] = Yii::app()->settings->get('sale','discount')=='hidden' ? '2' : '3';

        $data['discount_amount'] = Common::calDiscountAmount($data['total_discount'],$data['sub_total']);
        $data['gst_amount'] = $data['total_b4vat'] * $data['total_gst']/100;

        $discount_arr=Common::Discount($data['total_discount']);
        $data['discount_amt']=$discount_arr[0];
        $data['discount_symbol']=$discount_arr[1];

        /** Rounding a number to a nearest 10 or 100 (Floor : round down, Ceil : round up , Round : standard round 
         *  Ref: http://stackoverflow.com/questions/1619265/how-to-round-up-a-number-to-nearest-10
         *    ** http://stackoverflow.com/questions/6619377/how-to-get-whole-and-decimal-part-of-a-number
         *  Method : using Round method here 
        */
        $data['usd_2_khr'] = Yii::app()->settings->get('exchange_rate', 'USD2KHR');
        $data['total_khr'] = $data['total'] * $data['usd_2_khr']; 
        $data['amount_change_khr'] = $data['amount_change'] * $data['usd_2_khr']; //Stupid PHP passing calculation 0.9-1 * 4000 = -3999.1 ,  (0.9-1) * 4000 = 400 correct
        
        /*
         * Total is to round up [Ceil] - Company In
         * Amount_Change suppose to round done [Floor] but usually this value is minus so using [Ceil] instead
        */
        $data['total_khr_round'] = ceil($data['total_khr']/100)*100;

        $data['amount_change_khr_round'] = ceil($data['amount_change_khr']/100-0.1)*100; // Got no idea why PHP ceil(-0.1/100)*100 = 399

        $data['amount_change_whole'] = ceil($data['amount_change']);  // floor(1.25)=1
        $data['amount_change_fraction_khr'] = ceil( (( $data['amount_change'] -  $data['amount_change_whole'] ) * $data['usd_2_khr'])/100 - 0.1 ) * 100; //Added 0.1 to solve ceil (-0.1/100)*100=399
               
        /*** Customer Account Info ***/
        $account = $this->custAccountInfo($data['customer_id']);
        $customer = Client::model()->clientByID($data['customer_id']);
        $employee = Employee::model()->employeeByID($data['employee_id']);
        $sale_rep = Employee::model()->employeeByID($data['salerep_id']);
        $group_name = Client::model()->groupByID($data['customer_id']);
        $sale_payment_term = Sale::model()->findByPk($sale_id);
        $data['account'] = $account;
        $data['customer'] = $customer;
        $data['employee'] = $employee;

        $data['acc_balance'] = $account !== null ? $account->current_balance : '';
        $data['cust_fullname'] = $customer !== null ? $customer->last_name . ' ' . $customer->first_name : 'General';
        $data['group_name'] = $group_name !== null ? $group_name : 'General';
        $data['salerep_fullname'] = $sale_rep !== null ? $sale_rep->last_name . ' ' . $sale_rep->first_name : $employee->last_name . ' '  . $employee->first_name;
        $data['salerep_tel'] = $sale_rep !== null ? $sale_rep->mobile_no : '';
        $data['cust_address1'] = $customer !== null ? $customer->address1 : '';
        $data['cust_address2'] = $customer !== null ? $customer->address2 : '';
        $data['cust_mobile_no'] = $customer !== null ? $customer->mobile_no : '';
        $data['cust_fax'] = $customer !== null ? $customer->fax : '';
        $data['cust_notes'] = $customer !== null ? $customer->notes : '';
        $data['cust_contact_fullname'] = '';

        if ($customer !== null) {

            $data['cust_contact_fullname'] = $customer->contact !== null ? $customer->contact->last_name . ' ' . $customer->contact->first_name : '';
            $data['cust_term'] = $data['cust_term'] == null ? $customer->payment_term : $data['cust_term'];
            $payment_term = Common::arrayFactory('payment_term');//
            //s$data['total_due'] = 0 ;
            $data['payment_term'] = '';
            if($sale_payment_term){
                $data['payment_term'] = isset($payment_term[$sale_payment_term->payment_term]) ? $payment_term[$sale_payment_term->payment_term] : $sale_payment_term->payment_term;
            }

        }

        return $data;
    }

    private function getInvoiceTitle($status,$lang='en')
    {
        if($lang=='kh'){
            return $status==param('sale_submit_status') || $status==param('sale_validate_status') ? 'ការបញ្ជាទិញ' : 'វិក័យប័ត្រ';    
        }else{
             return $status==param('sale_submit_status')  || $status==param('sale_validate_status') ? 'Sale Order' : 'Invoice';    
        }
    }

    protected function custAccountInfo($customer_id)
    {
        $model=null;
        if ($customer_id != null) {
            $model = Account::model()->getAccountInfo($customer_id);
        }
        
        return $model;
    }

    protected function renderRecipe($data)
    {
        $this->render('//receipt/'. 'index', $data); 
    }

    protected function renderViewRecipe($data)
    {
        $this->renderPartial('//receipt/'. 'index_view', $data);
    }

    public function colorStatusColumn($status,$status_f)
    {
        switch ($status) {
            case '1':
                echo "<span class='green'>" . $status_f . "</span>";
                break;
            case '2':
                echo "<span class='green'>" . $status_f . "</span>";
                break;
            case '3':
                echo "<span class='green'>" . $status_f . "</span>";
                break;

            default:
                echo $status_f;
        }

    }

    public function renderStatus()
    {
        return "banners";
    }

    public function actionbackupDB()
    {
        //echo Yii::getPathOfAlias('webroot');

        //die();
        $bk_dir= Yii::getPathOfAlias('webroot').'/db_backup';
        $filename='milk_bk_'.date('Ymd');
        echo $filename;

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $database = 'noonight_milk';
        $user = 'homestead';
        $pass = 'secret';
        $host = '192.168.10.10';
        $dir = $bk_dir . '/'.$filename.'.sql';
        echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";
        exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);
    }


}
