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
class Brand extends CActiveRecord
{
    public $search;
    public $brand_archived;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Brand the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'brand';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
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

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('app','Name'), //'Name',
			'created_date' => Yii::t('app','Created Date'), //'Created Date',
			'modified_date' => Yii::t('app','Modified Date'), //'Modified Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

        if  ( Yii::app()->user->getState('brand_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
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
                'pageSize' => Yii::app()->user->getState('brand_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'name')
        ));

	}

    protected function getBrandInfo()
    {
        return $this->name;

    }

    public function getBrand()
    {
        $model = Brand::model()->findAll();
        $list = CHtml::listData($model, 'id', 'BrandInfo');
        return $list;
    }


    public function saveBrand($brand_name)
    {
        $brand_id = null;
        $exists = Brand::model()->exists('name=:name', array(':name' => $brand_name));
        if (!$exists) {
            $brand = new Brand;
            $brand->name = $brand_name;
            $brand->save();
            $brand_id = $brand->id;
        }

        return $brand_id;
    }

    public function deleteBrand($id)
    {
        Brand::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    }

    public function restoreBrand($id)
    {
        Brand::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    }

    // public static function getBrandColumn()
    // {
    //     return
    //         array(
    //             array(
    //                 'name' => 'name',
    //                 'value' => '$data->status=="1" ? $data->name : "<s class=\"red\">  $data->name <s>" ',
    //                 'type' => 'raw',
    //             ),
    //             'modified_date',
    //             array(
    //                 'class' => 'bootstrap.widgets.TbButtonColumn',
    //                 'header' => Yii::t('app', 'Action'),
    //                 'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
    //                 'buttons' => array(
    //                     'update' => array(
    //                         //updateDialogOpen
    //                         'click' => '',
    //                         'url' => 'Yii::app()->createUrl("brand/update2", array("id"=>$data->id))',
    //                         'label' => 'Update Brand',
    //                         'icon' => 'ace-icon fa fa-edit',
    //                         'options' => array(
    //                             'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
    //                             'data-refresh-grid-id' => 'brand-grid',
    //                             'class' => 'btn btn-xs btn-info',
    //                         ),
    //                         'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("brand.update2")',
    //                     ),
    //                     'delete' => array(
    //                         'label' => Yii::t('app', 'Delete Brand'),
    //                         'options' => array(
    //                             'data-update-dialog-title' => Yii::t('app', 'Delete Brand'),
    //                             'titile' => 'Delete Brand',
    //                             'class' => 'btn btn-xs btn-danger',
    //                         ),
    //                         'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("brand.delete")',
    //                     ),
    //                     'restore' => array(
    //                         'label' => Yii::t('app', 'Restore Brand'),
    //                         'url' => 'Yii::app()->createUrl("brand/restore", array("id"=>$data->id))',
    //                         'icon' => 'bigger-120 glyphicon-refresh',
    //                         'options' => array(
    //                             'class' => 'btn btn-xs btn-warning btn-undodelete',
    //                         ),
    //                         'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("brand.delete")',
    //                     ),
    //                 ),
    //             ),
    //         );
    // }
}