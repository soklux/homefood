<?php

class PriceBookController extends Controller
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
                'actions' => array('Index','View','Create','AddItem','Admin','SavePriceBook','EditPriceBook'),
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
    
    public function actionAdmin() 
    {  
        authorized('pricebook.read');

        $this->setSession(Yii::app()->session);
        unset(Yii::app()->session['itemsApplied']);
        unset(Yii::app()->session['pricebookHeader']);
        $model = new PriceBook('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PriceBook'])) {
            $model->attributes = $_GET['PriceBook'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $model->pricebook_archived = Yii::app()->user->getState('pricebook_archived',
            Yii::app()->params['defaultArchived']);

        $page_size = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState(strtolower(get_class($model)) . '_page_size', Common::defaultPageSize()),
            Common::arrayFactory('page_size'),
            array('class' => 'change-pagesize')
        );


        $data['model'] = $model;
        $data['grid_id'] = strtolower(get_class($model)) . '-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['page_size'] = $page_size;
        //$data['create_url'] = 'create';

        $data['grid_columns'] = PriceBook::getItemColumns();
        $data['data_provider'] = $model->search();

        $this->render('_list',$data);
    }

    public function actionView($id,$name=''){
        authorized('pricebook.read');
        $priceBook=PriceBook::getPriceBookDetail($id,$name);

        $data['data']=$priceBook;
        $data['count_title']='pricebook';
        $this->render('_pricebookDetail',$data);
    }

    public function actionCreate() {

        $this->layout = '//layouts/columntree';

        authorized('pricebook.create');

        //$invcount=new InventoryCount;
        $model = new PriceBook('search');
        $item = new Item('search');
        $outlet = Outlet::model()->findAll();
        $customer_group = CustomerGroup::model()->findAll();
        $this->setSession(Yii::app()->session);
        $this->session['pricebookHeader']=array('name'=>'','customer_group'=>'','outlet'=>'');
        $items=$this->session['itemsApplied'];//initail data from session
        $data['model'] = $model;
        $data['outlet'] = $outlet;
        $data['items']=$items;
        $data['customer_group'] = $customer_group;
        $this->render('create',$data);
    }

    public function actionGetItemInfo(){
        $item_id = $_POST['ReceivingItem']['item_id'];
        $model = Item::model()->findbyPk($item_id);
        var_dump($model);

    }

    public function actionAddItem(){
         $info=Item::model()->findbyPk($_POST['itemId']);
         // var_dump($info['quantity']);
         $this->setSession(Yii::app()->session);

         $data=$this->session['itemsApplied'];//initail data from session

         if($_POST['opt']==1){

            $itemId=$_POST['itemId'];//item id
            $itemName=$_POST['proName'];//item name
            $start_date=$_POST['start_date'];//price book valid start date
            $end_date=$_POST['end_date'];//price book valid end date
            $outlet=$_POST['outlet'];//price book apply to outlet
            
            $group_id=$_POST['group_id'];//price book apply to outlet
            $price_book_name=$_POST['price_book_name'];//price book name

            $this->session['pricebookHeader']=array('name'=>$price_book_name,'outlet'=>$outlet,'start_date'=>$start_date,'end_date'=>$end_date,'customer_group'=>$group_id);
           
            $data[]=array('itemId'=>$itemId,'name'=>$itemName,'cost'=>$info['cost_price'],'markup'=>0,'discount'=>0,'retail_price'=>$info['unit_price'],'min_qty'=>'','max_qty'=>'');
         
            $this->session['itemsApplied']=$data;//after update or add item to data then update the session
        }elseif($_POST['opt']==2){//remove counted item
            unset($_SESSION['itemsApplied'][$_POST['idx']]); 
        }elseif($_POST['opt']==3){
            $val=$_POST['val'];
            $idx=$_POST['idx'];
            //var_dump($this->session['itemsApplied']);
            if(!empty($data)){//check if data is not empty
                $retailAfMarkup=0;
                $discount=0;
                foreach($data as $k=>$v){
                    $cost=$data[$k]['cost']>0 ? $data[$k]['cost'] : 1;
                    if($val=='markupall' || $val=='discountall'){

                        $markupall=$_POST['markupall']>0 ? $_POST['markupall'] : 0;
                        $discountall=$_POST['discountall']>0 ? $_POST['discountall'] : 0;
                        if($val=='markupall'){
                            $data[$k]['markup']=$markupall;    
                        }
                        if($val=='discountall'){
                            $data[$k]['discount']=$discountall;    
                        }
                        $retailAfMarkup=$cost+($cost*($data[$k]['markup']/100));
                        $discount=$retailAfMarkup*($data[$k]['discount']/100);
                        $data[$k]['retail_price']=$retailAfMarkup-$discount;
                        
                        

                    }
                    if($k==$idx){//update number of quantity count when item already counted

                        if($val=='markup' || $val=='discount'){
                            
                            $data[$k]['markup']=$_POST['markup'];
                            $retailAfMarkup=round(($cost+($cost*($_POST['markup']/100))),4);
                            $discount=round(($retailAfMarkup*($_POST['discount']/100)),2);
                            $data[$k]['retail_price']=$retailAfMarkup-$discount;
                            $data[$k]['discount']=$_POST['discount'];

                        }
                        if($val=='retail_price'){

                            $data[$k]['discount']=0;

                            $data[$k]['retail_price']=$_POST['retail_price'];

                            $data[$k]['markup']=round(((($_POST['retail_price']*100)/$cost)-100),2);//update array data
                        }
                        if($val=='min_qty'){

                            $data[$k]['min_qty']=$_POST['min_qty'];

                        }
                        if($val=='max_qty'){

                            $data[$k]['max_qty']=$_POST['max_qty'];

                        }
                        
                    }
                }

            }
            
            $this->session['itemsApplied']=$data;//after update or add item to data then update the session
        }
        $model = new PriceBook('search');
        $item = new Item('search');
        $outlet = Outlet::model()->findAll();
        $customer_group = CustomerGroup::model()->findAll();
        $data['model'] = $model;
        $data['outlet'] = $outlet;
        $data['items']=$this->session['itemsApplied'];
        $data['customer_group'] = $customer_group;
        // $this->renderPartial('partial/_table',$data);
        loadview('priceBook','partial/_table',$data);
        
    }

    public function actionSavePriceBook($id=''){
        $price_book_name = $_POST['PriceBook']['price_book_name'];
        $outlet_id = $_POST['PriceBook']['outlet_id'];
        $group_id = $_POST['PriceBook']['group_id'];
        $start_date = $_POST['PriceBook']['start_date'];
        $end_date = $_POST['PriceBook']['end_date'];
        $this->setSession(Yii::app()->session);
        $data = $this->session['itemsApplied'];//initail data from session
        //$header=$this->session['pricebookHeader'];//initail data from session
        //echo $group_id;
        //save inventory count
        $priceBook=new PriceBook;
        //$pricing=new Pricing;
        $criteria = new CDbCriteria();
        $criteria->condition = 'price_book_name=:name';
        $criteria->params = array(':name'=>$price_book_name);
        $exists = $priceBook->exists($criteria);
        $transaction = Yii::app()->db->beginTransaction();
        
        try {
            if($exists and ($id=='' or $id==0)){
                $this->redirect(array('/PriceBook/create','name'=>$price_book_name,'status'=>'error'));
            }elseif($price_book_name==''){
                $this->redirect(array('/PriceBook/create','name'=>'','status'=>'error'));
            }else{
                $connection = Yii::app()->db;
                if($id>0){
                    $price_book_id=$id;
                    PriceBook::model()->updateByPk($id,
                        array(
                            'price_book_name'=>$price_book_name,
                            'start_date'=>date('Y-m-d H:i:s',strtotime($start_date)),
                            'end_date'=>date('Y-m-d H:i:s',strtotime($end_date)),
                            'outlet_id'=>$outlet_id,
                            'group_id'=>$group_id
                        )
                    );
                    $delSql="delete from pricings where price_book_id=".$price_book_id;
                    $command = $connection->createCommand($delSql);
                    $delete = $command->execute();
                    
                }else{
                    $priceBook->price_book_name=$price_book_name;
                    $priceBook->start_date=$start_date;
                    $priceBook->end_date=$end_date;
                    $priceBook->outlet_id=$outlet_id;
                    $priceBook->group_id=$group_id;
                    $saveHeader=$priceBook->save();
                    $price_book_id = $priceBook->id;
                }
               
                if(!empty($data)){
                    //save item
                    foreach($data as $key=>$value){

                        $invSql="insert into pricings
                        (price_book_id,item_id,cost,markup,discount,retail_price,min_unit,max_unit)
                        values(".$price_book_id.",".$value['itemId'].",".$value['cost'].",".$value['markup'].",".$value['discount'].",".$value['retail_price'].",".($value['min_qty']>0 ? $value['min_qty'] : 9999).",".($value['max_qty']>0 ? $value['max_qty'] : 9999).")";
                        $command = $connection->createCommand($invSql);
                        $insert = $command->execute(); // execute the non-query SQL
                        //echo $invSql;
                    }
                }
                
                $transaction->commit();
                unset(Yii::app()->session['itemsApplied']);
                unset(Yii::app()->session['pricebookHeader']);
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                                'Price book : <strong>' . $price_book_name . '</strong> have been saved successfully!');
                $this->redirect(array('/priceBook/admin'));
            }
        }catch (Exception $e) {
            $transaction->rollback();
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING, 'Oop something wrong : <strong>' . $e);
        }
        
    }

    public function actionEditPriceBook($id){

        $this->layout = '//layouts/columntree';

        authorized('pricebook.update');

        $this->setSession(Yii::app()->session);
        $priceBook=PriceBook::getPriceBookEdit($id);
        $model = new PriceBook('search');
        //$item = new Item('search');
        $outlet = Outlet::model()->findAll();
        $customer_group = CustomerGroup::model()->findAll();
        $this->session['pricebookHeader']=$priceBook['data'];
        // print_r($priceBook);
        $this->session['itemsApplied']=isset($priceBook['data']['item']) ? $priceBook['data']['item'] : array();
        $data['model'] = $model;
        $data['outlet'] = $outlet;
        $data['items']=$this->session['itemsApplied'];
        $data['customer_group'] = $customer_group;
        $this->render('create',$data);
        //var_dump($this->session['itemsApplied']);
    }

    public function actionAdd()
    {   
        //$data=array();
        $item_id = $_POST['ReceivingItem']['item_id'];
        if (Yii::app()->user->checkAccess('purchase.receive') && Yii::app()->receivingCart->getMode()=='receive') {
            $data['warning']=$this->addItemtoCart($item_id);
        } else if (Yii::app()->user->checkAccess('purchase.return') && Yii::app()->receivingCart->getMode()=='return') {
           $data['warning']=$this->addItemtoCart($item_id);
        } else if (Yii::app()->user->checkAccess('stock.in') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
           $data['warning']=$this->addItemtoCart($item_id);  
        } else if (Yii::app()->user->checkAccess('stock.out') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
           $data['warning']=$this->addItemtoCart($item_id);   
        } else if (Yii::app()->user->checkAccess('stock.count') && Yii::app()->receivingCart->getMode()=='physical_count') {
            $data['warning']=$this->addItemtoCart($item_id);     
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
         
        $this->reload($data);
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

    public function setSession($value)
    {
        $this->session = $value;
    }

}

