<?php

/**
 * This is the model class for table "village".
 *
 * The followings are the available columns in table 'village':
 * @property string $id
 * @property string $commune_id
 * @property string $village_name
 * @property string $village_native_name
 * @property string $vaillage_code
 *
 * The followings are the available model relations:
 * @property Commune $commune
 */
class Village extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'village';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('village_name', 'required'),
			array('commune_id', 'length', 'max'=>10),
			array('village_name, village_native_name', 'length', 'max'=>128),
			array('vaillage_code', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, commune_id, village_name, village_native_name, vaillage_code', 'safe', 'on'=>'search'),
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
			'commune' => array(self::BELONGS_TO, 'Commune', 'commune_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'commune_id' => 'Commune',
			'village_name' => 'Village Name',
			'village_native_name' => 'Village Native Name',
			'vaillage_code' => 'Vaillage Code',
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
		$criteria->compare('commune_id',$this->commune_id,true);
		$criteria->compare('village_name',$this->village_name,true);
		$criteria->compare('village_native_name',$this->village_native_name,true);
		$criteria->compare('vaillage_code',$this->vaillage_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Village the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function getVillageInfo()
    {
        return $this->village_name;
    }

    public function getVillage()
    {
        $model = Village::model()->findAll(array(
            'order' => 'id',
        ));
        $list = CHtml::listData($model, 'id', 'VillageInfo');

        return $list;
    }
}
