<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property string $id
 * @property integer $country_id
 * @property string $city_name
 * @property string $city_native_name
 * @property string $city_code
 *
 * The followings are the available model relations:
 * @property District[] $districts
 */
class CustomerGroup extends CActiveRecord
{
    public $search;
    public $customergroup_archived;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_name', 'required'),
			// array('country_id', 'numerical', 'integerOnly'=>true),
			// array('city_name, city_native_name', 'length', 'max'=>128),
			// array('city_code', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('search', 'safe', 'on'=>'search'),
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
	
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_name' => 'Group Name'
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id,true);
		//$criteria->compare('group_name',$this->group_name,true);

        if  ( Yii::app()->user->getState('customergroup_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'group_name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (group_name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('customer_group_page_size', Common::defaultPageSize()),
            ),
            'sort' => array('defaultOrder' => 'group_name')
        ));

	}
	public function getCustomerGroup()
    {
        $model = CustomerGroup::model()->findAll(array(
            'order' => 'id',
            'condition' => 'status=:active_status',
            'params' => array(':active_status' => Yii::app()->params['active_status'])
        ));
        $list = CHtml::listData($model, 'id', 'group_name');

        return $list;
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function updateStatus($id,$status)
    {
        CustomerGroup::model()->updateByPk((int)$id, array('status' => $status));

    }

    public static function getCustomerGroupColumn()
    {
        return
            array(
                array(
                    'name' => 'group_name',
                    'value' => '$data->status=="1" ? $data->group_name : "<s class=\"red\">  $data->group_name <s>" ',
                    'type' => 'raw',
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
                    'buttons' => array(
                        'update' => array(
                            'click' => 'updateDialogOpen',
                            'label' => 'Update Customer Group',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Update Customer Group'),
                                'data-refresh-grid-id' => 'customergroup-grid',
                                'class' => 'btn btn-xs btn-info',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("customer.update")',
                        ),
                        'delete' => array(
                            'label' => Yii::t('app', 'Delete Customer Group'),
                            'url' => 'Yii::app()->createUrl("customerGroup/updateStatus", array("id" => $data->id, "status" => param("inactive_status")))',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Delete Customer Group'),
                                'title' => 'Edit Item',
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("customer.delete") && $data->id !=1',
                        ),
                        'restore' => array(
                            'label' => Yii::t('app', 'Restore Customer Group'),
                            'url' => 'Yii::app()->createUrl("customerGroup/updateStatus", array("id" => $data->id, "status" => param("active_status")))',
                            'icon' => 'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class' => 'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("customer.delete")',
                        ),
                    ),
                ),
            );
    }
}
