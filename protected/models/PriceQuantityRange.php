<?php 
	class PriceQuantityRange extends CActiveRecord{
		public $item_id;
		public $from_quantity;
		public $to_quantity;
		public $price;
		public $start_date;
		public $end_date;

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
	        return 'price_quantity_range';
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
	}
?>