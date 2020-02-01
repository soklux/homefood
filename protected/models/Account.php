<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 * @property string $current_balance
 * @property string $status
 * @property string $date_created
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Transactions[] $transactions
 */
class Account extends CActiveRecord
{ 
       /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id', 'required'),
			array('client_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('current_balance', 'length', 'max'=>15),
			array('status', 'length', 'max'=>1),
			array('date_created, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_id, name, current_balance, status, date_created, note', 'safe', 'on'=>'search'),
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
			'transactions' => array(self::HAS_MANY, 'Transactions', 'account_id'),
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
		$criteria->compare('client_id',$this->client_id);
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
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function saveAccount($client_id, $client_fname)
    {
        $account=$this->getAccountInfo($client_id);
        if (!isset($account)) {
            $account = new Account;
        }

        $account->client_id = $client_id;
        $account->name = $client_fname;
        $account->status = Yii::app()->params['_active_status'];
        $account->date_created = date('Y-m-d H:i:s');
        $account->save();
    }

    public static function getAccountInfo($client_id)
    {
        return Account::model()->find('client_id=:client_id', array(':client_id' => $client_id));

    }

    /*
     * To Withdraw Customer Account Balance
     */
    public function withdrawAccountBal($account, $amount)
    {
        // Update Account balance of the Client
        $account->current_balance = $account->current_balance - $amount;
        $account->save();
    }

    /*
     * To Deposit Customer Account Balance
     */
    public function depositAccountBal($account, $amount)
    {
        $account->current_balance = $account->current_balance + $amount;
        $account->save();
    }

    public static function getAccountBalance($client_id)
    {
        $outstanding_bal = 0;
        $account = Account::model()->getAccountInfo($client_id);

        if ($account) {
            $outstanding_bal = $account->current_balance;
        }

        return $outstanding_bal;
    }
        
        
}
