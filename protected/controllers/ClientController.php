<?php

class ClientController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    //test
    public function accessRules()
    {
        return array(
            array(
                'allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'create',
                    'update',
                    'admin',
                    'GetClient',
                    'AddCustomer',
                    'delete',
                    'undodelete',
                    'payment',
                    'CopyClientInfo',
                    'DynamicDistrict',
                    'DynamicCommune',
                    'ValidateCustomer',
                    'clientUpdateStatus',
                ),
                'users' => array('@'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;

            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('view', array('model' => $this->loadModel($id)), true, false),
            ));

            Yii::app()->end();
        } else {
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        }
    }


    public function actionCreate($sale_mode = 'N')
    {
        authorized('customer.create');

        $model = new Client;
        $contact = new Contact;
        $has_error = "";

        if (isset($_POST['Client'])) {

            $model->attributes = $_POST['Client'];
            $model->status = param("create_customer_submit_status");
            $model->mobile_no = str_replace(' ', '', $_POST['Client']['mobile_no']);
            $model->employee_id = Yii::app()->session['employeeid']; //Set employee who created
            $contact->attributes = $_POST['Contact'];
            $model->image = CUploadedFile::getInstance($model,'image');
            // var_dump($_FILES['Client[image]']);
            // if ($_POST['Client']['year'] !== "" || $_POST['Client']['month'] !== "" || $_POST['Client']['day'] !== "") {
            //     $dob = $_POST['Client']['year'] . '-' . $_POST['Client']['month'] . '-' . $_POST['Client']['day'];
            //     $model->dob = $dob;
            // }

            // validate BOTH $a and $b
            $valid = $model->validate();
            $valid = $contact->validate() && $valid;

            //if ($model->validate()) {
            if ($valid) {
                $transaction = Yii::app()->db->beginTransaction();
                try {

                    if (isset($_POST['Contact'])) {
                        $contact->save();
                        $model->contact_id = $contact->id;
                    }

                    if ($model->save()) {
                        $client_id = $model->id;
                        $client_fname = $model->first_name . ' ' . $model->last_name;
                        $price_tier_id = $model->price_tier_id;

                        $this->addImages($model);
                        // $this->addImages($model);

                        Account::model()->saveAccount($client_id, $client_fname);

                        $transaction->commit();

                        if ($sale_mode == 'Y') {
                            Yii::app()->shoppingCart->setCustomer($client_id);
                            Yii::app()->shoppingCart->setPriceTier($price_tier_id);
                            $this->redirect(array('/saleItem/index','tran_type'=>getTransType()));
                        } else {
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                                '<strong>' . ucfirst($model->first_name) . '</strong> have been saved successfully!');
                            $this->redirect(array('create'));
                        }

                        /* Decide to not using Modal diaglog for CRUD form
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode(array(
                           'status'=>'success',
                           'div'=>"<div class=alert alert-info fade in>Successfully added ! </div>",
                           ));

                        Yii::app()->end();
                         *
                        */
                    }
                } catch (CDbException $e) {
                    $transaction->rollback();
                    //Yii::app()->user->setFlash('error', "{$e->getMessage()}");
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING,
                        'Oop something wrong : <strong>' . $e->getMessage());
                }

            } else {
                $has_error = "has-error";
            }
        }

        $data['model'] = $model;
        $data['contact'] = $contact;
        $data['has_error'] = $has_error;

        loadview('create', '_form', $data);

    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionAddCustomer()
    {

        authorized('customer.create');

        $model = new Client;


        if (isset($_POST['Client'])) {
            $model->attributes = $_POST['Client'];
            if ($model->validate()) {
                if ($model->save()) {
                    if (!empty($_POST['Client']['debter_id'])) {
                        $debter_id = $_POST['Client']['debter_id'];

                        $mod_debter_ref = new DebterClientRef;
                        $mod_debter_ref->client_id = $model->id;
                        $mod_debter_ref->debter_id = (int)$debter_id;
                        $mod_debter_ref->save();
                    }

                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    Yii::app()->shoppingCart->setCustomer($model->id);
                    $this->redirect(array('saleItem/index'));

                }
            }
        }

        $data['model'] = $model;

        loadview('_form', '_form', $data);
    }

    public function actionUpdate($id, $sale_mode = 'N')
    {
        authorized('customer.update');

        $model = $this->loadModel($id);
        $client_image = new ClientImage;
        $contact = Contact::model()->conatctByID($model->contact_id);
        $has_error = "";

        if (!$contact) {
            $contact = New Contact;
        }

        if (isset($_POST['Client'])) {
            $model->attributes = $_POST['Client'];
            $contact->attributes = $_POST['Contact'];
            $model->image = CUploadedFile::getInstance($model,'image');
            // if ($_POST['Client']['year'] !== "" || $_POST['Client']['month'] !== "" || $_POST['Client']['day'] !== "") {
            //     $dob = $_POST['Client']['year'] . '-' . $_POST['Client']['month'] . '-' . $_POST['Client']['day'];
            //     $model->dob = $dob;
            // }

            // validate BOTH $a and $b
            // $valid = $model->validate();
            // $valid = $contact->validate() && $valid;

            //if ($model->validate())
            // if ($valid) {
                $transaction = $model->dbConnection->beginTransaction();
                try {

                    if (isset($_POST['Contact'])) {
                        $contact->save();
                        $model->contact_id = $contact->id;
                    }

                    if ($model->save(false)) {
                        $client_fname = $model->first_name . ' ' . $model->last_name;
                        Account::model()->saveAccount($model->id, $client_fname);
                        $price_tier_id = $model->price_tier_id;

                        $cur_image=ClientImage::model()->findAllByAttributes(array('client_id'=>$id));

                        foreach($cur_image as $img){

                            $img_file=Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $id.'/'.$img['filename'];
                            
                            if(file_exists($img_file)){

                                unlink($img_file);

                            }

                        }

                        ClientImage::model()->deleteAll(array('condition'=>'`client_id`=:client_id','params'=>array(':client_id'=>$id)));
                        $this->addImages($model);
                                   
                        $transaction->commit();

                        // if ($sale_mode == 'Y') {
                        //     Yii::app()->shoppingCart->setCustomer($id);
                        //     Yii::app()->shoppingCart->setPriceTier($price_tier_id);
                        //     $this->redirect(array('saleItem/index'));
                        // } else {
                        //     Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                        //         '<strong>' . ucfirst($model->first_name) . '</strong> have been saved successfully!');
                        //     $this->redirect(array('admin'));
                        // }
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    print_r($e);
                }
            // } else {
            //     $has_error = "has-error";
            // }
        }

        $data['model'] = $model;
        $data['contact'] = $contact;
        $data['client_image'] = ClientImage::model()->findAllByAttributes(array('client_id'=>$id));
        $data['has_error'] = $has_error;

        loadview('update', '_form', $data);

    }

    public function actionDelete($id)
    {
        authorized('customer.delete');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            Client::model()->deleteClient($id);
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

    }

    public function actionUndoDelete($id)
    {
        authorized('customer.delete');

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            Client::model()->undodeleteClient($id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

    }

    public function actionAdmin($client_id = null)
    {
        authorized('customer.read') || authorized('customer.create') || authorized('customer.update');

        $model = new Client('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Client'])) {
            $model->attributes = $_GET['Client'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->client_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

        $page_size = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState('employee_page_size', Common::defaultPageSize()),
            Common::arrayFactory('page_size'),
            array('class' => 'change-pagesize')
        );


        $data['model'] = $model;
        $data['grid_id'] = strtolower(get_class($model)) . '-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['page_size'] = $page_size;
        $data['create_permission'] = 'customer.create';

        $data['grid_columns'] = array(
            // array(
            //     'name' => 'last_name',
            //     'value' => '$data->status=="1" ? CHtml::link($data->last_name, Yii::app()->createUrl("client/update",array("id"=>$data->primaryKey))) : "<span class=\"text-muted\">  $data->last_name <span>" ',
            //     'type' => 'raw',
            // ),
            array(
                'name' => 'first_name',
                'value' => '$data->status=="1" ? CHtml::link($data->first_name, Yii::app()->createUrl("client/update",array("id"=>$data->primaryKey))) : "<span class=\"text-muted\">  $data->first_name <span>" ',
                'type' => 'raw',
            ),
            array(
                'name' => 'mobile_no',
                'value' => '$data->status=="1" ? $data->mobile_no : "<span class=\"text-muted\">  $data->mobile_no <span>"',
                'type' => 'raw',
            ),
            array(
                'name' => 'address1',
                'header' => 'Address',
                'value' => '$data->status=="1" ? $data->address1 : "<span class=\"text-muted\">  $data->address1 <span>"',
                'type' => 'raw',
            ),

            array(
                'header' => 'District/Khan',
                'value'=> function($data) { if(isset($data->district->district_name)) return $data->district->district_name;},
                'type' => 'raw',
            ),

            array(
                'name' => 'created_at',
                'header' => 'Created Date',
                'type' => 'raw',
            ),
            array(
                //'name' => 'employee.last_name',
                'header' => 'Responsible By',
                'value'=> function($data) { if(isset($data->employee->last_name)) return $data->employee->last_name  . " " . $data->employee->first_name ;},
                'type' => 'raw',
            ),
            array(
                'name' => 'balance',
                'header' => 'Balance',
                'value' => array($this, "gridBalance"),
                'visible' => Yii::app()->user->checkAccess("payment.index"),
                'type' => 'raw',
            ),
            array('class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '<div class="btn-group">{update}{delete}</div>',
                'buttons' => array(
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => 'Yii::app()->user->checkAccess("employee.update")',
                    ),
                    'delete' => array(
                        'label' => 'Delete',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status==param("create_customer_complete_status") && ckacc("customer.delete")',
                    ),
                ),
            ),
        );

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);
    }

    public function loadModel($id)
    {
        $model = Client::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'client-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /** Lookup Client for autocomplete
     *
     * @throws CHttpException
     */
    public function actionGetClient()
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = Client::model()->select2Client($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();

        }
    }

    public function gridBalance($data, $row)
    {
        $account = Account::model()->getAccountInfo($data->id);
        if ($account) {
            echo $account->current_balance;
        } else {
            echo CHtml::encode('0.00');
        }
    }

    public function actionPayment($client_id)
    {
        if (!Yii::app()->user->checkAccess('payment.index')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        Yii::app()->paymentCart->setClientId($client_id);
        $this->redirect(array('salePayment/index'));

    }

    public function actionCopyClientInfo()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $param = (int)$_POST['Client']['employee_id'];
            $employee = Employee::model()->findByPk($param);

            echo CJSON::encode(array(
                'status' => 'success',
                'mobile_no' => $employee->mobile_no,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'address1' => $employee->adddress1,
                'address2' => $employee->address2,
                'notes' => $employee->notes,
            ));
        }
    }

    public function actionDynamicDistrict()
    {
        $data= District::model()->findAll('city_id=:parent_id',
            array(':parent_id' => (int) $_POST['Client']['city_id']));

        $data=CHtml::listData($data,'id','district_name');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }

    public function actionDynamicCommune()
    {
        $data= Commune::model()->findAll('district_id=:parent_id',
            array(':parent_id' => (int) $_POST['Client']['district_id']));

        $data=CHtml::listData($data,'id','commune_name');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }

    public function multipleImageUpload($client_id,$model,$attr_name){

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
                // echo $save_pic;
               //$save_pic=$pic->saveAs(Yii::app()->basePath.'/../'.$path_to_save.'/'.$fileName);
               if($save_pic){
                    // echo $client_id;
                    ClientImage::model()->saveClientImage($client_id,$fileName);
               }else{
                    //$msg=false;                    
               }
            }    
        }
        //echo $msg;
    }

    protected function addImages($model)
    {
        $client_image = ClientImage::model()->find('client_id=:clientId', array(':clientId' => $model->id));

        if (!$client_image) {
            $client_image = new ClientImage;
        }

        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999

            $client_image->filetype = $file->type;
            $client_image->size = $file->size;
            //$client_image->photo = file_get_contents($file->tempName);

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

            $client_image->client_id = $model->id;
            $client_image->filename = $fileName;
            $client_image->path = '/../ximages/' . strtolower(get_class($model)) . '/' . $model->id;
            //$client_image->thumbnail = file_get_contents($name);
            $client_image->save();
        }
    }

    public function actionValidateCustomer()
    {
        //authorized('report.sale');
        $client = new Client;
        $grid_id = 'sale-order-grid';
        $title = 'List Customer need Approval';

        if(!empty($_GET)){
            $myGet=$_GET;
        }else{
            $myGet=null;
        }

        $data = commonData($grid_id,$title,'show','_header_no_btn','_grid',$client,'Client',$myGet);
        $data['status'] = '';
        $data['user_id'] = Yii::app()->user->getId(); //May be have another function to get this done!

        $data['grid_columns'] = ReportColumn::getCustomerApprovalColumns();

        $data['data_provider'] = $client->CustomerApproval();

        loadview('review','//layouts/report/_grid',$data);
    }

    public function actionClientUpdateStatus($client_id,$tran_type,$ajax=true)
    {
        if ($ajax) {
            ajaxRequest();
        }

        Client::model()->clientUpdateStatus($client_id,$tran_type);
    }
}
