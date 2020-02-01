<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property string $id
 * @property integer $country_id
 * @property string $city_name
 * @property string $city_native_name
 * @property string $city_code
 *
 * The followings are the available model relations:
 * @property District[] $districts
 */
class City extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_name', 'required'),
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('city_name, city_native_name', 'length', 'max'=>128),
			array('city_code', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, country_id, city_name, city_native_name, city_code', 'safe', 'on'=>'search'),
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
			'districts' => array(self::HAS_MANY, 'District', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_id' => 'Country',
			'city_name' => 'City Name',
			'city_native_name' => 'City Native Name',
			'city_code' => 'City Code',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('city_native_name',$this->city_native_name,true);
		$criteria->compare('city_code',$this->city_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function getCityInfo()
    {
        return $this->city_name;
    }

    public function getCity()
    {
        $model = City::model()->findAll(array(
            'order' => 'id',
        ));
        $list = CHtml::listData($model, 'id', 'CityInfo');

        return $list;
    }
}
