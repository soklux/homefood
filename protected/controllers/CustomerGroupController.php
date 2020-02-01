<?php

class CustomerGroupController extends Controller
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
		authorized('customer.create');

	    $model=new CustomerGroup;

        // $this->performAjaxValidation($model);

        if (isset($_POST['CustomerGroup'])) {
            $model->attributes = $_POST['CustomerGroup'];

            if ($model->validate()) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    $model->modified_date=date('Y-m-d H:i:s');
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => "<div class=alert alert-info fade in> Successfully added ! </div>",
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
            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_form', array('model' => $model), true, true),
            ));
            Yii::app()->end();
        }

	}

	public function actionUpdate($id)
	{
	    authorized('customer.update');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if (isset($_POST['CustomerGroup'])) {
            $model->attributes = $_POST['CustomerGroup'];
            if ($model->validate()) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
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
            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_form', array('model' => $model), true, true),
            ));
            Yii::app()->end();
        } else {
            $this->render('update', array('model' => $model));
        }
	}

    public function actionUpdateStatus($id,$status)
    {
        ajaxRequestPost();

        $model = CustomerGroup::model()->findByPk((int)$id);

        if ( $model->id == 1 ) {
            throw new CHttpException(400, 'Cannot delete default outlet system. Please do not repeat this request again.');
        } else {
            $model->updateStatus($id,$status);
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

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
		$dataProvider=new CActiveDataProvider('CustomerGroup');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
        $model = new CustomerGroup('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerGroup'])) {
            $model->attributes = $_GET['CustomerGroup'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->customergroup_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

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
        $data['modal_header'] = Yii::t('app','New Customer Group');

        $data['grid_columns'] = CustomerGroup::getCustomerGroupColumn();

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);
	}

	public function loadModel($id)
	{
		$model=CustomerGroup::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CustomerGroup $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='customer-group-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}