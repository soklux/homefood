<?php

class UnitMeasurableController extends Controller
{
	public $layout='//layouts/column2';

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
				'actions'=>array('create','update','GetUnitMeasurable2','initUnitMeasurable','SaveMeasurable'),
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
		$model=new UnitMeasurable;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['UnitMeasurable'])) {
			$model->attributes=$_POST['UnitMeasurable'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['UnitMeasurable'])) {
			$model->attributes=$_POST['UnitMeasurable'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
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

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('UnitMeasurable');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new UnitMeasurable('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['UnitMeasurable'])) {
			$model->attributes=$_GET['UnitMeasurable'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=UnitMeasurable::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='unit-measurable-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionGetUnitMeasurable2()
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = UnitMeasurable::getUnitMeasurable2($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();

        }
    }

    public function actionInitUnitMeasurable()
    {
        $model = UnitMeasurable::model()->find('id=:id', array(':id' => (int)$_GET['id']));
        if ($model !== null) {
            echo CJSON::encode(array('id' => $model->id, 'text' => $model->name));
        }
    }

    public function actionSaveMeasurable(){
    	$model=new UnitMeasurable;
    	$measurable_name=$_POST['name'];
    	$id = $model->saveUnitMeasurable2($measurable_name);
    	if($id){
    		echo 'success';
    		//print_r($model);
    		$this->renderPartial('partialList/_measurable_reload',array('model'=>UnitMeasurable::model()->findAll(),'id'=>$id));
    	}else{
    		echo 'existed'; 
    	}
    }
}