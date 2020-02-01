<?php

class InventoryCount extends CActiveRecord
{
    public $item_id;
    public $name;
    public $expected;
    public $counted;
    public $unit;
    public $cost;
    public $search;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Item the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'inventory_count';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, created_date','required'),
            // array('name', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'name, search',
                'safe',
                'on' => 'search'
            ),
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
                'assemblies'=>array(self::BELONGS_TO,'Item','id')
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
                'name' => 'Name',
                'expected' => 'Expected',
                'counted' => 'Counted'
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
            $criteria->compare('name',$this->name);
            $criteria->compare('expected',$this->expected);
            $criteria->compare('counted',$this->counted);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
        
        public function getListInventoryItemUpdate($item_id)
        {
            $sql = "SELECT id,name,expected,counted,unit,cost
                    FROM inventory_count
                    where item_id=:item_id
                    order by id";

            $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id));

            return $result;
        }

        public static function getInventoryCount()
        {
            // Recommended: Secure Way to Write SQL in Yii
            $sql = "SELECT id ,name AS text 
                        FROM inventory_count
                        WHERE (name LIKE :name)";

            $name = '%' . $name . '%';
            return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));
        }
        public static function getItemColumns() {
        return array(
            array(
                'name' => 'name',
                'value' => 'CHtml::link($data->name, Yii::app()->createUrl("receivingItem/index?trans_mode=count_detail&id=$data->primaryKey&name=$data->name",array())) ',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'created_date',
                'type' => 'raw',
                'filter' => '',
            )
        );
    }
    public static function getItemDetailColumns() {
        return array(
            array(
                'name' => 'name',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'created_date',
                'type' => 'raw',
                'filter' => '',
            ),
        );
    }
}