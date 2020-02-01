<?php

class ReceivingItemController extends Controller
{
    //public $layout='//layouts/column1';

    /**
     * @return array action filters
     */
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
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('RemoveSupplier','SetComment', 'DeleteItem', 'Add', 'EditItem', 'EditItemPrice', 'Index',
                    'IndexPara', 'AddPayment', 'CancelRecv','cancelCount', 'CompleteRecv', 'Complete', 'SuspendSale', 'DeletePayment', 'SelectSupplier',
                    'AddSupplier', 'Receipt', 'SetRecvMode', 'EditReceiving','SetTotalDiscount','InventoryCountCreate','AddItemCount','GetItemInfo',
                    'CountReview','SaveCount','SetHeader','EditItemCount','ItemCountList','ItemCountDetail'),
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
    
    public function actionIndex($trans_mode = 'receive') 
    {  
        Yii::app()->receivingCart->setMode($trans_mode);
        
        /* To check on performance issue here */
        if ((ckacc('purchasereceive.read') || ckacc('purchasereceive.create') || ckacc('purchasereceive.update')) && Yii::app()->receivingCart->getMode()=='receive') {
            $this->reload();
        } else if ((ckacc('purchasereturn.read') || ckacc('purchasereturn.create') || ckacc('purchasereturn.update'))&& Yii::app()->receivingCart->getMode()=='return') {
            $this->reload(); 
        } elseif (Yii::app()->user->checkAccess('stockcount.create') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
            $this->reload(); 
        } elseif (Yii::app()->user->checkAccess('stockcount.create') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
            $this->reload();
        }

    }

    public function actionItemCountList()
    {
        $grid_id = 'sale-order-grid';

        $data = $this->commonData($grid_id,'Physical Count','show','show');

        $data['grid_columns'] = ReportColumn::getItemCountColumns();

        $data['title'] = 'Physical Count';

        $data['data_provider'] = $data['report']->itemCountList();

        $data['grid_id'] = 'sale-order-grid';

        $data['tran_type'] = 'physical_count';
        $data['tran_mode'] = 'physical_count';
        $data['user_id'] = getEmployeeId();
        $data['url'] = Yii::app()->createUrl('receivingItem/inventoryCountCreate');

        loadview('review','//layouts/report/_grid',$data);
    }

    public function actionItemCountDetail($id)
    {

        authorized('stockcount.read');

        $report = new Report;

        $data['report'] = $report;
        $data['receive_id'] = $id;

        $data['grid_id'] = 'rpt-receiving-item-grid';
        $data['title'] = Yii::t('app','Detail #') .' ' . $id  ;

        $data['grid_columns'] = ReportColumn::getItemcountDetailColumns();

        $report->receive_id = $id;
        $data['data_provider'] = $report->getItemCountDetail($id);

        $this->renderView($data);


    }

    public function actionInventoryCountCreate()
    {

        $this->reload1();

    }

    public function actionGetItemInfo(){
        $item_id = $_POST['ReceivingItem']['item_id'];
        $model = Item::model()->findbyPk($item_id);
        var_dump($model);

    }

    public function actionAddItemCount()
    {

        $data=array();
        $header=array();

        $item_id = $_POST['InventoryCount']['item_id'];

        if (!Yii::app()->receivingCart->addItemToTransfer($item_id,$header,1,false)) {

            Yii::app()->user->setFlash('warning', 'Unable to add item to cart');

        }

        $this->reload1();
        
    }

    public function actionEditItemCount($item_id){

        ajaxRequestPost();

        $data = array();
        $quantity = isset($_POST['InventoryCount']['quantity']) ? $_POST['InventoryCount']['quantity'] : null;

        Yii::app()->receivingCart->editItemToTransfer($item_id, $quantity);

        $this->reload1();

    }
    
    public function actionCountReview(){
        $data['items']=Yii::app()->receivingCart->getItemToTransfer();//initail data from session
        $data['header'] = $this->getCountHeader();
        $this->render('_count_review',$data);
    }

    public function actionSaveCount(){

        $items=Yii::app()->receivingCart->getItemToTransfer();//initail data from session
        $header = $this->getCountHeader();
        $employeeid=Yii::app()->session['employeeid'];

        //save inventory count
        $inventoryCount=new InventoryCount;
        $inventoryCount->name=$header['count_name'];
        $inventoryCount->created_date=$header['created_date'];
        $inventoryCount->save();

        foreach($items as $key=>$item){

            if($item['current_quantity']<0){
                $qty_b4_trans=(-1)*($item['quantity'])-$item['current_quantity'];
                $qty_b4_trans=(-1)*$qty_b4_trans;
            }else{
                $qty_b4_trans=$item['quantity']-$item['current_quantity'];
            }

            $qty_af_trans=$qty_b4_trans+$item['current_quantity'];
            $cost=$qty_b4_trans*$item['cost_price'];

            $inventory_count_data['item_id'] = $item['item_id'];
            $inventory_count_data['count_id'] = $inventoryCount->id;
            $inventory_count_data['expected'] = $item['current_quantity'];
            $inventory_count_data['counted'] = $item['quantity'];
            $inventory_count_data['unit'] = $qty_b4_trans ; 
            $inventory_count_data['cost'] = $cost;

            Sale::model()->saveSaleTransaction(new InventoryCountDetail,$inventory_count_data);              
            //save to inventory

            $inventory_data['trans_items'] = $item['item_id'];
            $inventory_data['trans_user'] = $employeeid;
            $inventory_data['trans_comment'] = 'IPC';
            $inventory_data['trans_inventory'] = (-$item['quantity']);
            $inventory_data['trans_qty'] = $item['quantity'];
            $inventory_data['qty_b4_trans'] = $qty_b4_trans ; 
            $inventory_data['qty_af_trans'] = $qty_af_trans;
            $inventory_data['trans_date'] = date('Y-m-d H:i:s');

            Sale::model()->saveSaleTransaction(new Inventory,$inventory_data);  

            //update item quantity
            $item_model = Item::model()->findbyPk($item['item_id']);

            $item_model->quantity=$item['quantity'];
            $item_model->save();

        }
        Yii::app()->receivingCart->clearItemToTransfer();
        $this->redirect(array('receivingItem/itemCountList'));
    }

    private function getCountHeader()
    {

        $header_data['created_date'] = Yii::app()->receivingCart->getTransferHeader('created_date') ? Yii::app()->receivingCart->getTransferHeader('created_date') : date('Y-m-d');
        $header_data['count_time'] = Yii::app()->receivingCart->getTransferHeader('count_time') ? Yii::app()->receivingCart->getTransferHeader('count_time') : date('H:i:s');
        $header_data['count_name'] = Yii::app()->receivingCart->getTransferHeader('count_name') ? Yii::app()->receivingCart->getTransferHeader('count_name') : 'InventoryCount'.date('Y-m-d');
        $header_data['employee_id'] = Yii::app()->session['employeeid'];

        return $header_data;
    }

    public function actionAdd()
    {   
        //$data=array();
        $item_id = $_POST['ReceivingItem']['item_id'];
        if ((ckacc('purchasereceive.read') || ckacc('purchasereceive.create') || ckacc('purchasereceive.update')) && Yii::app()->receivingCart->getMode()=='receive') {
            $data['warning']=$this->addItemtoCart($item_id);
        } else if ((ckacc('purchasereturn.read') || ckacc('purchasereturn.create') || ckacc('purchasereturn.update'))&& Yii::app()->receivingCart->getMode()=='return') {
           $data['warning']=$this->addItemtoCart($item_id);
        } else if (Yii::app()->user->checkAccess('stock.in') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
           $data['warning']=$this->addItemtoCart($item_id);  
        } else if (Yii::app()->user->checkAccess('stock.out') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
           $data['warning']=$this->addItemtoCart($item_id);   
        } else if ((ckacc('stockcount.read') || ckacc('stockcount.create') || ckacc('stockcount.update')) && Yii::app()->receivingCart->getMode()=='physical_count') {
            $data['warning']=$this->addItemtoCart($item_id);     
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
         
        $this->reload($data);
    }
    
    protected function addItemtoCart($item_id)
    {
        $msg=null;
        if (!Yii::app()->receivingCart->addItem($item_id)) {
            $msg = 'Unable to add item to receiving';
        } 
        return $msg;
    }

    public function actionIndexPara($item_id)
    {
        if (Yii::app()->user->checkAccess('purchase.receive') && Yii::app()->receivingCart->getMode()=='receive') {
            //$recv_mode = Yii::app()->receivingCart->getMode();
            //$quantity = $recv_mode=="receive" ? 1:1; // Change as immongo we will place minus or plus when saving to database
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('purchase.return') && Yii::app()->receivingCart->getMode()=='return') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('stock.in') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('stock.out') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);  
        } else if (Yii::app()->user->checkAccess('stock.count') && Yii::app()->receivingCart->getMode()=='physical_count') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }    
    }

    public function actionDeleteItem($item_id)
    {
        if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->receivingCart->deleteItem($item_id);
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        } 
    }

    public function actionEditItem($item_id)
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $model = new ReceivingItem;

            $quantity = isset($_POST['ReceivingItem']['quantity']) ? $_POST['ReceivingItem']['quantity'] : null;
            $unit_price = isset($_POST['ReceivingItem']['unit_price']) ? $_POST['ReceivingItem']['unit_price'] : null;
            $cost_price = isset($_POST['ReceivingItem']['cost_price']) ? $_POST['ReceivingItem']['cost_price'] : null;
            $discount = isset($_POST['ReceivingItem']['discount']) ? $_POST['ReceivingItem']['discount'] : null;
            $expire_date = isset($_POST['ReceivingItem']['expire_date']) ? $_POST['ReceivingItem']['expire_date'] : null;
            $description = 'test';

            $model->quantity = $quantity;
            $model->unit_price = $unit_price;
            $model->cost_price = $cost_price;
            $model->discount = $discount;
            $model->expire_date = $expire_date;

            if ($model->validate()) {
                Yii::app()->receivingCart->editItem($item_id, $quantity, $discount, $cost_price, $unit_price,
                    $description, $expire_date);
            } else {
                $error = CActiveForm::validate($model);
                $errors = explode(":", $error);
                $data['warning'] = str_replace("}", "", $errors[1]);
                Yii::app()->user->setFlash('danger',$data['warning']);
            }
            $this->reload($data);
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAddPayment()
    {
        if (Yii::app()->request->isPostRequest) {
            if (Yii::app()->request->isAjaxRequest) {
                $payment_id = $_POST['payment_id'];
                $payment_amount = $_POST['payment_amount'];
                //$this->addPaymentToCart($payment_id, $payment_amount);
                Yii::app()->receivingCart->addPayment($payment_id, $payment_amount);
                $this->reload();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }    
    }

    public function actionDeletePayment($payment_id)
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->receivingCart->deletePayment($payment_id);
            $this->reload();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionSelectSupplier()
    {        
         if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            $supplier_id = $_POST['ReceivingItem']['supplier_id'];
            Yii::app()->receivingCart->setSupplier($supplier_id);
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionRemoveSupplier()
    {
        if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->receivingCart->removeSupplier();
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionSetComment()
    {
        Yii::app()->receivingCart->setComment($_POST['comment']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }

    public function actionSetTotalDiscount()
    {
        if (Yii::app()->request->isPostRequest) {
            $data= array();
            $model = new ReceivingItem;
            $total_discount =$_POST['ReceivingItem']['total_discount'];
            $model->total_discount=$total_discount;

            if ($model->validate()) {
                Yii::app()->receivingCart->setTotalDiscount($total_discount);
            } else {
                $error=CActiveForm::validate($model);
                $errors = explode(":", $error);
                $data['warning']=  str_replace("}","",$errors[1]);
            }

            $this->reload($data);
        }
    }

    public function actionSetRecvMode()
    {
        Yii::app()->receivingCart->setMode($_POST['recv_mode']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }

    private function reload($data=array())
    {
        $this->layout = '//layouts/column_sale';
        
        $model = new ReceivingItem;
        $data['model'] = $model;
       
        $data=$this->sessionInfo($data);
        
        //echo $data['trans_header']; die();
        //$data['n_item_expire']=ItemExpir::model()->count('item_id=:item_id and quantity>0',array('item_id'=>(int)$item_id));
        
        $model->comment = $data['comment'];
        $model->total_discount= $data['total_discount'];
        
        if ($data['supplier_id'] != null) {
            $supplier = Supplier::model()->findbyPk($data['supplier_id']);
            $data['supplier'] = $supplier;
            //$data['company_name'] = $supplier->company_name;
            //$data['full_name'] = $supplier->first_name . ' ' . $supplier->last_name;
            //$data['mobile_no'] = $supplier->mobile_no;
        }

        loadview('index','index',$data);
    }

    public function actionCancelRecv()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            Yii::app()->receivingCart->clearAll();
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionCancelCount()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            Yii::app()->receivingCart->clearAll();
            $this->reload1();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionCompleteRecv()
    {
        $data = $this->sessionInfo();

        if (empty($data['items'])) {
            $this->redirect(array('receivingItem/index'));
        } else {
            //Save transaction to db
            $data['receiving_id'] = Receiving::model()->saveRevc($data['items'], $data['payments'],
                $data['supplier_id'], $data['employee_id'], $data['sub_total'], $data['total'], $data['comment'], $data['trans_mode'],
                $data['discount_amt'],$data['discount_symbol']
            );

            if (substr($data['receiving_id'], 0, 2) == '-1') {
                $data['warning'] = $data['receiving_id'];
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                    '<strong>Oh snap!</strong>' . $data['receiving_id']);
                $this->reload();
            } else {
                //$trans_mode = Yii::app()->receivingCart->getMode();
                Yii::app()->receivingCart->clearAll();
                $this->redirect(array('receivingItem/index', 'trans_mode' => $data['trans_mode']));
            }
        }
    }

    public function actionSuspendRecv()
    {
        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['sub_total'] = Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['supplier_id'] = Yii::app()->receivingCart->getSupplier();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['transaction_time'] = date('m/d/Y h:i:s a');
        $data['employee'] = ucwords(Yii::app()->session['emp_fullname']);

        //Save transaction to db
        $data['sale_id'] = 'POS ' . SaleSuspended::model()->saveSale($data['items'], $data['payments'], $data['supplier_id'], $data['employee_id'], $data['sub_total'], $data['comment']);

        if ($data['sale_id'] == 'POS -1') {
            echo CJSON::encode(array(
                'status' => 'failed',
                'message' => '<div class="alert in alert-block fade alert-error">Transaction Failed.. !<a class="close" data-dismiss="alert" href="#">&times;</a></div>',
            ));
        } else {
            Yii::app()->receivingCart->clearAll();
            $this->reload();
        }
    }

    public function actionUnsuspendRecv($sale_id)
    {
        Yii::app()->receivingCart->clearAll();
        Yii::app()->receivingCart->copyEntireSuspendSale($sale_id);
        SaleSuspended::model()->deleteSale($sale_id);
        //$this->reload();
        $this->redirect('index');

    }

    public function actionEditReceiving($receiving_id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            Yii::app()->receivingCart->clearAll();
            Yii::app()->receivingCart->copyEntireReceiving($receiving_id);
            Receiving::model()->deleteReceiving($receiving_id);
            //$this->reload();
            $this->redirect('index');
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
        
    }

    public function actionSetHeader()
    {
        if (isset($_POST['InventoryCount']['created_date'])) {
            
            $created_date = $_POST['InventoryCount']['created_date'];
            Yii::app()->receivingCart->setTransferHeader($created_date,'created_date');

        }
        if (isset($_POST['InventoryCount']['count_time'])) {
            
            $count_time = $_POST['InventoryCount']['count_time'];
            Yii::app()->receivingCart->setTransferHeader($count_time,'count_time');

        }
        if (isset($_POST['InventoryCount']['count_name'])) {
            
            $count_name = $_POST['InventoryCount']['count_name'];
            Yii::app()->receivingCart->setTransferHeader($count_name,'count_name');

        }

        $this->reload1();
    }

    private function reload1($data=array())
    {
        $this->layout = '//layouts/column_sale';

        $model = new InventoryCount('search');
        $item = new Item('search');
        $receiveItem = new ReceivingItem;

        $items=Yii::app()->receivingCart->getItemToTransfer();
        $data['items'] = $items;

        $data['model'] = $model;
        $data['receiveItem'] = $receiveItem;
        $data['grid_id'] = strtolower(get_class($model)) . '-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['create_url'] = 'inventoryCountCreate';

        loadview('_form','_form',$data);
    }
    
    protected function sessionInfo($data=array()) 
    {
        $data['supplier'] = null;

        $data['trans_mode'] = Yii::app()->receivingCart->getMode();
        $data['trans_header'] = Receiving::model()->transactionHeader();
        $data['status'] = 'success';
        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['payment_total'] = Yii::app()->receivingCart->getPaymentsTotal();
        $data['count_item'] = Yii::app()->receivingCart->getQuantityTotal();
        $data['count_payment'] = count(Yii::app()->receivingCart->getPayments());
        $data['sub_total']=Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['amount_due'] = Yii::app()->receivingCart->getAmountDue();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $data['supplier_id'] = Yii::app()->receivingCart->getSupplier();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['total_discount'] = Yii::app()->receivingCart->getTotalDiscount();
        $data['discount_amount'] = Common::calDiscountAmount($data['total_discount'],$data['sub_total']);

        $discount_arr=Common::Discount($data['total_discount']);
        $data['discount_amt']=$discount_arr[0];
        $data['discount_symbol']=$discount_arr[1];

        $data['hide_editprice'] = Yii::app()->user->checkAccess('transaction.editprice') ? '' : 'hidden';
        $data['hide_editcost'] = Yii::app()->user->checkAccess('transaction.editcost') ? '' : 'hidden';

        $data['disable_discount'] = Yii::app()->user->checkAccess('sale.discount') ? false : true;


        if (Yii::app()->settings->get('item', 'itemExpireDate') == '1') {
            $data['expiredate_class']='';
        } else {
            $data['expiredate_class']='hidden';
        } 
        
      
        return $data;
    }

    protected function commonData($grid_id,$title,$title_icon,$advance_search=null,$header_view='_header',$grid_view='_grid')
    {
        $report = new Report;

        $data['report'] = $report;
        $data['from_date'] = isset($_GET['Report']['from_date']) ? $_GET['Report']['from_date'] : date('d-m-Y');
        $data['to_date'] = isset($_GET['Report']['to_date']) ? $_GET['Report']['to_date'] : date('d-m-Y');
        $data['search_id'] = isset($_GET['Report']['search_id']) ? $_GET['Report']['search_id'] : '';
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

        return $data;
    }

    protected function renderView($data, $view_name='index')
    {
        if (Yii::app()->request->isAjaxRequest && !isset($_GET['ajax']) ) {
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            Yii::app()->clientScript->scriptMap['*.js'] = false;

            /*
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('partial/_grid', $data, true, false),
            ));
            */
            $this->renderPartial('partial/_grid', $data);
        } else {
            $this->render($view_name, $data);
        }
    }

    public function setSession($value)
    {
        $this->session = $value;
    }

}
