<?php

/**
 * This is the model class for table "unit_measurable".
 *
 * The followings are the available columns in table 'unit_measurable':
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class UnitMeasurable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'unit_measurable';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>15),
			array('created_at, updated_at', 'safe'),
            array('created_at,updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'Item', 'unit_measurable_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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
		$criteria->compare('name',$this->name,true);
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
	 * @return UnitMeasurable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    // Get Item Category for select 2 -- cannot finding the style of normal select and button next to it
    public static function getUnitMeasurable2($name = '') {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = "SELECT id ,name AS text
                FROM unit_measurable
                WHERE (name LIKE :name)";

        $name = '%' . $name . '%';
        return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));

    }

    public function saveUnitMeasurable($name)
    {
        $id = null;
        $exists = Category::model()->exists('CONVERT(id,CHAR(3))=:id', array(':id' => $name));
        if (!$exists) {
            $model = new UnitMeasurable;
            $model->name = $name;
            $model->save();
            $id = $model->id;
        }

        return $id;
    }

    public function saveUnitMeasurable2($name)
    {
        $id = null;
        $exists = UnitMeasurable::model()->exists('name=:name', array(':name' => $name));
        if (!$exists) {
            $model = new UnitMeasurable;
            $model->name = $name;
            $model->save();
            $id = $model->id;
        }
        return $id;
    }
}
