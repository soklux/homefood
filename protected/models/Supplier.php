<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $id
 * @property string $company_name
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property string $address1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $notes
 * @property string $status
 * @property date $created_at
 * @property date $updated_at
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class Supplier extends CActiveRecord
{
    public $search;
    public $supplier_archived;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Supplier the static model class
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
		return 'supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, first_name, last_name', 'required'),
			array('city_id', 'numerical', 'integerOnly'=>true),
			array('company_name', 'length', 'max'=>60),
			array('first_name, last_name, email', 'length', 'max'=>30),
			array('mobile_no', 'length', 'max'=>20),
			array('address1, address2', 'length', 'max'=>50),
			array('country_code', 'length', 'max'=>3),
			array('notes', 'safe'),
            array('created_at,updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
            array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_name, first_name, last_name, mobile_no, address1, address2, city_id, country_code, email, notes, status, search', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'Item', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_name' => Yii::t('app', 'Company Name'),
			'first_name' => Yii::t('app', 'Given Name'), //'First Name',
			'last_name' => Yii::t('app', 'Family Name'), //'Last Name',
			'mobile_no' => Yii::t('app', 'Mobile No'), //'Mobile No',
			'address1' => Yii::t('app', 'Address1'), //'Address1',
			'address2' => Yii::t('app', 'Address2'), //'Address2',
			'city_id' => Yii::t('app', 'City'), //'City',
			'country_code' => Yii::t('app', 'Country Code'), //'Country Code',
			'email' => Yii::t('app', 'Email'), //'Email',
			'notes' => Yii::t('app', 'Notes'), //'Notes',
			'status' => Yii::t('app', 'Status'),
			'search' => Yii::t('app', 'Search') . Yii::t('app', 'Supplier')
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

        if  ( Yii::app()->user->getState('supplier_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'company_name like :search or first_name like :search or last_name like :search or concat(first_name,last_name) like :search or concat(last_name,first_name) like :search  or mobile_no like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (company_name like :search or first_name=:search or last_name=:search or concat(first_name,last_name)=:search or concat(last_name,first_name)=:search  or mobile_no like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('supplier_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'company_name')
		));
	}

    protected function getSupplierInfo()
    {
        return $this->company_name . ' - ' . $this->first_name . ' ' . $this->last_name;
    }

    public function getSupplier()
    {
        $supplier = Supplier::model()->findAll('status=:status',
            array(':status' => Yii::app()->params['active_status']));
        $list = CHtml::listData($supplier, 'id', 'SupplierInfo');

        return $list;
    }

    public static function select2Supplier($name = '')
    {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = 'SELECT id ,concat_ws(" : ",company_name,mobile_no) AS text
                    FROM supplier 
                    WHERE (company_name LIKE :name or mobile_no like :name)
                    AND status=:status';
        $name = '%' . $name . '%';

        return Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':name' => $name, ':status' => Yii::app()->params['active_status']));
    }

    public function deleteSupplier($supplier_id)
    {
        Supplier::model()->updateByPk((int)$supplier_id, array('status' => Yii::app()->params['inactive_status']));
    }

    public function undodeleteSupplier($supplier_id)
    {
        Supplier::model()->updateByPk((int)$supplier_id, array('status' => Yii::app()->params['active_status']));
    }
        
         /**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
	public function suggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'(company_name LIKE :keyword or mobile_no like :keyword) and status=:status',
                        'order'=>'company_name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%",':status'=>Yii::app()->params['active_status'])
		));
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->company_name. ' - '.$model->mobile_no,  // label for dropdown list
				'value'=>$model->company_name,  // value for input field
				'id'=>$model->id,       // return values from autocomplete
			);
		}
		return $suggest;
	}

    public static function getSupplierColumns()
    {
        return array(
            array(
                'name' => 'company_name',
                'value' => 'CHtml::link($data->company_name, Yii::app()->createUrl("supplier/update",array("id"=>$data->primaryKey)))',
                'type' => 'raw',
            ),
            'last_name',
            'first_name',
            array(
                'name' => 'mobile_no',
            ),
            array(
                'name' => 'address1',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$data->status=="1" ? TbHtml::labelTb("Active", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Inactive", array("color" => TbHtml::LABEL_COLOR_DEFAULT))',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '<div class="hidden-sm hidden-xs btn-group">{view}{update}{delete}{undeleted}</div>',
                'htmlOptions' => array('class' => 'nowrap'),
                'buttons' => array(
                    'view' => array(
                        'click' => 'updateDialogOpen',
                        'url' => 'Yii::app()->createUrl("supplier/view/",array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn btn-xs btn-success',
                            'data-update-dialog-title' => Yii::t('app', 'View Supplier'),
                        ),
                    ),
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'label' => Yii::t('app', 'Update'),
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                        ),
                    ),
                    'delete' => array(
                        'label' => Yii::t('app', 'Delete'),
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("supplier.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Undo Delete Item'),
                        'url' => 'Yii::app()->createUrl("Supplier/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("supplier.delete")',
                    ),
                ),
            )
        );
    }
    public function saveSupplier($data){
        $id = null;
            $exists = Supplier::model()->exists('company_name=:name', array(':name' => $data['company_name']));
            if (!$exists) {
                $model = new Supplier;
                $model->company_name = $data['company_name'];
                $model->first_name = $data['first_name'];
                $model->last_name = $data['last_name'];
                $model->save();
                $id = $model->id;
            }
        return $id;
    }
}