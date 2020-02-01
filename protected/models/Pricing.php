<?php

/**
 * This is the model class for table "receiving_item".
 *
 * The followings are the available columns in table 'receiving_item':
 * @property integer $receive_id
 * @property integer $item_id
 * @property string $description
 * @property integer $line
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property double $discount_amount
 * @property string $discount_type
 */

class Pricing extends CActiveRecord
{
	public $search;
        
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pricings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
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
			'pricebook' => array(self::BELONGS_TO, 'PriceBook', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'), //'ID',
            'min_unit' => Yii::t('app', 'Min Unit'), //'Name',
            'max_unit' => Yii::t('app', 'Max Unit'), //'Start Date',
        );
    }
    public function checkExists()
    {
        return Pricing::model()->count('status=:active_status',
            array(':active_status' => Yii::app()->params['active_status']));
    }
    public function getPriceBookSale()
    {
        $model = Pricing::model()->findAll(array(
            'order' => 'id',
            'condition' => 'status=:active_status',
            'params' => array(':active_status' => Yii::app()->params['active_status'])
        ));
        $list = CHtml::listData($model, 'id', 'PriceBookInfo');

        return $list;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReceivingItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
