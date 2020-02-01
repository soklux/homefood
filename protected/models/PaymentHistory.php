<?php

/**
 * This is the model class for table "payment_history".
 *
 * The followings are the available columns in table 'payment_history':
 * @property integer $id
 * @property integer $client_id
 * @property double $payment_amount
 * @property double $give_away
 * @property string $date_paid
 * @property string $note
 * @property integer $employee_id
 *
 * The followings are the available model relations:
 * @property Client $client
 */
class PaymentHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_amount, employee_id', 'required'),
			array('client_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('payment_amount, give_away', 'numerical'),
			array('date_paid, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_id, payment_amount, give_away, date_paid, note, employee_id', 'safe', 'on'=>'search'),
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
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_id' => 'Client',
			'payment_amount' => 'Payment Amount',
			'give_away' => 'Give Away',
			'date_paid' => 'Date Paid',
			'note' => 'Note',
			'employee_id' => 'Employee',
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('payment_amount',$this->payment_amount);
		$criteria->compare('give_away',$this->give_away);
		$criteria->compare('date_paid',$this->date_paid,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('employee_id',$this->employee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function savePaymentHistory($client_id, $payment_amount, $paid_date, $employee_id, $note)
    {
        $payment_id = 0;
        if ($payment_amount <> 0) {
            $payment_history = new PaymentHistory;
            $payment_history->client_id = $client_id;
            $payment_history->payment_amount = $payment_amount;
            $payment_history->date_paid = $paid_date;
            $payment_history->note = $note;
            $payment_history->employee_id = $employee_id;
            $payment_history->save();
            $payment_id = $payment_history->id;
        }

        return $payment_id;
    }
}
