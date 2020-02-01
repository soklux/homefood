<?php

class ReceivingPaymentController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('Payment', 'admin','PaymentDetail','savepayment','selectSupplier','removeSupplier','successPayment'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        if (Yii::app()->user->checkAccess('payment.index')) {
            $this->reload();
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
            //$this->redirect(array('site/ErrorException','err_no'=>403));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SalePayment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalePayment'])) {
            $model->attributes = $_GET['SalePayment'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SalePayment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SalePayment::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SalePayment $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sale-payment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSavePayment()
    {
        $data = $this->sessionInfo();

        if (Yii::app()->user->checkAccess('payment.index')) {
            if (isset($_POST['ReceivingPayment'])) {
                $data['model']->attributes = $_POST['ReceivingPayment'];
                if ($data['model']->validate()) {
                    $paid_amount = $_POST['ReceivingPayment']['payment_amount'];
                    $paid_date = Date('Y-m-d H:i:s');
                    $note = $_POST['ReceivingPayment']['note'];

                    if ($paid_amount <= $data['balance']) {
                        $data['payment_id'] = ReceivingPayment::model()->batchPayment($data['supplier_id'], $data['employee_id'], $data['account'], $paid_amount, $paid_date, $note);
                        if (substr($data['payment_id'], 0, 2) == '-1') {
                            $data['warning'] = $data['payment_id'];
                        } else {
                            $data = $this->sessionInfo();
                            $data['warning'] = $data['fullname'] . ' Successfully paid ';
                            $this->renderPartial('_payment_success', $data);
                            exit;
                        }
                    } else {
                        $data['model']->addError('payment_amount', Yii::t('app', 'Total amount to paid is only') . ' <strong>' . number_format($data['balance'], Common::getDecimalPlace()) . '</strong>');
                    }
                }
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
            Yii::app()->clientScript->scriptMap['box.css'] = false;
            $this->renderPartial('_payment', $data, false, true);
        } else {
            $this->render('_payment', $data);
        }
    }
        
    public function actionSelectSupplier()
    {
        if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->rpaymentCart->setSupplierId($_POST['ReceivingPayment']['supplier_id']);
            $this->reload();
        } else {
           throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
    
    public function actionRemoveSupplier()
    {
        if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->rpaymentCart->removeSupplier();
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
    
    
    private function reload($data=array())
    {
        
        $data = $this->sessionInfo();
 
        if (Yii::app()->request->isAjaxRequest) {
            
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
                'bootstrap.min.js' => false, 
                'jquery-ui.min.js' => false,
                'jquery.yiigridview.js' => false, 
                'jquery.ba-bbq.min.js' => false,
                'jquery.stickytableheaders.min.js'=>false,
                //'jquery.autocomplete.js' => false,
            );
            
            //Yii::app()->clientScript->scriptMap['*.js'] = false; 
            Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false; 
            Yii::app()->clientScript->scriptMap['box.css'] = false; 
            $this->renderPartial('_payment', $data, false, true);
        } else {
            $this->render('_payment', $data);
        }
        
    }
    
    protected function sessionInfo($data=array()) 
    {
        $model = new ReceivingPayment();
        $data['model'] = $model;
        $data['supplier_id'] = Yii::app()->rpaymentCart->getSupplierId();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        
        if ($data['supplier_id']!==null) {
            $account = AccountSupplier::model()->getAccountInfo($data['supplier_id']);
            $data['account'] = $account;
            $data['balance'] = $account->current_balance;
            $supplier = Supplier::model()->findbyPk($data['supplier_id']);
            $data['fullname'] = $supplier->company_name . ' [ ' .$supplier->first_name . ' ' . $supplier->last_name . ' ] ';
            $data['save_button'] = false;
        } else {
            $data['fullname'] = '';
            $data['balance'] = 0;
            $data['save_button'] = true;
        }
        
        return $data;
    }

    public function actionPaymentDetail($id)
    {
        $model = new SalePayment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalePayment'])) {
            $model->attributes = $_GET['SalePayment'];
        }

        $this->renderPartial('sale_payment', array(
            'model' => $model,'id'=>$id,
        ));
    }    
    
}
