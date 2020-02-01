<?php

/**
 * This is the model class for table "commune".
 *
 * The followings are the available columns in table 'commune':
 * @property string $id
 * @property string $district_id
 * @property string $commune_name
 * @property string $commune_native_name
 * @property string $commune_code
 *
 * The followings are the available model relations:
 * @property District $district
 * @property Village[] $villages
 */
class Commune extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'commune';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('district_id', 'length', 'max'=>10),
			array('commune_name, commune_native_name', 'length', 'max'=>128),
			array('commune_code', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, district_id, commune_name, commune_native_name, commune_code', 'safe', 'on'=>'search'),
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
			'district' => array(self::BELONGS_TO, 'District', 'district_id'),
			'villages' => array(self::HAS_MANY, 'Village', 'commune_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'district_id' => 'District',
			'commune_name' => 'Commune Name',
			'commune_native_name' => 'Commune Native Name',
			'commune_code' => 'Commune Code',
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
		$criteria->compare('district_id',$this->district_id,true);
		$criteria->compare('commune_name',$this->commune_name,true);
		$criteria->compare('commune_native_name',$this->commune_native_name,true);
		$criteria->compare('commune_code',$this->commune_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Commune the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function getCommuneInfo()
    {
        return $this->commune_name;
    }

    public function getCommune()
    {
        $model = Commune::model()->findAll(array(
            'order' => 'id',
        ));
        $list = CHtml::listData($model, 'id', 'CommuneInfo');

        return $list;
    }
}
