<?php

/**
 * This is the model class for table "click_notification_log".
 *
 * The followings are the available columns in table 'click_notification_log':
 * @property integer $id
 * @property integer $sale_id
 * @property integer $employee_id
 * @property integer $alert_type
 * @property string $alert_cat
 * @property string $date_log
 */
class ClickNotificationLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'click_notification_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_id, employee_id, alert_type', 'numerical', 'integerOnly'=>true),
			array('alert_cat', 'length', 'max'=>30),
			array('date_log', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sale_id, employee_id, alert_type, alert_cat, date_log', 'safe', 'on'=>'search'),
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
			'sale_id' => 'Sale',
			'employee_id' => 'Employee',
			'alert_type' => 'Alert Type',
			'alert_cat' => 'Alert Cat',
			'date_log' => 'Date Log',
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
		$criteria->compare('sale_id',$this->sale_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('alert_type',$this->alert_type);
		$criteria->compare('alert_cat',$this->alert_cat,true);
		$criteria->compare('date_log',$this->date_log,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClickNotificationLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function countNotification($employee_id=35)
    {
        $status_rejected=param("sale_reject_status");
        $status_approved=param("sale_complete_status");
        /*$sql="SELECT  COUNT(*) FROM sale
                WHERE id NOT IN (
                  SELECT sale_id FROM click_notification_log WHERE employee_id=:employee_id
                  UNION
                  SELECT sale_id FROM click_notification_log WHERE date_log IS NULL
                  )as t1
                left join click_notification_log t2 on t1.sale_id=t2.sale_id and t1.status=t2.status
                AND STATUS=:status";*/

        $sql="SELECT 
                SUM(IF(STATUS='1',nRec,0)) nRecAppr,
                SUM(IF(STATUS='-3',nRec,0)) nRecReject,
                SUM(IF(STATUS='1',nRec,0)+IF(STATUS='-3',nRec,0)) Total
                FROM (
                    SELECT  t1.status,COUNT(*) nRec FROM sale t1
                    LEFT JOIN click_notification_log t2 ON t1.id=t2.sale_id AND t1.status=t2.alert_type
                    AND t2.employee_id=:employee_id
                    WHERE t1.id NOT IN (SELECT sale_id FROM click_notification_log WHERE date_log IS NULL)                 
                    AND t1.STATUS IN (:status_rejected,:status_approved) 
                    AND t2.sale_id IS NULL
                    GROUP BY t1.status
                )AS l1";

        $command = Yii::app()->db->createCommand($sql);

        $command->bindParam(":employee_id", $employee_id);
        $command->bindParam(":status_rejected", $status_rejected);
        $command->bindParam(":status_approved", $status_approved);
        return $command->queryRow();
    }

    public function insertNotifyRejectedLog($employee_id)
    {
        $status_rejected=param("sale_reject_status");

        $sql="INSERT click_notification_log (sale_id,employee_id,alert_type,alert_cat,date_log)
            SELECT  id sale_id,$employee_id,STATUS,'Rejected Notification',NOW() FROM sale
            WHERE id IN (
                SELECT  id FROM sale
                WHERE id NOT IN (
                    SELECT sale_id FROM click_notification_log WHERE employee_id=:employee_id and alert_type=:reject_status_1
                    UNION
                    SELECT sale_id FROM click_notification_log WHERE date_log IS NULL
                )
                AND STATUS=:reject_status_2
            )";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
        $command->bindParam(":reject_status_1", $status_rejected);
        $command->bindParam(":reject_status_2", $status_rejected);
        $command->execute();
    }

    public function insertNotifyApprovedLog($employee_id)
    {
        $status_approved=param("sale_complete_status");

        $sql="INSERT click_notification_log (sale_id,employee_id,alert_type,alert_cat,date_log)
            SELECT  id sale_id,$employee_id,STATUS,'Rejected Notification',NOW() FROM sale
            WHERE id IN (
                SELECT  id FROM sale
                WHERE id NOT IN (
                    SELECT sale_id FROM click_notification_log WHERE employee_id=:employee_id and alert_type=:status_approved_1
                    UNION
                    SELECT sale_id FROM click_notification_log WHERE date_log IS NULL
                )
                AND STATUS=:status_approved_2
            )";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
        $command->bindParam(":status_approved_1", $status_approved);
        $command->bindParam(":status_approved_2", $status_approved);
        $command->execute();
    }
}
