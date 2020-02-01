<?php

class ItemController extends Controller
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
            array(
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    //'create',
                    'create',
                    'update',
                    'UpdateImage',
                    'delete',
                    'UndoDelete',
                    'GetItem',
                    'Inventory',
                    'admin',
                    'AutocompleteItem',
                    'SelectItem',
                    'SelectItemRecv',
                    'SelectItemClient',
                    'CostHistory',
                    'PriceHistory',
                    'LowStock',
                    'OutStock',
                    'loadImage',
                    'Assemblies',
                    'AssembliesCreate',
                    'GetProduct2',
                    'GetItemMain',
                    'NextId',
                    'PreviousId',
                    'AddPriceQty',
                    'ReloadCategory',
                    'ParentReload',
                    'saveCategory',
                    'ItemFinder',
                    'CategoryTree',
                    'GetProductByCategory',
                    'ItemSearch',
                    'GetBarcodeNum',
                    'PreviewBarcode',
                    'PrintBarcodeLabel',
                    'AddItemBarcode',
                    'DeleteItemBarcode',
                    'EditItemBarcode',
                    'PreviewItemBarcode',
                    'resetItemBarcode', 
                    'Pdf'
                ),
                'users' => array('@'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionTestExcel()
    {
        $model = new Item();
        $this->render('readExcel', array('model' => $model));
    }

    public function actionAddProduct()
    {
        $this->render('_form_product');
    }

    public function actionDelete($id)
    {
        authorized('item.delete');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            // we only allow deletion via POST request
            //$this->loadModel($id)->delete();
            Item::model()->deleteItem($id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

    }

    public function actionUndoDelete($id)
    {
        if (Yii::app()->user->checkAccess('item.delete')) {
            if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
                Item::model()->undodeleteItem($id);
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Item');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {

        authorized('item.read');

        $model = new Item('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->item_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

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

        $data['grid_columns'] = Item::getItemColumns();

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);

    }

    public function loadModel($id)
    {
        $model = Item::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    public function loadModelItemcode($item_code)
    {
        $model = Item::model()->find('item_number=:item_number', array(':item_number' => $item_code));

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCreate($grid_cart = 'N', $sale_status = '2')
    {
        authorized('item.create');

        $this->layout = '//layouts/columntree';

        $model = new Item;
        $item_image = new ItemImage;
        $this->performAjaxValidation($model);

        if (isset($_POST['Item'])) {
            $model->attributes = $_POST['Item'];
            
            $this->setSession(Yii::app()->session);

            $this->session['tags']=$_POST['Item']['tags'];

            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save()) {

                        if($model->id>0){//check if item id exist after saved to table
                            //save image
                            $this->multipleImageUpload($model->id,$model,'image');

                            $connection = Yii::app()->db;//initial connection to run raw sql 
                            if(isset($_POST['Item']['tags'])){
                                $str = $_POST['Item']['tags'];
                                $tagsArry=explode(",",$str);
                                foreach($tagsArry as $key=>$value){ //loop data from price quantity
                                    
                                    $tagID=Tag::model()->saveTag($value);
                                    
                                    $ptagSql="insert into product_tag(product_id,tag_id) values(".$model->id.",".$tagID.")";
                                    
                                    $command = $connection->createCommand($ptagSql);
                                    $insertProductTag = $command->execute(); 
                                    
                                }
                            }
                        }
                        unset($this->session['tags']);
                        $transaction->commit();
                        if ($grid_cart == 'N') {
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                                'Item : <strong>' . $model->name . '</strong> have been saved successfully!');
                            $this->redirect(array('create'));
                        } elseif ($grid_cart == 'S') {
                            Yii::app()->shoppingCart->addItem($model->id);
                            $this->redirect(array('saleItem/update?tran_type=?' . $sale_status));
                        } elseif ($grid_cart == 'R') {
                            Yii::app()->receivingCart->addItem($model->id);
                            $this->redirect(array('receivingItem/index'));
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING, 'Oop something wrong : <strong>' . $e);
                }
            }
        }

        $data['model'] = $model;
        $data['measurable'] = UnitMeasurable::model()->findAll();
        $data['categories']=Category::model()->findAll();
        $data['product_types']=ProductType::model()->findAll();
        $data['product_models']=ProductModel::model()->findAll();
        $data['supplier'] = Supplier::model()->findAll();
        $data['brand'] = Brand::model()->findAll();
        $data['image']=$item_image;
        $this->render('create2', $data);

    }

    public function actionAddPriceQty()
    {
        $this->setSession(Yii::app()->session);

        $data=$this->session['priceQty'];
        $data[]=array('From'=>$_POST['from'],'To'=>$_POST['to'],'Price'=>$_POST['price']);
        $id=0;
        $this->session['priceQty']=$data;
    }

    public function actionUpdateImage($id, $item_number_flag = '0')
    {
        authorized('item.update');

        $this->layout = '//layouts/columntree';

        $imageModel=new ItemImage;

        if ($item_number_flag == '0') {
            $model = $this->loadModel($id);
        } else {
            $model = Item::model()->find('item_number=:item_number or (sku=:item_number or mpn=:item_number or isbn=:item_number)', array(':item_number' => $id));
        }

        $this->setSession(Yii::app()->session);
        $tagsArry=Tag::model()->getTagByItemId($id);
        $tagsItem='';

        foreach($tagsArry as $value) {
            // $value.=",".$value;
            $tagsItem.=",".$value['tag_name'];
        }

        $this->session['tags']=substr($tagsItem, 1);
        $item_image = ItemImage::model()->findAllByAttributes(array('item_id'=>$id));
        $next_id = Item::model()->getNextId($id);
        $previous_id = Item::model()->getPreviousId($id);
        $next_disable = $next_id === null ? 'disabled' : '';
        $previous_disable = $previous_id === null ? 'disabled' : '';

        $this->performAjaxValidation($model);

        if (isset($_POST['Item'])) {

            $old_price = $model->unit_price;
            $model->attributes = $_POST['Item'];
            $this->session['tags']=$_POST['Item']['tags'];

            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save()) {

                        if (isset($_POST['Item']['count_interval'])) {
                            Item::model()->saveItemCounSchedule($model->id);
                        }
                               
                        if($model->id>0){//check if item id exist after saved to table
                            if(isset($_FILES['image'])){
                                foreach($_FILES['image']['name'] as $img){
                                    if($img!=''){
                                        $cur_image=ItemImage::model()->findAllByAttributes(array('item_id'=>$id));
                                        foreach($cur_image as $img){
                                            $img_file=Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $id.'/'.$img['filename'];
                                            if(file_exists($img_file)){
                                                unlink($img_file);
                                            }
                                        }
                                        ItemImage::model()->deleteAll(array('condition'=>'`item_id`=:item_id','params'=>array(':item_id'=>$id)));
                                        $this->multipleImageUpload($id,$model,'image');
                                        break;
                                    }
                                }
                            }

                            $connection = Yii::app()->db;

                            if(isset($_POST['Item']['tags'])){
                                $sql="DELETE t,pt
                                FROM tag t JOIN product_tag pt
                                ON t.id=pt.tag_id JOIN item i
                                ON pt.product_id=i.id
                                WHERE i.id=".$id;
                                $command = $connection->createCommand($sql);
                                $command->execute();
                                $str = $_POST['Item']['tags'];
                                $tagsArry=explode(",",$str);
                                foreach($tagsArry as $key=>$value){//loop data from price quantity
                                    
                                    $tagID=Tag::model()->saveTag($value);
                                    
                                    $ptagSql="insert into product_tag(product_id,tag_id) values(".$model->id.",".$tagID.")";
                                    $command = $connection->createCommand($ptagSql);
                                    $insertProductTag = $command->execute(); // execute the non-query SQL
                                    // }
                                    
                                }
                            }
                        }
                        unset($this->session['tags']);
                        $this->addImages($model);
                        $transaction->commit();
                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                            'Item Id : <strong>' . $model->name . '</strong> have been saved successfully!');
                        $this->redirect(array('admin'));
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING, 'Oop something wrong : <strong>' . $e);
                }
            }
        }

        $data['model'] = $model;
        $data['next_disable'] = $next_disable;
        $data['previous_disable'] = $previous_disable;
        $data['item_image'] = ItemImage::model()->findAllByAttributes(array('item_id'=>$id));
        $data['categories']=Category::model()->findAll();
        $data['product_types']=ProductType::model()->findAll();
        $data['product_models']=ProductModel::model()->findAll();
        $data['measurable'] = UnitMeasurable::model()->findAll();
        $data['supplier'] = Supplier::model()->findAll();
        $data['brand'] = Brand::model()->findAll();
        $data['image']=$imageModel;

        $this->render('update2', $data);
    }

    public function actionAssemblies()
    {
        authorized('assemblyitem.read');

        $model = new AssemblyItem('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AssemblyItem'])) {
            $model->attributes = $_GET['AssemblyItem'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

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
        $data['create_url'] = 'AssembliesCreate';

        $data['grid_columns'] = AssemblyItem::getItemColumns();

        $data['data_provider'] = $model->search();
        $this->render('assemblies',$data);
    }

    public function actionAssembliesCreate()
    {
        authorized('AssemblyItem.create');
        $model=new AssemblyItem;
        $assembly_item=AssemblyItem::model()->getListAssemblyItemUpdate(0);
        if ($model->validate()) {
            $transaction = $model->dbConnection->beginTransaction();
                //$transaction = Yii::app()->db->beginTransaction();
                try {
                    //save price quantity range
                    $connection = Yii::app()->db;//initial connection to run raw sql 
                    if(isset($_POST['assembly_item'])){
                        $item_id=$_POST['AssemblyItem']['item_id'];
                        foreach($_POST['assembly_item'] as $key=>$value){//loop data from price quantity

                            $sql = "insert into assembly_item(item_id,assembly_name,quantity,unit_price) values(" .$item_id. ",'" . $value['assembly_name'] . "'," . $value['quantity'] . "," . $value['unit_price'] . ")";
                            $command = $connection->createCommand($sql);
                            $insert = $command->execute(); // execute the non-query SQL
                        }
                        $transaction->commit();
                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                                'Assemblies have been saved successfully!');
                            $this->redirect(array('AssembliesCreate'));
                    }

                    
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING, 'Oop something wrong : <strong>' . $e);
                }
            }
        $this->render('_form_item_assembly',array('model'=>$model,'assembly_item'=>$assembly_item));
    }

    public function actionGetItemMain()
    {
        $res = array();
        //if (isset($_GET['term'])) {
            // http://www.yiiframework.com/doc/guide/database.dao
            $qtxt = "SELECT name AS text FROM item";
            $command = Yii::app()->db->createCommand($qtxt);
            $res = $command->queryColumn();
        //}

        echo CJSON::encode($res);
        Yii::app()->end();
    }

    public function actionAutocompleteItem()
    {
        $res = array();
        if (isset($_GET['term'])) {
            // http://www.yiiframework.com/doc/guide/database.dao
            $qtxt = "SELECT id,concat_ws(' : ',name,unit_price) AS text FROM item WHERE name LIKE :item_name";
            $command = Yii::app()->db->createCommand($qtxt);
            $command->bindValue(":item_name", '%' . $_GET['term'] . '%', PDO::PARAM_STR);
            $res = $command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();
    }

    public function actionGetItem()
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = Item::model()->getItem($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();
        }
    }

    public function actionInventory($item_id)
    {
        $model = $this->loadModel($item_id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Item'])) {
            $model->attributes = $_POST['Item'];

            if (empty($_POST['Item']['items_add_minus'])) {
                $valid = false;
                $model->addError('items_add_minus', 'Cannot be blank.');
            } elseif (empty($_POST['Item']['inv_comment'])) {
                $valid = false;
                $model->addError('inv_comment', 'Cannot be blank.');
            } else {
                $new_quantity = $_POST['Item']['items_add_minus'];
                $valid = $model->validate();
            }

            if ($valid) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    $cur_quantity = $model->quantity;
                    $model->quantity = $cur_quantity + $new_quantity;
                    if ($model->save()) {
                        //Ramel Inventory Tracking
                        $inventory = new Inventory;
                        $sale_remarks = $_POST['Item']['inv_comment'];
                        $inventory->trans_items = $model->id;
                        $inventory->trans_user = Yii::app()->user->id;
                        $inventory->trans_comment = $sale_remarks;
                        $inventory->trans_inventory = $new_quantity;
                        $inventory->trans_date = date('Y-m-d H:i:s');

                        if (!$inventory->save()) {
                            $transaction->rollback();
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            echo CJSON::encode(array(
                                'status' => 'falied',
                                'div' => "<div class=alert alert-info fade in> Something wrong! </div>" . Yii::app()->user->id . var_dump($inventory->getErrors()),
                            ));
                            Yii::app()->end();
                        }

                        $transaction->commit();
                        //Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => "<div class=alert alert-info fade in> Successfully updated ! </div>",
                        ));
                        Yii::app()->end();
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    print_r($e);
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            Yii::app()->clientScript->scriptMap['*.js'] = false;

            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_inventory', array('model' => $model), true, false),
            ));

            Yii::app()->end();
        } else {
            $this->render('_inventory', array('model' => $model));
        }
    }

    public function actionGetProduct2()
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = Item::getProduct2($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();

        }
    }

    public function actionSelectItem()
    {
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        if (Yii::app()->request->isAjaxRequest) {
            //Yii::app()->clientScript->scriptMap['*.js'] = false;
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                //'bootstrap.js'=>false,
                //'jquery.ba-bbq.min.js'=>false,
                //'jquery.yiigridview.js'=>false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'select-item-grid') {
                $this->render('_select_item', array(
                    'model' => $model
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_select_item', array('model' => $model), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_select_item', array('model' => $model));
        }
    }

    public function actionSelectItemRecv()
    {
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        if (Yii::app()->request->isAjaxRequest) {
            //Yii::app()->clientScript->scriptMap['*.js'] = false;
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                //'bootstrap.js'=>false,
                //'jquery.ba-bbq.js'=>false,
                //'jquery.ba-bbq.min.js' => false,
                //'jquery.yiigridview.js'=>false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );

            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'select-item-recv-grid') {
                $this->render('_select_item_recv', array(
                    'model' => $model
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_select_item_recv', array('model' => $model), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_select_item_recv', array('model' => $model));
        }
    }

    public function actionSelectItemClient()
    {
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        if (Yii::app()->request->isAjaxRequest) {
            //Yii::app()->clientScript->scriptMap['*.js'] = false;
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.min.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'select-item-grid') {
                $this->render('_select_item_client', array(
                    'model' => $model
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('_select_item_client', array('model' => $model), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('_select_item_client', array('model' => $model));
        }
    }

    public function actionCostHistory($item_id)
    {
        $model = new Item;

        $item = Item::model()->getItemInfo((int)$item_id);
        $avg_cost = Item::model()->avgCost((int)$item_id);

        $data['model'] = $model;
        $data['item'] = $item;
        $data['item_id'] = $item_id;
        $data['avg_cost'] = $avg_cost;

        loadviewJson('cost_history','_cost_history','costhistory-grid',$data);

    }

    public function actionPriceHistory($item_id)
    {
        $model = new ItemPrice('search');
        $model->unsetAttributes();  //

        $item = Item::model()->getItemInfo($item_id);

        $data['model'] = $model;
        $data['item'] = $item;
        $data['item_id'] = $item_id;

        loadviewJson('price_history','_price_history','pricehistory-grid',$data);
    }

    public function actionLowStock()
    {
        authorized('item.read');

        $model = new Item('lowstock');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        $this->render('_low_stock', array(
            'model' => $model,
        ));

    }

    public function actionOutStock()
    {
        authorized('item.index');

        $model = new Item('outstock');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        $this->render('_out_stock', array(
            'model' => $model,
        ));

    }

    protected function addImages($model)
    {
        $image_model = ItemImage::model()->find('item_id=:itemId', array(':itemId' => $model->id));

        if (!$image_model) {
            $image_model = new ItemImage;
        }

        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999

            $image_model->filetype = $file->type;
            $image_model->size = $file->size;
            //$image_model->photo = file_get_contents($file->tempName);

            $fileName = "{$rnd}_{$file}";  // random number + file name
            $model->image = $fileName;
            $path = Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $model->id;
            $name = $path . '/' . $fileName;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->saveAs($name);  // image will uplode to rootDirectory/ximages/{ModelName}/{Model->id}

            //$image = Yii::app()->image->load($name);
            //$image->resize(160, 160);
            //$image->save();

            $image_model->item_id = $model->id;
            $image_model->filename = $fileName;
            $image_model->path = '/../ximages/' . strtolower(get_class($model)) . '/' . $model->id;
            //$image_model->thumbnail = file_get_contents($name);
            $image_model->save();
        }
    }

    public function actionloadImage($id)
    {
        $model = ItemImage::model()->find('item_id=:item_id', array(':item_id' => $id));

        $this->renderPartial('image', array(
            'model' => $model
        ));
    }

    public function gridImageColumn($data, $row)
    {
        $model = ItemImage::model()->find('item_id=:item_id', array(':item_id' => $data->id));

        if ($model) {
            echo
                '<a href=' . Yii::app()->baseUrl . $model->path . '/' . $model->filename . ' data-rel="colorbox">' .
                CHtml::image(Yii::app()->baseUrl . $model->path . '/' . $model->filename, 'Product Image') .
                '</a>';
        }
    }

    public function actionNextId($id)
    {
        $item_id = Item::model()->getNextId($id);
        $this->actionUpdateImage($item_id,'0');
    }

    public function actionPreviousId($id)
    {
        $item_id = Item::model()->getPreviousId($id);
        $this->actionUpdateImage($item_id,'0');
    }

    public function setCart($cart_data,$session_name)
    {
        $this->setSession(Yii::app()->session);
        $this->session[$session_name] = $cart_data;
    }
    
    public function actionSaveCategory(){
        $i=$_POST['id']+1;
        $category_name=isset($_POST['category_name']) ? $_POST['category_name']:'';
        $parent_id=$_POST['parent_id'];
        $category=new Category;
        $model=Category::model()->findAll();
        $errorMsg='';
        if($category_name==''){
            echo 'error';
            //$errorMsg='Category name is required';
        }else{
            $category->name=$category_name;
            $category->parent_id=$parent_id;
            $saved=$category->save();
            if($saved>0){
                $this->renderPartial('partialList/_category_reload',array(
                    'category_id'=>$category->id,
                    'category_name'=>$category_name,
                    'parent_id'=>$parent_id,
                    'i'=>$i,
                    'model'=>$model
                ));
            }
        }
        
    }

    public function actionReloadCategory($id='')
    {
        $model=Category::model()->findAll();
        $this->renderPartial('partialList/_category_reload2',array('model'=>$model,'cid'=>$id));
    }

    public function actionParentReload()
    {
        $categories = Category::model()->findAll();
        $arr = Category::model()->buildTree($categories);
        $option = Category::model()->buildOptions($arr,null);

        echo '
            <option value="" selected></option>'
            .$option.'
            <optgroup >
                <option value="addnew">
                    Create New
                </option>
            </optgroup>
        ';
    }

    public function actionItemFinder()
    {
        authorized('item.read');

        $this->layout = '//layouts/columntree';

        $this->setSession(Yii::app()->session);
        $this->session['view'] = isset($this->session['view']) ? $this->session['view'] :'k';
        $model = Category::model()->findAll();

        $data['model']= $model;

        $this->render('item_finder',$data);
    }

    public function actionCategoryTree(){
        $model=Category::model()->findAll();
        $arr = Category::model()->buildTreeView($model);
        echo json_encode($arr);
    }

    public function actionGetProductByCategory($category_id,$view=''){
        $this->setSession(Yii::app()->session);
        if($view!=''){
            $this->session['view']=$view;
        }
        $model=new Item;
        if($category_id>0){
            $this->session['result']=Item::model()->itemByCategory($category_id);
            $this->session['cate_arr']=Category::model()->findAll('id = :category_id ORDER by id desc',array(':category_id'=>$category_id)
            );
        }
        
        $paretn_cate=Category::model()->getCategoryById($category_id);
        $arr = Category::model()->buildTree($this->session['cate_arr'],$paretn_cate['parent_id']);
        $data['model']=$model;
        $data['data']=$this->session['result'];
        $data['view']=$this->session['view'];
        $data['category']=Category::model()->buildCategoryBreadcrumb($arr,null,$paretn_cate['name']!=NULL ? $paretn_cate['name'].' / ' :'',$category_id);
        $this->renderPartial('partial/_result',$data);
    }

    public function actionItemSearch($result){

        $model=Item::model()->itemDetail($result);
        $item=new Item;
        $item_image = ItemImage::model()->findAllByAttributes(array('item_id'=>$result));
        $this->render('_result_detail',array(
            'model'=>$model,
            'item'=>$item,
            'item_image'=>$item_image
        ));
    }

    public function multipleImageUpload($item_id,$model,$attr_name){

        $msg=null;
        $images=CUploadedFile::getInstancesByName($attr_name);
        if(isset($images) && count($images)>0){
            
            foreach($images as $img=>$pic){
                $rnd = rand(0,9999);  // generate random number between 0-9999
                $fileName = "{$rnd}-{$pic}"; 
                $path = Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $model->id;
                $name = $path . '/' . $fileName;

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $save_pic=$pic->saveAs($name);  // image will uplode to rootDirectory/ximages/{ModelName}/{Model->id}
               //$save_pic=$pic->saveAs(Yii::app()->basePath.'/../'.$path_to_save.'/'.$fileName);
               if($save_pic){
                    ItemImage::model()->saveItemImage($item_id,$fileName);
               }else{
                    //$msg=false;                    
               }
            }    
        }
        //echo $msg;
    }

    public function actionGetBarcodeNum($item_id)
    {
        $model = Item::model()->findAll(array('condition'=>'`id`=:id','params'=>array(':id'=>$item_id)));

        if (isset($_POST['Barcode'])) {
            $num=$_POST['Barcode'];
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'success_redirect',
                'redirectUrl'=>Yii::app()->createUrl('item/PreviewBarcode',array('item_id'=>$item_id,'num'=>$num,'preview'=>'1')),
                'div' => "<div class=alert alert-info fade in> Successfully added ! </div>",
            ));

            Yii::app()->end(); 

        }

        $data['model'] = $model;

        //loadviewJson('//barcode/partial/_bar_code_number','//barcode/partial/_barcode_number','barcode-id',$data);

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );
            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('//barcode/partial/_barcode_number', $data, true, true),
            ));
            Yii::app()->end();
        }

    }

    public function actionPreviewBarcode($item_id,$num=1,$preview=1)
    {

        $this->layout = '//layouts/column_receipt';

        $model=Item::model()->findAll(array('condition'=>'`id`=:id','params'=>array(':id'=>$item_id)));

        $data['view']='_one_item_barcode';
        $data['data']=array('model' => $model,'item_id'=>$item_id,'num'=>$num);

        $this->render('//barcode/index', $data);

    }

    public function actionPrintBarcodeLabel()
    {
        $this->layout = '//layouts/column_sale';
        $this->reload();
    }

    public function actionAddItemBarcode()
    {
        $data=array();
        $item_id = $_POST['Item']['id'];
        
        if (!Yii::app()->shoppingCart->addItemBarcode($item_id)) {
            Yii::app()->user->setFlash('warning', 'Unable to add item to cart');
        }
        $this->reload($data);
    }

    public function actionEditItemBarcode($item_id){

        ajaxRequestPost();
        $data = array();

        $number_of_barcode = isset($_POST['Item']['number_of_barcode']) ? $_POST['Item']['number_of_barcode'] : null;

        Yii::app()->shoppingCart->editItemBarcode($item_id, $number_of_barcode);
            
        $this->reload($data);

    }

    public function actionDeleteItemBarcode($item_id,$number_of_barcode)
    {
        ajaxRequestPost();

        Yii::app()->shoppingCart->deleteItemBarcode($item_id);

        $this->reload();
    }

    public function actionPreviewItemBarcode()
    {

        $this->layout = '//layouts/column_receipt';

        $items=Yii::app()->shoppingCart->getItemBarcode();

        $data['view']='/partial/_preview_barcode';
        $data['data']=array('items'=>$items);

        $this->render('//barcode/index',$data);
    }

    public function actionResetItemBarcode(){

        ajaxRequestPost();

        Yii::app()->shoppingCart->emptyItemBarcode();
        $this->reload();
    }

    public function actionPdf(){
        $file=$this->renderPartial('_to_delete/_test_pdf', array('name'), true);
        $c=Yii::app()->pdfGenerator->PdfCreate($file);        
        // Yii::app()->pdfGenerator->PdfToEmail('test','sovotanakpath579@gmail.com','sovotanakpath579@gmail.com',$file,'Hello','A4');

    }

    private function reload($data=array())
    {
        $this->layout = '//layouts/column_sale';
        $model = new Item;
        $items = Yii::app()->shoppingCart->getItemBarcode();

        $data['view'] ='_select_item_barcode';
        $data['data'] = array(
            'model' => $model,
            'items'=>$items,
            'status'=>'success'
        );

        loadview('//barcode/index','//barcode/index',$data);

    }

    public function setSession($value)
    {
        $this->session = $value;
    }
}
