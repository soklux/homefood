<?php

class CategoryController extends Controller
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
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'GetCategory2', 'InitCategory', 'restore', 'List', 'Create2', 'SaveCategory', 'ReloadCategory', 'Update2'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        authorized('category.create');

        $model = new Category;
        $data['model'] = $model;
        $data['parent'] = Category::model()->findAll();
        $data['cateId'] = '';

        $this->render('create', $data);
    }

    public function actionSaveCategory(){

        $i=$_POST['id']+1;
        $category_name=isset($_POST['category_name']) ? $_POST['category_name']:'';
        $parent_id=$_POST['parent_id'];
        $category=new Category;
        // $criteria = new CDbCriteria();
        // $criteria->condition = 'name=:name';
        // $criteria->params = array(':name'=>$category_name);
        // $exists = $category->exists($criteria);
        $model=Category::model()->findAll();

        // if($exists){
        //     echo 'existed'; 
        //     //$errorMsg='Name "'.$category_name.'" has already been taken.';
        // }
        if($category_name==''){
            echo 'error';
            //$errorMsg='Category name is required';
        }else{
            $category->name=$category_name;
            $category->parent_id=$parent_id;
            $saved=$category->save();
            if($saved>0){
                $this->renderPartial('partial/_category_reload',array(
                    'category_id'=>$category->id,
                    'category_name'=>$category_name,
                    'parent_id'=>$parent_id,
                    'i'=>$i,
                    'model'=>$model
                ));
            }
        }
        
    }

    public function actionReloadCategory($id=''){
        $model=Category::model()->findAll();
        echo $id;
        $this->renderPartial('partial/_category_reload2',array('model'=>$model,'cid'=>$id));
    }

    public function actionUpdate($id)
    {
        authorized('category.update');

        $model = $this->loadModel($id);

        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            if ($model->validate()) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    $model->modified_date = date('Y-m-d H:i:s');
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
            $data['model'] = $model;
            $this->render('update', $data);
        }

    }

    public function actionUpdate2($id){
        authorized('category.update');

        //echo $_POST['category_name'];
        if(isset($_POST['category_name'])){
            $category = Category::model()->findByPk($id);
            $category->name=$_POST['category_name'];
            $category->modified_date = date('Y-m-d H:i:s');
            $category->parent_id=$_POST['parent_id'];
            $updated=$category->update(array('name','modified_date','parent_id'));
            if($updated){
                echo 'success';
            }
        }else{
            $model = $this->loadModel($id);
            $data['model']=$model;
            $data['parent']=Category::model()->findAll(array(
                'condition'=>'id <> :id',
                'params'=>array(':id'=>$id)
            ));
            $data['cateId']=$id;
            $this->render('create', $data);
        }
        
    }

    public function actionDelete($id)
    {
        authorized('category.delete');

        if (Yii::app()->request->isPostRequest) {
            Category::model()->deleteCategory($id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionRestore($id)
    {
        authorized('category.delete');

        if (Yii::app()->request->isPostRequest) {
            Category::model()->restoreCategory($id);

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
        $dataProvider = new CActiveDataProvider('Category');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {


        $model = new Category('search2');
        $search='';
        if(isset($_GET['Category'])){
            $search = $_GET['Category']['search'];
        }
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Category']))
            $model->attributes = $_GET['Category'];

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('category_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState('category_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->category_archived = Yii::app()->user->getState('category_archived',
            Yii::app()->params['defaultArchived']);

        $page_size = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState('category_page_size', Common::defaultPageSize()),
            Common::arrayFactory('page_size'),
            array('class' => 'change-pagesize',)
        );

        $data['model'] = $model;
        //$data['grid_id'] = strtolower(get_class($model)) . ' -grid';
        $data['grid_id'] = strtolower(get_class($model)) . '-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['page_size'] = $page_size;
        $data['modal_header'] = Yii::t('app', 'New Category');

        $data['grid_columns'] = Category::getCategoryColumn();

        $data['data_provider'] = $model->search2($search);

        $this->render('admin', $data);
        
    }

    public function loadModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /** Lookup Client for select2
     *
     * @throws CHttpException
     */
    public function actionGetCategory2()
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = Category::getCategory2($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();

        }
    }

    public function actionInitCategory()
    {
        $model = Category::model()->find('id=:category_id', array(':category_id' => (int)$_GET['id']));
        if ($model !== null) {
            echo CJSON::encode(array('id' => $model->id, 'text' => $model->name));
        }
    }
}



/*
    |--------------------------------------------------------------------------
    | Why create another class here?
    |--------------------------------------------------------------------------
    |
    | Better to create class in its own class file
    |
 */

/*
class SDataProvider extends CDataProvider {
 public function __construct($id,$data) {
  $this->setData($data);
  $this->setId($id);
 }
 //put your code here
  protected function calculateTotalItemCount() {
    return count($this->getData());
  }
  protected function fetchData() {
    return $this->getData();
  }
  protected function fetchKeys() {
    foreach ($this->getData() as $key=>$value) {
      $keys[]= $key;
    }
    return $keys;
  }
}
*/