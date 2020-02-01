<?php

/**
 * This is the model class for table "district".
 *
 * The followings are the available columns in table 'district':
 * @property string $id
 * @property string $city_id
 * @property string $district_name
 * @property string $district_native_name
 * @property string $distrcit_code
 *
 * The followings are the available model relations:
 * @property Commune[] $communes
 * @property City $city
 */
class District extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'district';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('district_name', 'required'),
			array('city_id', 'length', 'max'=>10),
			array('district_name, district_native_name', 'length', 'max'=>128),
			array('distrcit_code', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, city_id, district_name, district_native_name, distrcit_code', 'safe', 'on'=>'search'),
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
			'communes' => array(self::HAS_MANY, 'Commune', 'district_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_id' => 'City',
			'district_name' => 'District Name',
			'district_native_name' => 'District Native Name',
			'distrcit_code' => 'Distrcit Code',
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
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('district_name',$this->district_name,true);
		$criteria->compare('district_native_name',$this->district_native_name,true);
		$criteria->compare('distrcit_code',$this->distrcit_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return District the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function getDistrictInfo()
    {
        return $this->district_name;
    }

    public function getDistrict()
    {
        $model = District::model()->findAll(array(
            'order' => 'id',
        ));
        $list = CHtml::listData($model, 'id', 'DistrictInfo');

        return $list;
    }
}
