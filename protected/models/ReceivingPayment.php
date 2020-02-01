<?php

/**
 * This is the model class for table "receiving_payment".
 *
 * The followings are the available columns in table 'receiving_payment':
 * @property integer $id
 * @property integer $receive_id
 * @property integer $payment_id
 * @property string $payment_type
 * @property double $payment_amount
 * @property double $give_away
 * @property string $date_paid
 * @property string $note
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property PaymentHistoryRecv $payment
 */
class ReceivingPayment extends CActiveRecord
{
    public $supplier_id;

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receiving_payment';
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
			array('receive_id, payment_id', 'numerical', 'integerOnly'=>true),
			array('payment_amount, give_away', 'numerical'),
			array('payment_type', 'length', 'max'=>40),
			array('date_paid, note', 'safe'),
            array('modified_date', 'default','value' =>new CDbExpression('NOW()'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('modified_date', 'default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, receive_id, payment_id, payment_type, payment_amount, give_away, date_paid, note, modified_date', 'safe', 'on'=>'search'),
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
			'payment' => array(self::BELONGS_TO, 'PaymentHistoryRecv', 'payment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'receive_id' => 'Receive',
			'payment_id' => 'Payment',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('receive_id',$this->receive_id);
		$criteria->compare('payment_id',$this->payment_id);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('payment_amount',$this->payment_amount);
		$criteria->compare('give_away',$this->give_away);
		$criteria->compare('date_paid',$this->date_paid,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReceivingPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function batchPayment($supplier_id, $employee_id, $account, $total_paid, $paid_date, $note)
    {
        $sql = "SELECT receive_id,receive_time,supplier_name,amount_to_paid
                FROM (
                    SELECT t1.receive_id,receive_time,supplier_name,(t1.`sub_total`-IFNULL(t2.payment_amount,0)) amount_to_paid
                    FROM
                    (SELECT r.id receive_id,r.`receive_time`,CONCAT(s.first_name,' ',last_name) supplier_name,r.`sub_total`
                        FROM `receiving` r, `supplier` s
                        WHERE r.`supplier_id` = s.id
                        AND s.id=:supplier_id) t1 LEFT JOIN `v_receiving_payment` t2 ON t2.receive_id=t1.receive_id
                    ) AS t
                WHERE amount_to_paid>0
                ORDER BY receive_time";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':supplier_id' => $supplier_id));

        $paid_amount = $total_paid;

        $transaction = Yii::app()->db->beginTransaction();
        try {

            $payment_id = PaymentHistoryRecv::model()->savePaymentHistory($supplier_id, $total_paid, $paid_date, $employee_id, $note);

            foreach ($result as $record) {
                if ($paid_amount <= $record["amount_to_paid"]) {
                    $payment_amount = $paid_amount;
                    $this->saveReceivePayment($record["receive_id"], $payment_id, $payment_amount, $paid_date, $note);
                    $this->saveAccountRecv($account->id, $employee_id, $record["receive_id"], $payment_amount, $paid_date, $note);
                    break;
                } else {
                    $paid_amount = $paid_amount - $record["amount_to_paid"];
                    $payment_amount = $record["amount_to_paid"];
                    $this->saveReceivePayment($record["receive_id"], $payment_id, $payment_amount, $paid_date, $note);
                    $this->saveAccountRecv($account->id, $employee_id, $record["receive_id"], $payment_amount, $paid_date, $note);
                }
            }

            AccountSupplier::model()->updateAccountBal($account, $total_paid);
            $transaction->commit();
            $message = $payment_id;
        } catch (Exception $e) {
            $transaction->rollback();
            $message = '-1' . $e->getMessage();
        }

        return $message;
    }

    protected function saveReceivePayment($receive_id, $payment_id, $payment_amount, $paid_date, $note, $payment_type = 'Cash')
    {
        $receive_payment = new ReceivingPayment;
        $receive_payment->receive_id = $receive_id;
        $receive_payment->payment_id = $payment_id;
        $receive_payment->payment_type = $payment_type;
        $receive_payment->payment_amount = $payment_amount;
        $receive_payment->date_paid = $paid_date;
        $receive_payment->note = $note;
        $receive_payment->save();
    }

    protected function saveAccountRecv($account_id, $employee_id, $sale_id, $amount, $trans_date, $note)
    {
        $account_recv = new AccountReceivableSupplier;
        $account_recv->account_id = $account_id;
        $account_recv->employee_id = $employee_id;
        $account_recv->trans_id = $sale_id;
        $account_recv->trans_amount = -$amount;
        $account_recv->trans_code = 'PAY';
        $account_recv->trans_datetime = $trans_date;
        $account_recv->trans_status = 'N';
        $account_recv->note = $note;
        $account_recv->save();

    }

    /*
     * Oustanding Invoices ..
     */
    public function invoice($supplier_id)
    {
        $sql = "SELECT receive_id,receive_time,supplier_name,sub_total,discount_amount,paid,balance
                  FROM (
                    SELECT s.receive_id,receive_time,supplier_name,s.sub_total,s.discount_amount,
                        IFNULL(sp.payment_amount,0) paid,
                        (s.`sub_total`- s.discount_amount-IFNULL(sp.payment_amount,0)) balance
                    FROM
                    (SELECT s.id receive_id,s.`receive_time`,CONCAT(c.first_name,' ',last_name) supplier_name,
                        s.`sub_total`,
                         (CASE WHEN ((`s`.`discount_type` = '%') OR ISNULL(`s`.`discount_type`)) THEN ((`s`.`sub_total` * IFNULL(`s`.`discount_amount`,0)) / 100)
                               ELSE IFNULL(`s`.`discount_amount`,0)
                         END) AS `discount_amount`
                     FROM `receiving` s, `supplier` c
                     WHERE s.`supplier_id` = c.id
                     AND c.id=:supplier_id) s LEFT JOIN v_receiving_payment sp ON sp.receive_id=s.receive_id
                    ) AS t
                  WHERE balance>0
                  ORDER BY receive_time";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':supplier_id' => $supplier_id));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'receive_id',
            /*
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
             *
            */
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function invoiceHis($supplier_id)
    {
        $sql = "SELECT receive_id,receive_time,supplier_name,sub_total,discount_amount,paid,balance
                  FROM (
                    SELECT s.receive_id,receive_time,supplier_name,s.sub_total,s.discount_amount,
                        IFNULL(sp.payment_amount,0) paid,
                        (s.`sub_total`- s.discount_amount-IFNULL(sp.payment_amount,0)) balance
                    FROM
                    (SELECT s.id receive_id,s.`receive_time`,CONCAT(c.first_name,' ',last_name) supplier_name,
                        s.`sub_total`,
                         (CASE WHEN ((`s`.`discount_type` = '%') OR ISNULL(`s`.`discount_type`)) THEN ((`s`.`sub_total` * IFNULL(`s`.`discount_amount`,0)) / 100)
                               ELSE IFNULL(`s`.`discount_amount`,0)
                         END) AS `discount_amount`
                     FROM `receiving` s, `supplier` c
                     WHERE s.`supplier_id` = c.id
                     AND c.id=:supplier_id) s LEFT JOIN v_receiving_payment sp ON sp.receive_id=s.receive_id
                    ) AS t
                  WHERE balance=0
                  ORDER BY receive_time";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':supplier_id' => $supplier_id));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'receive_id',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function paymentHis($supplier_id)
    {
        $sql = "SELECT p.id,p.`date_paid`,
                    CONCAT(c.first_name,' ',c.last_name) supplier_name,
                    p.payment_amount,
                    CONCAT(e.first_name,' ',e.last_name) employee_name
                  FROM payment_history_recv p, `supplier` c , employee e
                  WHERE p.`supplier_id` = c.id
                  and p.employee_id = e.id
                  and p.supplier_id=:supplier_id
                  ORDER BY date_paid desc";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':supplier_id' => $supplier_id));

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


}
