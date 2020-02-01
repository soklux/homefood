<?php

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'contact':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property string $address1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $fax
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 */
class Contact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('first_name', 'required'),
			array('city_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>100),
			array('mobile_no', 'length', 'max'=>15),
			array('address1, address2', 'length', 'max'=>60),
			array('country_code', 'length', 'max'=>2),
			array('email', 'length', 'max'=>30),
			array('fax', 'length', 'max'=>20),
			array('notes, created_at, updated_at', 'safe'),
            array('created_at,updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, mobile_no, dob, address1, address2, city_id, country_code, email, fax, notes, created_at, updated_at', 'safe', 'on'=>'search'),
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'mobile_no' => Yii::t('app', 'Mobile No'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'city_id' => Yii::t('app', 'City'),
            'country_code' => Yii::t('app', 'Country Code'),
            'email' => Yii::t('app', 'Email'),
            'notes' => Yii::t('app', 'Notes'),
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function conatctByID($id)
    {
        $model = Contact::model()->findByPk($id);

        return isset($model) ? $model : null;
    }
}
