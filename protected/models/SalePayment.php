<?php

/**
 * This is the model class for table "sale_payment".
 *
 * The followings are the available columns in table 'sale_payment':
 * @property integer $id
 * @property integer $sale_id
 * @property integer $payment_id
 * @property string $payment_type
 * @property double $payment_amount
 * @property double $give_away
 * @property string $date_paid
 * @property string $note
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Sale $sale
 */
class SalePayment extends CActiveRecord
{
    public $total_due;
    public $client_id;

        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sale_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_amount', 'required'),
			array('sale_id, payment_id', 'numerical', 'integerOnly'=>true),
			array('payment_amount, give_away', 'numerical'),
			array('payment_type', 'length', 'max'=>40),
			array('date_paid, note', 'safe'),
            array('modified_date', 'default','value' =>new CDbExpression('NOW()'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('modified_date', 'default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sale_id, payment_id,payment_type, payment_amount, give_away, date_paid, note, modified_date', 'safe', 'on'=>'search'),
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
			'sale' => array(self::BELONGS_TO, 'Sale', 'sale_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sale_id' => 'Sale',
			'payment_type' => 'Payment Type',
			'payment_amount' => 'Payment Amount',
			'give_away' => 'Give Away',
			'date_paid' => 'Date Paid',
			'note' => 'Note',
			'modified_date' => 'Modified Date',
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
	public function search($sale_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('sale_id',$this->sale_id);
		//$criteria->compare('payment_type',$this->payment_type,true);
		//$criteria->compare('payment_amount',$this->payment_amount);
		//$criteria->compare('give_away',$this->give_away);
		//$criteria->compare('date_paid',$this->date_paid,true);
		//$criteria->compare('note',$this->note,true);
		//$criteria->compare('modified_date',$this->modified_date,true);
        $criteria->condition="sale_id=:sale_id";
        $criteria->params = array(':sale_id' => $sale_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalePayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getPaidAmount($sale_id)
    {
        $sql = "SELECT SUM(payment_amount) amount
                  FROM sale_payment 
                  WHERE sale_id=:sale_id
                  ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => (int)$sale_id));

        foreach ($result as $record) {
            $amount = $record['amount'];
        }

        return $amount;
    }

    public function getPayment($sale_id)
    {
        $model = SalePayment::model()->findAll('sale_id=:saleId', array(':saleId' => (int)$sale_id));

        return $model;
    }

    /*
    protected function beforeValidate ()
    {
        // convert to storage format
        $this->date_paid = strtotime ($this->date_paid);
        $this->date_paid = date ('Y-m-d H:i:s', $this->date_paid);

        return parent::beforeValidate ();
    }
     *
    */

    public function invoice($client_id,$compare_operator)
    {
        //$sql = CommonQuery::saleInvoice($compare_operator);

        $sql = $this->saleInvoiceQuery($compare_operator);

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => $client_id,':status' => Yii::app()->params['sale_complete_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function paymentHis($client_id)
    {
        $sql = "SELECT p.id,p.`date_paid`,
                    CONCAT(c.first_name,' ',ifnull(c.last_name,'')) client_name,
                    p.payment_amount,
                    CONCAT(e.first_name,' ',ifnull(e.last_name,'')) employee_name    
                FROM payment_history p, `client` c , employee e
                WHERE p.`client_id` = c.id 
                AND p.employee_id = e.id
                AND p.client_id=:client_id
                ORDER BY date_paid desc";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => $client_id));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'id',
            /*     
            'sort' => array(
                'attributes' => array(
                    'date_paid',
                ),
             ),
             * 
            */
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function payment($sale_id=null,$client_id, $employee_id, $account, $total_paid, $paid_date, $note) {

        if ($sale_id==null) {
            $this->batchPayment($client_id, $employee_id, $account, $total_paid, $paid_date, $note);
        } else {
            $this->invoicePayment($sale_id,$client_id, $employee_id, $account, $total_paid, $paid_date, $note);
        }

    }

    public function invoicePayment($sale_id,$client_id, $employee_id, $account, $total_paid, $paid_date, $note) {

        $trans_code = 'PAY';
        $trans_status = $total_paid > 0 ? 'N' : 'R'; // If [Payment Amount] > 0 then Paid else Return to Customer

        $payment_id = PaymentHistory::model()->savePaymentHistory($client_id, $total_paid, $paid_date, $employee_id, $note);

        $this->saveSalePayment($sale_id, $payment_id, $total_paid, $paid_date, $note);

        AccountReceivable::model()->saveAccountRecv($account->id, $employee_id, $sale_id, -$total_paid, $paid_date, $note, $trans_code, $trans_status);

        Account::model()->withdrawAccountBal($account, $total_paid);

    }

    public function batchPayment($client_id, $employee_id, $account, $total_paid, $paid_date, $note)
    {

        $sql = $this->saleInvoiceQuery('>');

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':client_id' => $client_id,':status' => Yii::app()->params['sale_complete_status']));

        $paid_amount = $total_paid;
        $trans_code = 'PAY';
        $trans_status = $total_paid > 0 ? 'N' : 'R'; // If [Payment Amount] > 0 then Paid else Return to Customer

        $payment_id = PaymentHistory::model()->savePaymentHistory($client_id, $total_paid, $paid_date, $employee_id, $note);

        if ($payment_id <> 0 ) {
            foreach ($result as $record) {
                if ($paid_amount <= $record["balance"]) {
                    $payment_amount = $paid_amount;
                    $this->saveSalePayment($record["sale_id"], $payment_id, $payment_amount, $paid_date, $note);
                    AccountReceivable::model()->saveAccountRecv($account->id, $employee_id, $record["sale_id"],
                        -$payment_amount, $paid_date, $note, $trans_code, $trans_status);
                    break;
                } else {
                    $paid_amount = $paid_amount - $record["balance"];
                    $payment_amount = $record["balance"];
                    $this->saveSalePayment($record["sale_id"], $payment_id, $payment_amount, $paid_date, $note);
                    AccountReceivable::model()->saveAccountRecv($account->id, $employee_id, $record["sale_id"],
                        -$payment_amount, $paid_date, $note, $trans_code, $trans_status);
                }
            }

            Account::model()->withdrawAccountBal($account, $total_paid);
        }

        $message = $payment_id;

        return $message;
    }

    public function saveSalePayment($sale_id, $payment_id, $payment_amount, $paid_date, $note, $payment_type = 'Cash')
    {
        $sale_payment = new SalePayment;
        $sale_payment->sale_id = $sale_id;
        $sale_payment->payment_id = $payment_id;
        $sale_payment->payment_type = $payment_type;
        $sale_payment->payment_amount = $payment_amount;
        $sale_payment->date_paid = $paid_date;
        $sale_payment->note = $note;
        $sale_payment->save();
    }

    public function saleInvoiceQuery($compare_operator) {
        return "SELECT sale_id,sale_time,client_name,employee_name,quantity,sub_total,
                   discount_amount,vat_amount,total,paid,(total- IFNULL(paid,0)) balance,status,status_f
                FROM (
                SELECT sale_id,sale_time,client_name,employee_name,quantity,sub_total,
                   discount_amount,vat_amount,total,paid,balance,status,status_f
                FROM v_sale_invoice_2
                WHERE client_id=:client_id
                AND status=:status
                  ) as t
                WHERE (total- IFNULL(paid,0)) $compare_operator 0
                ORDER BY sale_time";
    }

}
