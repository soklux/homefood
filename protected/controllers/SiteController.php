<?php

class SiteController extends Controller
{
    //public $layout='//layouts/column3';

    /**
     * @return array action filters
     */

    /*
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    */


    /*
    public function accessRules()
    {
        return array(
            array(
                'deny',
                'expression' => function(){
                return strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE;
                },
                'message' => "You're using the wrong browser, sorry.",
            ),
        );
    }
     *
    */

    public function accessRules()
    {
        return array(
            array(
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login','index','logout','ErrorException'),
                'users' => array('*'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'about',
                    'logout',
                    'home'
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


    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->actionLogin();
    }

    public function actionAbout()
    {
        $this->render('about');
    }

    public function actionHome()
    {
        $this->layout = '//layouts/column_sale';
        $this->render('home');
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }


    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }


    public function actionLogin()
    {

        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        // display the login form
        if (Yii::app()->user->isGuest) {
            $this->layout = '//layouts/column3';
            $this->render('login_ace', array('model' => $model));
        } else {
            $this->redirect(array('site/home'));
            /*
            if (Yii::app()->user->checkAccess('report.accounting')) {
                $this->redirect(array('dashboard/view'));
            } else {
                $this->redirect(array('site/home'));
            }
            */

        }
    }

    public function actionLogout()
    {
        UserLog::model()->saveUserLogOut(Yii::app()->session['unique_id'], Date('Y-m-d H:i:s'));
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }


    /**
     * This is the action to handle external exceptions.
     */
    public function actionErrorException($err_no)
    {
        $data = $this->errorInfo($err_no);

        $this->render('error_500', $data);
    }

    protected function errorInfo($err_no)
    {
        $data = array();

        if ($err_no == 403) {
            $data['err_no'] = $err_no;
            $data['header'] = Yii::t('app', 'No Permission');
            $data['subject'] = Yii::t('app', 'You are not authorized to perform this action');
            $data['bodies'] = array('Read the faq', 'Contact your system administrator');
        } elseif ($err_no == 400) {
            $data['err_no'] = $err_no;
            $data['header'] = Yii::t('app', 'Invalid request');
            $data['subject'] = Yii::t('app', 'Please do not repeat this request again');
            $data['bodies'] = array('Make sure the page load completely - Ajax Loading Request');
        }

        return $data;
    }
}