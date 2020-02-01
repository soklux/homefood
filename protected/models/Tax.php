<?php

/**
 * This is the model class for table "tax".
 *
 * The followings are the available columns in table 'tax':
 * @property integer $id
 * @property string $tax_name
 * @property integer $rate
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * The followings are the available model relations:
 * @property Outlet[] $outlets
 */
class Tax extends CActiveRecord
{
    public $tax_archived;
    public $search;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tax';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rate, created_by, updated_by, deleted_by', 'numerical', 'integerOnly'=>true),
			array('tax_name', 'length', 'max'=>128),
			array('status', 'length', 'max'=>1),
			array('created_at, updated_at, deleted_at', 'safe'),
            array('created_at,', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tax_name, rate, status, created_at, updated_at, deleted_at, created_by, updated_by, deleted_by, search', 'safe', 'on'=>'search'),
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
			'outlets' => array(self::HAS_MANY, 'Outlet', 'tax_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tax_name' => 'Taxt Name',
			'rate' => 'Rate',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'deleted_at' => 'Deleted At',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
			'deleted_by' => 'Deleted By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        $criteria=new CDbCriteria;

        if  ( Yii::app()->user->getState('tax_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'tax_name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (tax_name like :search)';
            $criteria->params = array(
                ':active_status' => param('active_status'),
                ':search' => '%' . $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('tax_page_size', Common::defaultPageSize()),
            ),
            'sort' => array('defaultOrder' => 'tax_name')
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tax the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function updateStatus($id,$status)
    {
        Tax::model()->updateByPk((int)$id, array('status' => $status));

    }

    public static function getTaxColumns() {
        return array(
            array(
                'name' => 'tax_name',
                'value' => '$data->status=="1" ? CHtml::link($data->tax_name, Yii::app()->createUrl("tax/update",array("id"=>$data->primaryKey))) : "<s class=\"red\">  $data->tax_name <span>" ',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'rate',
                'filter' => '',
            ),
            array(
                'name' => 'created_at',
                'filter' => '',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '<div class="btn-group">{view}{update}{inactive}{active}</div>',
                'htmlOptions' => array('class' => 'nowrap'),
                'buttons' => array(
                    'view' => array(
                        'options' => array(
                            'class' => 'btn btn-xs btn-success',
                        ),
                    ),
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("employee.update")',
                    ),
                    'inactive' => array(
                        'label' => Yii::t('Inactivate','app'),
                        'icon' => 'bigger-120 ace-icon fa fa-trash',
                        'url' => 'Yii::app()->createUrl("tax/updateStatus", array("id" => $data->id, "status" => param("inactive_status")))',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger btn-inactive',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("employee.delete")',
                    ),
                    'active' => array(
                        'label' => Yii::t('app', 'Activate'),
                        'url' => 'Yii::app()->createUrl("tax/updateStatus", array("id" => $data->id, "status" => param("active_status")))',
                        'icon' => 'bigger-120 fa fa-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("employee.delete")',
                    ),
                ),
            ),
        );
    }
}
