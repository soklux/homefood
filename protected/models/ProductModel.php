<?php

/**
 * This is the model class for table "product_model".
 *
 * The followings are the available columns in table 'product_model':
 * @property integer $id
 * @property string $name
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class ProductModel extends CActiveRecord
{
    public $search;
    public $product_model_archived;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'models';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('name', 'length', 'max' => 50),
            array('created_date, modified_date', 'safe'),
            array('created_date', 'default', 'value' => date('Y-m-d'), 'setOnEmpty' => true, 'on' => 'insert'),
            array(
                'created_date,modified_date',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => 'update'
            ),
            array('status', 'length', 'max'=>1),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name, search', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'items' => array(self::HAS_MANY, 'Item', 'product_model_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('app','Name'), //'Name',
            'parent_id' => Yii::t('app','Parent'), //'Name',
            'created_date' => Yii::t('app','Created Date'), //'Created Date',
            'modified_date' => Yii::t('app','Modified Date'), //'Modified Date',
        );
    }

    public function search()
    {

        $criteria=new CDbCriteria;
        $criteria->compare('name',$this->name,true);

        if  ( Yii::app()->user->getState('product_model_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('product_model_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'name')
        ));

    }

    
    protected function getProductModelInfo()
    {
        return $this->name;

    }

    public function getProductModel()
    {
        $model = ProductModel::model()->findAll();
        $list = CHtml::listData($model, 'id', 'ProductModelInfo');
        return $list;
    }

    public function saveProductModel($product_model)
    {
        $model_id = null;
        $exists = ProductModel::model()->exists('name=:name', array(':name' => $product_model));
        if (!$exists) {
            $model = new ProductModel;
            $model->name = $product_model;
            $model->save();
            $model_id = $model->id;
        }

        return $model_id;
    }

    public function deleteProductModel($id)
    {
        ProductModel::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    }

    public function restoreProductModel($id)
    {
        ProductModel::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    }

    public static function getProductModelColumn()
    {
        return
            array(
                array(
                    'name' => 'name',
                    'value' => '$data["status"]=="1" ? $data["name"] : $data["name"] ',
                    // 'value' => '$data["name"] .  ProductModel::model()->showSubCategories($data["id"]," / ")',
                    //'value' => 'ProductModel::model()->buildTree(ProductModel::model()->findAll(), $data->parent_id)',
                    'model' => 'raw',
                ),
                'modified_date',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
                    'buttons' => array(
                        'update' => array(
                            'click' => '',
                            'url' => 'Yii::app()->createUrl("model/update2", array("id"=>$data["id"]))',
                            'label' => 'Update Product Model',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
                                'data-refresh-grid-id' => 'model-grid',
                                'class' => 'btn btn-xs btn-info',
                            ),
                            'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("model.update")',
                        ),
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("model/delete/",array("id"=>$data["id"]))', 
                            'label' => Yii::t('app', 'Delete Product Model'),
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Delete Product Model'),
                                'titile' => 'Delete Product Model',
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("model.delete")',
                        ),
                        'restore' => array(
                            'label' => Yii::t('app', 'Restore ProductModel'),
                            'url' => 'Yii::app()->createUrl("model/restore", array("id"=>$data["id"]))',
                            'icon' => 'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class' => 'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible' => '$data["status"]=="0" && Yii::app()->user->checkAccess("model.delete")',
                        ),
                    ),
                ),
            );
    }
}