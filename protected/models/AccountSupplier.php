<?php

/**
 * This is the model class for table "account_supplier".
 *
 * The followings are the available columns in table 'account_supplier':
 * @property integer $id
 * @property integer $supplier_id
 * @property string $name
 * @property string $current_balance
 * @property string $status
 * @property string $date_created
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Supplier $supplier
 */
class AccountSupplier extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account_supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id', 'required'),
			array('supplier_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('current_balance', 'length', 'max'=>15),
			array('status', 'length', 'max'=>1),
			array('date_created, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, supplier_id, name, current_balance, status, date_created, note', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplier_id' => 'Supplier',
			'name' => 'Name',
			'current_balance' => 'Current Balance',
			'status' => 'Status',
			'date_created' => 'Date Created',
			'note' => 'Note',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('current_balance',$this->current_balance,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccountSupplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function saveAccount($supplier_id,$supplier_name)
    {
        $account_supplier=new AccountSupplier;
        $account_supplier->supplier_id=$supplier_id;
        $account_supplier->name=$supplier_name;
        $account_supplier->status=Yii::app()->params['_active_status'];
        $account_supplier->date_created=date('Y-m-d H:i:s');
        $account_supplier->save();
    }

    public static function getAccountInfo($supplier_id)
    {
        return AccountSupplier::model()->find('supplier_id=:supplier_id', array(':supplier_id' => $supplier_id));
    }

    public function updateAccountBal($account, $amount)
    {
        // Update Account balance of the Client
        $account->current_balance = $account->current_balance - $amount;
        $account->save();
    }

}
