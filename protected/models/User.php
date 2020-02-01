<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $user_name
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $status
 */
class User extends CActiveRecord
{
    public $password_confirm;
    public $password_reset;

    public $user_archived;
    public $search;

    public $customers;
    public $items;
    public $sales;
    public $employees;
    public $store;
    public $suppliers;
    public $receivings;
    public $reports;
    public $invoices;
    public $payments;
    public $rptprofits;
    public $role_name;
    public $categories;
    public $stockcounts;
    public $stocktransfers;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, password_confirm', 'required'),
			array('email', 'email'),
			array('email', 'unique'),
			array('created_by, updated_by, deleted_by', 'numerical', 'integerOnly'=>true),
			array('email, user_name, password', 'length', 'max'=>45),
			array('password', 'length', 'max'=>128),
			array('status', 'length', 'max'=>1),
			array('created_at, updated_at, deleted_at', 'safe'),
            array('password_confirm', 'compare', 'compareAttribute' => 'password'),
            array('created_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, user_name, password, created_at, updated_at, deleted_at, created_by, updated_by, deleted_by, status, search', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'user_name' => 'Display Name',
			'password' => 'Password',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'deleted_at' => 'Deleted At',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
			'deleted_by' => 'Deleted By',
			'status' => 'Status',
		);
	}

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);

        if  ( Yii::app()->user->getState('user_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'email like :search or user_name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (email like :search or user_name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('user_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'email')
        ));
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave()
    {
        $ph = new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);

        //add the password hash if it's a new record
        if ($this->getIsNewRecord()) {
            $this->password = $ph->hashPassword($this->password);
        } elseif (!empty($this->password) && !empty($this->password_confirm) && ($this->password === $this->password_confirm)) //if it's not a new password, save the password only if it not empty and the two passwords match
        {
            $this->password = $ph->hashPassword($this->password);
        } elseif (!empty($this->password_reset)) {
            $this->password = $ph->hashPassword($this->password_reset);
        }

        //$this->items = implode(', ', $this->items);
        return parent::beforeSave();
    }
}
