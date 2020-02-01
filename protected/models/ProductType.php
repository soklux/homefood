<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class ProductType extends CActiveRecord
{
    public $search;
    public $type_archived;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'types';
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
            'items' => array(self::HAS_MANY, 'Item', 'type_id'),
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

        if  ( Yii::app()->user->getState('product_type_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
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
                'pageSize' => Yii::app()->user->getState('type_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'name')
        ));

    }

    
    protected function getProductTypeInfo()
    {
        return $this->name;

    }

    public function getProductType()
    {
        $model = ProductType::model()->findAll();
        $list = CHtml::listData($model, 'id', 'ProductTypeInfo');
        return $list;
    }

    public function saveProductType($product_type)
    {
        $product_type_id = null;
        $exists = ProductType::model()->exists('name=:name', array(':name' => $product_type));
        if (!$exists) {
            $model = new ProductType;
            $model->name = $product_type;
            $model->save();
            $product_type_id = $model->id;
        }

        return $product_type_id;
    }

    public function deleteProductType($id)
    {
        ProductType::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    }

    public function restoreProductType($id)
    {
        ProductType::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    }

    public static function getProductTypeColumn()
    {
        return
            array(
                array(
                    'name' => 'name',
                    'value' => '$data["status"]=="1" ? $data["name"] : $data["name"] ',
                    // 'value' => '$data["name"] .  ProductType::model()->showSubCategories($data["id"]," / ")',
                    //'value' => 'ProductType::model()->buildTree(ProductType::model()->findAll(), $data->parent_id)',
                    'product_type' => 'raw',
                ),
                'modified_date',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
                    'buttons' => array(
                        'update' => array(
                            'click' => '',
                            'url' => 'Yii::app()->createUrl("product_type/update2", array("id"=>$data["id"]))',
                            'label' => 'Update Product Type',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
                                'data-refresh-grid-id' => 'product_type-grid',
                                'class' => 'btn btn-xs btn-info',
                            ),
                            'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("product_type.update")',
                        ),
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("product_type/delete/",array("id"=>$data["id"]))', 
                            'label' => Yii::t('app', 'Delete Product Type'),
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Delete Product Type'),
                                'titile' => 'Delete ProductType',
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("product_type.delete")',
                        ),
                        'restore' => array(
                            'label' => Yii::t('app', 'Restore Product Type'),
                            'url' => 'Yii::app()->createUrl("product_type/restore", array("id"=>$data["id"]))',
                            'icon' => 'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class' => 'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible' => '$data["status"]=="0" && Yii::app()->user->checkAccess("product_type.delete")',
                        ),
                    ),
                ),
            );
    }
}