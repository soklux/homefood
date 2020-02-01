<?php
	class testExcel extends CActiveRecord
	{
		public $date;
		public $invoice;
		   /**
		 * Returns the static model of the specified AR class.
		 * @param string $className active record class name.
		 * @return InvoicePayment the static model class
		 */
		public static function model($className=__CLASS__)
		{
			return parent::model($className);
		}

		/**
		 * @return string the associated database table name
		 */
		public function tableName()
		{
			return 'testexcelinsert';
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