<?php
	class AssemblyItem extends CActiveRecord{
		public $search;
		/**
	 * @return string the associated database table name
		 */
		public function tableName()
		{
			return 'assembly_item';
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
				'assembly_name' => 'Assembly Name',
				'quantity' => 'Quantity',
				'unit_price' => 'Unit Price'
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
			$criteria->compare('assembly_name',$this->assembly_name);
			$criteria->compare('quantity',$this->quantity);
			$criteria->compare('unit_price',$this->unit_price);

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
		
	    public function getListAssemblyItemUpdate($item_id)
	    {
	        $sql = "SELECT id,assembly_name,quantity,unit_price
	                FROM assembly_item
	                where item_id=:item_id
	                order by id";

	        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id));

	        return $result;
	    }
	    public static function getAssemblyProduct()
	    {
	    	// Recommended: Secure Way to Write SQL in Yii
	        $sql = "SELECT id ,assembly_name AS text 
	                    FROM assembly_item 
	                    WHERE (assembly_name LIKE :name)";

	        $name = '%' . $name . '%';
	        return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));
	    }
	    public static function getItemColumns() {
        return array(
            array(
                'name' => 'assembly_name',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'quantity',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'unit_price',
                'type' => 'raw',
                'filter' => '',
            ),
        );
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