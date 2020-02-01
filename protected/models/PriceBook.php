<?php

/**
 * This is the model class for table "receiving_item".
 *
 * The followings are the available columns in table 'receiving_item':
 * @property integer $receive_id
 * @property integer $item_id
 * @property string $description
 * @property integer $line
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property double $discount_amount
 * @property string $discount_type
 */

class PriceBook extends CActiveRecord
{
    public $search;
    public $pricebook_archived;
        
        /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'price_book';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('price_book_name, outlet_id', 'required'),
            array('price_book_name', 'unique'),
            array('price_book_name,search', 'safe', 'on'=>'search'),
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
            'pricings' => array(self::HAS_MANY, 'Pricing', 'price_book_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'), //'ID',
            'price_book_name' => Yii::t('app', 'Name'), //'Name',
            'start_date' => Yii::t('app', 'Start Date'), //'Start Date',
            'end_date' => Yii::t('app', 'End Date'), //'End Date',
            'outlet_id' => Yii::t('app', 'Outlet'), //'Outlet',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        //$criteria->compare('id',$this->id);
        $criteria->compare('price_book_name',$this->price_book_name,true);

        if  ( Yii::app()->user->getState('pricebook_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'price_book_name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (price_book_name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }

        //$criteria->addSearchCondition('status',param('active_status'));

        //$criteria->condition='deleted=:is_deleted';
        //$criteria->params=array(':is_deleted'=>$this::_item_not_deleted);

        //$criteria->compare('id',$this->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pricebook_page_size', Common::defaultPageSize()),
            ),
            'sort' => array('defaultOrder' => 'price_book_name')
        ));

    }

    public function checkExists()
    {
        return PriceBook::model()->count('status=:active_status',
            array(':active_status' => Yii::app()->params['active_status']));
    }

    public function getPriceBookSale()
    {
        $model = PriceBook::model()->findAll(array(
            'order' => 'id',
            'condition' => 'status=:active_status',
            'params' => array(':active_status' => Yii::app()->params['active_status'])
        ));
        $list = CHtml::listData($model, 'id', 'price_book_name');

        return $list;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getPriceBook($id)
    {
        $model = PriceBook::model()->findAll('id=:id', array(':id' => $id));

        return $model;
    }

    public static function getPriceBookDetail($id,$name=''){
        $con='';
        $data=array();
        $sql1 = "SELECT pb.id  price_book_id,price_book_name,outlet_name,cg.group_name,date_format(start_date,'%d-%m-%Y') valid_from,date_format(end_date,'%d-%m-%Y') valid_to
                   FROM price_book pb ,outlet o,customer_group cg
                   WHERE pb.outlet_id=o.id
                   and pb.group_id=cg.id
                   AND pb.id=:id";
        $rawData = Yii::app()->db->createCommand($sql1)->queryAll(true, array(':id' => $id));
        $sql2 = "SELECT name,i.id,cost_price,markup 'markup(%)',discount 'discount(%)',retail_price 'retail price',case when min_unit=9999 then '' else min_unit end 'from quantity',case when max_unit=9999 then '' else max_unit end 'to quantity'
                   FROM item i ,pricings p 
                   WHERE i.id=p.item_id";
             
            foreach($rawData as $key=>$value){
                $data['data'] = $value;
                if($value['price_book_name']=='General'){
                    $itemRawData = Yii::app()->db->createCommand('select id,name , unit_price from item')->queryAll();
                    foreach($itemRawData as $k=>$v){
                        $data['data']['item'][]=$v;
                    }
                }else{
                    $sql2 = $sql2.' AND p.price_book_id=:price_book_id';
                    $itemRawData = Yii::app()->db->createCommand($sql2)->queryAll(true, array(':price_book_id' => $value['price_book_id']));
                    foreach($itemRawData as $k=>$v){
                        $data['data']['item'][]=$v;
                    }
                }
                
            }
        return $data;
    }

    public static function getPriceBookEdit($id){

        $sql1 = "SELECT pb.id  price_book_id,price_book_name name,o.id outlet,cg.id customer_group,date_format(start_date,'%d-%m-%Y') start_date,date_format(end_date,'%d-%m-%Y') end_date
                   FROM price_book pb ,outlet o,customer_group cg
                   WHERE pb.outlet_id=o.id
                   and pb.group_id=cg.id
                   AND pb.id=:id";
        $sql2 = "SELECT name ,item_id 'itemId',cost_price cost,markup,discount,retail_price,min_unit min_qty,max_unit max_qty
                   FROM item i ,pricings p 
                   WHERE i.id=p.item_id
                   AND p.price_book_id=:price_book_id";
        $rawData = Yii::app()->db->createCommand($sql1)->queryAll(true, array(':id' => $id));
        $data=array();
        foreach($rawData as $key=>$value){
            $data['data'] = $value;
            $itemRawData = Yii::app()->db->createCommand($sql2)->queryAll(true, array(':price_book_id' => $value['price_book_id']));
            foreach($itemRawData as $k=>$v){
                $data['data']['item'][]=$v;
            }
        }
        return $data;
    }

    public static function getItemColumns() {
        return array(
            array(
                'name' => 'price_book_name',
                'value' => '$data->status=="1" ? CHtml::link($data->price_book_name, Yii::app()->createUrl("priceBook/view",array("id"=>$data->primaryKey,"name"=>$data->price_book_name))) : "<s class=\"red\">  $data->price_book_name <span>" ',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name'=>'Valid From',
                'value'=>'$data->start_date',
                'type'=>'raw',
                'filter'=>''
            ),
            array(
                'name'=>'Valid To',
                'value'=>'$data->end_date',
                'type'=>'raw',
                'filter'=>''
            )
        );
    }
}
