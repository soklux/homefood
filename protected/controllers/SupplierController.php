<?php

class SupplierController extends Controller
{

	public $layout='//layouts/column1';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete','undoDelete','AddSupplier','GetSupplier','SaveSupplier'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionView($id)
    {
        authorized('supplier.read');

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

	public function actionAddSupplier()
	{
		authorized('supplier.create');

	    $model=new Supplier;


        if(isset($_POST['Supplier']))
        {
                $model->attributes=$_POST['Supplier'];
                if($model->validate())
                {
                    if($model->save())
                    {
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        Yii::app()->receivingCart->setSupplier($model->id);
                        $this->redirect(array('receivingItem/index'));
                    }
                }
        }

        $data['model'] = $model;

        loadview('_form','form',$data);

	}

	public function actionCreate($recv_mode='N',$trans_mode=null)
	{
	    authorized('supplier.create');

		$model=new Supplier;

        if(isset($_POST['Supplier']))
        {
                $model->attributes=$_POST['Supplier'];
                if($model->validate())
                {
                    $transaction=Yii::app()->db->beginTransaction();
                    try
                    {
                        if($model->save())
                        {
                            AccountSupplier::model()->saveAccount($model->id,$model->company_name);
                            $transaction->commit();

                            if ($recv_mode == 'N') {
                                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'Supplier : <strong>' . $model->company_name . '</strong> have been saved successfully!' );
                                $this->redirect(array('create'));
                            } else {
                                Yii::app()->receivingCart->setSupplier($model->id);
                                $this->redirect(array('receivingItem/index','trans_mode'=>$trans_mode));
                            }

                        }
                    } catch (CDbException $e) {
                       $transaction->rollback();
                       Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING,'Oop something wrong : <strong>' . $e->getMessage());
                    }

                }
        }

        $data['model'] = $model;

        loadview('create','_form',$data);

	}
    public function actionSaveSupplier(){
        $model=new Supplier;

        $this->performAjaxValidation($model);
        $name=$_POST['name'];
        $first_name=$_POST['first_name'];
        $last_name=$_POST['last_name'];
        $data=array(
            'company_name'=>$name,
            'first_name'=>$first_name,
            'last_name'=>$last_name
        );
        $id = $model->saveSupplier($data);
        
            if($first_name==''){

                echo 'null_first_name';

            }elseif($last_name==''){

                echo 'null_last_name';

            }else{
                
                if($id>0){

                echo 'success';

                $this->renderPartial('partialList/_supplier_reload',array('model'=>Supplier::model()->findAll(),'id'=>$id));
                }else{
                    echo 'existed'; 
                }
            }

        
    }
    public function actionUpdate($id, $recv_mode = 'N', $trans_mode = null)
    {
        authorized('supplier.update');

        $model = $this->loadModel($id);

        if (isset($_POST['Supplier'])) {
            $model->attributes = $_POST['Supplier'];
            if ($model->validate()) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    if ($model->save()) {
                        $transaction->commit();

                        if ($recv_mode == 'Y') {
                            Yii::app()->receivingCart->setSupplier($id);
                            $this->redirect(array('receivingItem/index', 'trans_mode' => $trans_mode));
                        } else {
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, '<strong>' . ucfirst($model->company_name) . '</strong> have been saved successfully!');
                            $this->redirect(array('admin'));
                        }


                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING, 'Oop something wrong : <strong>' . $e->getMessage());
                }
            }

        }

        $this->render('update', array('model' => $model));

    }

    public function actionDelete($id)
    {
        authorized('supplier.delete');

        if (Yii::app()->request->isPostRequest) {
            Supplier::model()->deleteSupplier($id);

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
        authorized('supplier.delete');

        if (Yii::app()->request->isPostRequest) {

            Supplier::model()->undodeleteSupplier($id);
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Supplier');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

    public function actionAdmin()
    {
        authorized('supplier.read');

        $model = new Supplier('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier'])) {
            $model->attributes = $_GET['Supplier'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->supplier_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

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

        $data['grid_columns'] = Supplier::getSupplierColumns();

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);
    }

	public function loadModel($id)
	{
		$model=Supplier::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='supplier-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionGetSupplier()
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = Supplier::select2Supplier($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();

        }
    }
}
