<?php

/**
 * This is the model class for table "item_price_quantity".
 *
 * The followings are the available columns in table 'item_price_quantity':
 * @property integer $id
 * @property integer $item_id
 * @property integer $from_quatity
 * @property integer $to_quantity
 * @property double $unit_price
 * @property string $start_date
 * @property string $end_date
 */
class ItemPriceQuantity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_price_quantity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('item_id, from_quantity, to_quantity', 'required'),
			// array('item_id, from_quantity, to_quantity', 'numerical', 'integerOnly'=>true),
			// array('unit_price', 'numerical'),
			// array('start_date, end_date', 'safe'),
   //          array('start_date, end_date', 'date', 'format'=>array('dd/MM/yyyy')),
			// // The following rule is used by search().
			// // @todo Please remove those attributes that should not be searched.
			// array('id, item_id, from_quantity, to_quantity, unit_price, start_date, end_date', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'from_quantity' => 'From Quatity',
			'to_quantity' => 'To Quantity',
			'unit_price' => 'Unit Price',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
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
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('from_quantity',$this->from_quatity);
		$criteria->compare('to_quantity',$this->to_quantity);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
    public function getListItemPriceQuantityUpdate($item_id)
    {
        $sql = "SELECT id,from_quantity,to_quantity,unit_price,start_date,end_date
                FROM item_price_quantity
                where item_id=:item_id
                order by id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id));

        return $result;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemPriceQuantity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
