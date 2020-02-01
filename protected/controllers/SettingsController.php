<?php

class SettingsController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /*
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index'),
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
    */

    public function actionIndex()
    {

        authorized('setting.setting');
        /*
        if (!Yii::app()->user->checkAccess('store.update')) {
            $this->redirect(array('site/ErrorException','err_no'=>403));
        }
        */

        $settings = Yii::app()->settings;

        $model = new SettingsForm();

        if (isset($_POST['SettingsForm'])) {
            $model->setAttributes($_POST['SettingsForm']);
            $settings->deleteCache();
            foreach ($model->attributes as $category => $values) {
                $settings->set($category, $values);
            }
            Yii::app()->user->setFlash('success', '<strong>Well done!</strong> Site settings were updated..');
            $this->refresh();
        }

        foreach ($model->attributes as $category => $values) {
            $cat = $model->$category;
            foreach ($values as $key => $val) {
                $cat[$key] = $settings->get($category, $key);
            }
            $model->$category = $cat;
        }

        $this->render('index', array('model' => $model));
    }

}

?>