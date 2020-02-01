<?php

class RbacUserController extends Controller
{
	public $layout='//layouts/column2';


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
				'actions'=>array('create','update','admin','delete','permission'),
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
		$model=new RbacUser;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RbacUser']))
		{
			$model->attributes=$_POST['RbacUser'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['RbacUser']))
		{
			$model->attributes=$_POST['RbacUser'];
                        $ph=new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);
                        $old_password=$_POST['RbacUser']['PasswordOld'];
                        if (!$ph->CheckPassword($old_password,$model->user_password))
                        {
                            $model->addError('PasswordOld', 'Your old password does not match.');
                        }
                        else
                        {
                            if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
                            }
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RbacUser');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RbacUser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RbacUser']))
			$model->attributes=$_GET['RbacUser'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=RbacUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rbac-user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionPermission()
    {
        $role_name = $_POST['RbacUser']['role_name'];

        $data = RbacUser::model()->permissionData($role_name);

        $this->renderPartial('_permission_table',$data,false,true);

    }

    public function actionPermissionSub()
    {
        $role_name = $_POST['RbacUser']['role_name'];

        $data['grid_columns'] = array(
            array('name' => 'name',
                'header' => Yii::t('app', 'Name'),
                'value' => '$data["name"]',
                //'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                //'url' => Yii::app()->createUrl('Auth/saleInvoiceDetail'),
            ),
            array('name' => 'description',
                'header' => Yii::t('app', 'Description'),
                'value' => '$data["description"]',
            ),
        );

        $data['data_provider'] = Authassignment::model()->rolePermission($role_name);
        $data['grid_id'] = 'permission_id';

        $this->renderPartial('_permission_table',$data,false,true);

    }


}
