<?php

class OutletController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update','admin','updateStatus'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
	    authorized('setting.outlet');

		$model=new Outlet;

		$this->performAjaxValidation($model);

		if (isset($_POST['Outlet'])) {
			$model->attributes=$_POST['Outlet'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

        $data['model'] = $model;
        $data['tax'] = Tax::model()->findAll();

		$this->render('create',$data);
	}

	public function actionUpdate($id)
	{
        authorized('setting.outlet');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if (isset($_POST['Outlet'])) {
			$model->attributes=$_POST['Outlet'];
			if ($model->save()) {
				$this->redirect(array('admin'));
			}
		}

        $data['model'] = $model;
        $data['tax'] = Tax::model()->findAll();
		$this->render('update', $data);
	}

	public function actionDelete($id)
	{
        authorized('setting.outlet');

		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

    public function actionUpdateStatus($id,$status)
    {
        authorized('setting.outlet');

        ajaxRequestPost();

        $outlet = Outlet::model()->findByPk((int)$id);

        if ($outlet->id == 1) {
            throw new CHttpException(400, 'Cannot delete default outlet system. Please do not repeat this request again.');
        } else {
            Outlet::model()->updateStatus($id, $status);
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

    }

	public function actionIndex()
	{
        authorized('setting.outlet');

	    $dataProvider=new CActiveDataProvider('Outlet');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
        authorized('setting.outlet');

        $model = new Outlet('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Outlet'])) {
            $model->attributes = $_GET['Outlet'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->outlet_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

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
        $data['create_url'] = 'create';

        $data['create_permission']='setting.outlet';

        $data['grid_columns'] = Outlet::getOutletColumns();

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);
	}

	public function loadModel($id)
	{
		$model=Outlet::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='outlet-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}