<?php

class EmployeeController extends Controller
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
                'actions' => array('view', 'InlineUpdate'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'create', 'update', 'admin', 'delete', 'undodelete', 'UploadImage'),
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
        authorized('employee.read');

        $model = new Employee('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee'])) {
            $model->attributes = $_GET['Employee'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->employee_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

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

        $data['grid_columns'] = Employee::model()->getEmployeeColumn();

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);
    }

    public function actionView($id)
    {
        authorized('employee.read');

        $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int)$id));

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'user' => $user,
        ));
    }

    public function actionCreate()
    {
        authorized('employee.create');

        $model = new Employee;
        $user = new RbacUser;
        $disabled = "";
        $auth_items = array();

        foreach ($this->authItemPermission() as $item) {
            $user->$item = $auth_items;
        }

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];
            $user->attributes = $_POST['RbacUser'];

            if ($_POST['Employee']['year'] !== "" || $_POST['Employee']['month'] !== "" || $_POST['Employee']['day'] !== "") {
                $dob = $_POST['Employee']['year'] . '-' . $_POST['Employee']['month'] . '-' . $_POST['Employee']['day'];
                $model->dob = $dob;
            }

            // validate BOTH $a and $b
            $valid = $model->validate();
            $valid = $user->validate() && $valid;

            $this->performAjaxValidation($valid);

            if ($valid) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    if ($model->save()) {
                        $user->employee_id = $model->id;

                        if (!$user->save()) {
                            print_r($user->errors);
                            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Error during Authassignment to User table.' . $user->id);
                            $transaction->rollback();
                            exit;
                        }

                        $assign_items = $this->authItemPermission();

                        foreach ($assign_items as $assign_item) {
                            if (!empty($_POST['RbacUser'][$assign_item])) {
                                foreach ($_POST['RbacUser'][$assign_item] as $item_id) {
                                    $auth_assignment = new Authassignment;
                                    $auth_assignment->userid = $user->id;
                                    $auth_assignment->itemname = $item_id;

                                    if (!$auth_assignment->save()) {
                                        print_r($auth_assignment->errors);
                                        Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Error during Authassignment to User table.' . $user->id);
                                        $transaction->rollback();
                                        exit;
                                    }
                                }
                            }
                        }

                        $transaction->commit();
                        Yii::app()->user->setFlash('success', '<strong>Well done!</strong> successfully saved.');
                        $this->redirect(array('admin'));

                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Catch Exception error and try submitting again.' . $e);
                    exit;
                }
            }
        }

        $data['model'] = $model;
        $data['user'] = $user;
        $data['disabled'] = $disabled;
        $data['auth_items'] = $auth_items;
        $this->render('create', $data);
    }

    public function actionUpdate($id)
    {
        authorized('employee.update');

        $disabled = "";

        $model = $this->loadModel($id);

        $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int)$id));
        $criteria = new CDbCriteria;
        $criteria->condition = 'userid=:userId';
        $criteria->select = 'itemname';
        $criteria->params = array(':userId' => $user->id);
        $auth_assignment = Authassignment::model()->findAll($criteria);

        $auth_items = array();
        foreach ($auth_assignment as $auth_item) {
            $auth_items[] = $auth_item->itemname;
        }

        //$user->items = $auth_items;

        foreach ($this->authItemPermission() as $item) {
            $user->$item = $auth_items;
        }


        //$user->items = $auth_items;
        //$user->pricebooks = $auth_items;
        //$user->categories = $auth_items;
        //$user->sales = $auth_items;
        //$user->employees = $auth_items;
        //$user->customers = $auth_items;
        //$user->store = $auth_items;
        //$user->suppliers = $auth_items;
        //$user->receivings = $auth_items;
        //$user->reports = $auth_items;
        //$user->invoices = $auth_items;
        //$user->payments = $auth_items;
        //$user->rptprofits = $auth_items;

        $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];
            $user->attributes = $_POST['RbacUser'];

            if ($_POST['Employee']['year'] !== "" || $_POST['Employee']['month'] !== "" || $_POST['Employee']['day'] !== "") {
                $dob = $_POST['Employee']['year'] . '-' . $_POST['Employee']['month'] . '-' . $_POST['Employee']['day'];
                $model->dob = $dob;
            }

            $valid = $model->validate();
            $valid = $user->validate() && $valid;

            if ($valid) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    if ($model->save()) {

                        if ($user->save()) {
                            // Delete all existing granted module
                            Authassignment::model()->deleteAuthassignment($user->id);

                            $assign_items = $this->authItemPermission();
                            foreach ($assign_items as $assign_item) {
                                if (!empty($_POST['RbacUser'][$assign_item])) {
                                    foreach ($_POST['RbacUser'][$assign_item] as $itemId) {
                                        $auth_assignment = new Authassignment;
                                        $auth_assignment->userid = $user->id;
                                        $auth_assignment->itemname = $itemId;
                                        $auth_assignment->save();
                                    }
                                }
                            }

                            $transaction->commit();
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Employee : <strong>' . ucwords($model->last_name . ' ' . $model->first_name) . '</strong> have been saved successfully!');
                            $this->redirect(array('admin'));
                        } else {
                            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.' . $e);
                }
            }
        }

        if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
            $disabled = "true";
        }

        $data['model'] = $model;
        $data['user'] = $user;
        $data['disabled'] = $disabled;
        $data['auth_items'] = $auth_items;

        $this->render('update', $data);
    }

    public function actionInlineUpdate()
    {
        if (Yii::app()->user->checkAccess('employee.update')) {
            $model = $this->loadModel((int)$_POST['pk']);
            $attribute = $_POST['name'];
            $model->$attribute = $_POST['value'];
            try {
                $model->save();
            } catch (CException $e) {
                echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
                return;
            }
            echo CJSON::encode(array('success' => true));
        }
    }

    public function actionDelete($id)
    {
        authorized('employee.delete');

        if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request

            $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int)$id));

            if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
                throw new CHttpException(400, 'Cannot delete owner user system. Please do not repeat this request again.');
            } else {
                Employee::model()->deleteEmployee($id);
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

    }

    public function actionundoDelete($id)
    {
        authorized('employee.delete');

        if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request

            $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int)$id));

            if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
                throw new CHttpException(400, 'Cannot delete owner user system. Please do not repeat this request again.');
            } else {
                Employee::model()->undodeleteEmployee($id);
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionIndex()
    {
        authorized('employee.read');

        $dataProvider = new CActiveDataProvider('Employee');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));

    }

    public function loadModel($id)
    {
        $model = Employee::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUploadImage($employee_id)
    {

        $model = new Employee;
        $image_model = EmployeeImage::model()->find('employee_id=:employee_id', array(':employee_id' => (int)$employee_id));

        if (!$image_model) {
            $image_model = new EmployeeImage;
        }

        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999

            $image_model->filetype = $file->type;
            $image_model->size = $file->size;
            $image_model->photo = file_get_contents($file->tempName);

            $fileName = "{$rnd}_{$file}";  // random number + file name
            $model->image = $fileName;
            $path = Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $employee_id;
            $name = $path . '/' . $fileName;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->saveAs($name);  // image will uplode to rootDirectory/ximages/{ModelName}/{Model->id}

            $image = Yii::app()->image->load($name);
            $image->resize(160, 160);
            $image->save();

            /*
            $image_model->item_id = $employee_id;
            $image_model->filename = $fileName;
            $image_model->path = '/../ximages/' . strtolower(get_class($model)) . '/' . $employee_id;
            $image_model->thumbnail = file_get_contents($name);
            if (!$image_model->save()) {
                $transaction->rollback();
                print_r($image_model->errors);
            }
             *
            */
        }
    }

    protected function authItemPermission()
    {
        return array('items','pricebooks','categories' ,'saleorders', 'customerpayments', 'customers', 'employees', 'suppliers',
            'stockcounts', 'stocktransfers', 'purchaseorders', 'purchasereceives', 'purchasereturns','reports','settings','shipmentorders','invoices','customergroups');
    }



}
