<?php

/**
 * This is the model class for table "account_receivable_supplier".
 *
 * The followings are the available columns in table 'account_receivable_supplier':
 * @property integer $id
 * @property integer $account_id
 * @property integer $employee_id
 * @property integer $trans_id
 * @property string $trans_amount
 * @property string $trans_code
 * @property string $trans_datetime
 * @property string $trans_status
 * @property string $note
 */
class AccountReceivableSupplier extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account_receivable_supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, employee_id, trans_id', 'required'),
			array('account_id, employee_id, trans_id', 'numerical', 'integerOnly'=>true),
			array('trans_amount', 'length', 'max'=>15),
			array('trans_code', 'length', 'max'=>10),
			array('trans_status', 'length', 'max'=>1),
			array('trans_datetime, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, employee_id, trans_id, trans_amount, trans_code, trans_datetime, trans_status, note', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'employee_id' => 'Employee',
			'trans_id' => 'Trans',
			'trans_amount' => 'Trans Amount',
			'trans_code' => 'Trans Code',
			'trans_datetime' => 'Trans Datetime',
			'trans_status' => 'Trans Status',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('trans_id',$this->trans_id);
		$criteria->compare('trans_amount',$this->trans_amount,true);
		$criteria->compare('trans_code',$this->trans_code,true);
		$criteria->compare('trans_datetime',$this->trans_datetime,true);
		$criteria->compare('trans_status',$this->trans_status,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccountReceivableSupplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



}
