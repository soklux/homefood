<?php

class Item extends CActiveRecord
{
    public $inventory;
    public $inv_quantity;
    public $items_add_minus;
    public $inv_comment;
    public $sub_quantity;
    public $unit_id;
    public $image;
    public $promo_price;
    public $promo_start_date;
    public $promo_end_date;
    public $item_archived;
    public $search;
    public $markup;
    public $tags;
    public $sku;

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
        return 'item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, cost_price, unit_price', 'required'),
            array(
                'item_number,sku,mpn,isbn',
                'unique',
                'message' => '{attribute} {value} already exists ' .
                    '<a class="btn btn-xs btn-info" href="UpdateImage/id/{value}/item_number_flag/1"><span class="glyphicon ace-icon fa fa-edit"></span></a>'
            ),
            array('name', 'unique'),
            array(
                'category_id, supplier_id,brand_id, unit_id, unit_measurable_id, allow_alt_description, is_serialized, is_expire, count_interval',
                'numerical',
                'integerOnly' => true
            ),
            array('cost_price, unit_price, quantity, reorder_level, items_add_minus, promo_price', 'numerical'),
            //array('unit_price','compare','compareAttribute'=>'cost_price','operator'=>'>=','message'=>'Buy Price must be less than or equal to Sale Price'),
            array('name', 'length', 'max' => 100),
            array('sku', 'length', 'max' => 32),
            array('item_number', 'length', 'max' => 255),
            array('location', 'length', 'max' => 20),
            array('batch_number', 'length', 'max' => 45),
            array('status', 'length', 'max' => 1),
            array('description, inv_comment, promo_end_date, promo_start_date', 'safe'),
            array('image', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true, 'maxSize' => 5 * 1024 * 1024),
            array('item_number', 'default', 'setOnEmpty' => true, 'value' => null),
            array('created_date,modified_date', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('quantity', 'default', 'value' => 0, 'setOnEmpty' => true, 'on' => 'insert'),
            array('modified_date', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, name, search, item_number,batch_number,unit_id, category_id, supplier_id, cost_price, unit_price, quantity, unit_measurable_id, reorder_level, location, allow_alt_description, is_serialized, description, status, promo_price, is_expire, count_interval,tags',
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
            'inventories' => array(self::HAS_MANY, 'Inventory', 'trans_items'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'unit_measurement' => array(self::BELONGS_TO, 'UnitMeasurable', 'unit_measurable_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            //'unit' => array(self::BELONGS_TO, 'ItemUnit', 'unit_id'),
            'sales' => array(self::MANY_MANY, 'Sale', 'sale_item(item_id, sale_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'item_number' => Yii::t('app', 'UPC'),
            'unit_id' => Yii::t('app', 'Unit ID'),
            'category_id' => Yii::t('app', 'Category'),
            'brand_id' => Yii::t('app', 'Brand'),
            'supplier_id' => Yii::t('app', 'Supplier'),
            'cost_price' => Yii::t('app', 'Buy Price'),
            'unit_price' => Yii::t('app', 'Sell Price'),
            'quantity' => Yii::t('app', 'Opening Quantity'),
            'reorder_level' => Yii::t('app', 'Reorder Level'),
            'location' => Yii::t('app', 'Location'),
            'allow_alt_description' => Yii::t('app', 'Alt Description'),
            'is_serialized' => Yii::t('app', 'Is Serialized'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'items_add_minus' => Yii::t('app', 'Item to add/substract'),
            'inv_quantity' => Yii::t('app', 'Inv Quantity'),
            'inv_comment' => Yii::t('app', 'Inv Comment'),
            'inventory' => Yii::t('app', 'Inventory'),
            'sub_quantity' => Yii::t('app', 'Sub Quantity'),
            'promo_price' => Yii::t('app', 'Promo Price'),
            'promo_start_date' => Yii::t('app', 'Promo Start'),
            'promo_end_date' => Yii::t('app', 'Promo End'),
            'is_expire' => Yii::t('app', 'Is Expire ?'),
            'count_interval' => Yii::t('app', 'Count Interval'),
            'unit_measurable_id' => Yii::t('app', 'Unit Of Measurable'),
            'markup'=>Yii::t('app','Markup(%)'),
            'sku'=>Yii::t('app','SKU'),
            'mpn'=>Yii::t('app','MPN'),
            'isbn'=>Yii::t('app','ISBN')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        
        if  ( Yii::app()->user->getState('item_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'name LIKE :name OR item_number LIKE :name';
            $criteria->params = array(
                ':name' => '%' . $this->search . '%',
                ':item_number' => $this->search . '%'
            );
        } else {
            $criteria->condition = 'status=:active_status AND (name LIKE :name OR item_number like :name)';
            $criteria->params = array(
                ':active_status' => param('active_status'),
                ':name' => '%' . $this->search . '%',
                ':item_number' => $this->search . '%'
            );
        }

        //$criteria->addSearchCondition('status',param('active_status'));

        //$criteria->condition='deleted=:is_deleted';
        //$criteria->params=array(':is_deleted'=>$this::_item_not_deleted);

        $criteria->compare('category_id',$this->category_id);
        $criteria->compare('quantity',$this->quantity);
        $criteria->compare('location',$this->location,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('item_page_size', Common::defaultPageSize()),
            ),
            'sort' => array('defaultOrder' => 'name')
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function lowStock()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        //$criteria->compare('cost_price',$this->cost_price);
        //$criteria->compare('unit_price',$this->unit_price);
        //$criteria->compare('quantity',$this->quantity);
        //$criteria->compare('reorder_level',$this->reorder_level);
        $criteria->compare('location', $this->location, true);
        //$criteria->compare('allow_alt_description',$this->allow_alt_description);
        //$criteria->compare('is_serialized',$this->is_serialized);
        $criteria->compare('description', $this->description, true);
        //$criteria->compare('status',$this->status);

        $criteria->condition = "quantity<reorder_level and quantity<>0";

        //$criteria->condition="quantity<>0";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array('defaultOrder' => 'name')
        ));
    }

    // Item out of stock or zero stock
    public function outStock()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        //$criteria->compare('cost_price',$this->cost_price);
        //$criteria->compare('unit_price',$this->unit_price);
        //$criteria->compare('quantity',$this->quantity);
        //$criteria->compare('reorder_level',$this->reorder_level);
        //$criteria->compare('location',$this->location,true);
        //$criteria->compare('allow_alt_description',$this->allow_alt_description);
        //$criteria->compare('is_serialized',$this->is_serialized);
        //$criteria->compare('description',$this->description,true);
        //$criteria->compare('status',$this->status);

        $criteria->condition = "quantity=0";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array('defaultOrder' => 'name')
        ));
    }


    public static function getItem($name = '')
    {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = 'SELECT id ,concat_ws(" : ",name,unit_price) AS text
                    FROM item 
                    WHERE name LIKE :item_name
                    AND status=:status
                    UNION ALL
                    SELECT id ,concat_ws(" : ",name,unit_price) AS text
                    FROM item
                    WHERE item_number=:item_number
                    AND status=:status';

        $item_name = '%' . $name . '%';
        $item_number = $name;

        return Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':item_name' => $item_name,
                ':item_number' => $item_number,
                ':status' => param('active_status'),
            )
        );
    }

    public function getItemInfo($item_id)
    {
        $model = Item::model()->findByPk($item_id);

        return $model;
    }

    public function costHistory($item_id)
    {
        $sql = "SELECT
                    r.`id`,
                    r.`receive_time`,
                    IFNULL((SELECT company_name FROM supplier s WHERE s.id=r.`supplier_id`),'N/A') supplier_id,
                    r.`employee_id`,
                    r.`remark`,
                    ri.`cost_price`,
                    ri.`quantity`
                  FROM `receiving` r INNER JOIN receiving_item ri ON r.id=ri.`receive_id`
                                                  AND ri.`item_id`=:item_id
                  ORDER BY r.receive_time";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'id',
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));

        return $dataProvider; // Return as array object
    }

    public function avgCost($item_id)
    {
        $sql = "SELECT AVG(cost_price) avg_cost FROM `receiving_item` WHERE item_id=:item_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => (int)$item_id));

        foreach ($result as $record) {
            $cost = $record['avg_cost'];
        }

        return $cost;
    }

    public function avgPrice($item_id)
    {
        $sql = "SELECT AVG(new_price) avg_cost FROM `item_price` WHERE item_id=:item_id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => (int)$item_id));

        foreach ($result as $record) {
            $cost = $record['avg_cost'];
        }

        return $cost;
    }

    protected function afterFind()
    {

        $this->cost_price = round($this->cost_price, Common::getDecimalPlace());
        $this->unit_price = round($this->unit_price, Common::getDecimalPlace());

        parent::afterFind(); //To raise the event
    }

    // public function getItemPriceTier($item_id, $price_tier_id)
    // {
    //     $sql = "SELECT i.`id`,i.`name`,i.`item_number`,
    //                 CASE WHEN ipt.`price` IS NOT NULL THEN ipt.`price`
    //                     ELSE i.`unit_price`
    //                 END unit_price,
    //                 i.`description`,um.`name` unit_measurable
    //         FROM `item` i LEFT JOIN item_price_tier ipt ON ipt.`item_id`=i.id
    //                 AND ipt.`price_tier_id`=:price_tier_id
    //               LEFT JOIN unit_measurable um ON um.id = i.unit_measurable_id
    //         WHERE i.id=:item_id
    //         AND status=:status";

    //     if (!is_numeric($item_id)) {
    //         $item_id = 'NULL';
    //     }

    //     $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
    //             ':item_id' => $item_id,
    //             ':price_tier_id' => $price_tier_id,
    //             ':status' => param('active_status'),
    //         )
    //     );

    //     return $result;
    // }

    public function getItemPriceTier($item_id,$client_id,$quantity)
    {
        $sql = "SELECT i.`id`,i.`name`,i.`item_number`,cg.group_name,
                    MIN(CASE 
                        WHEN 
                            pr.`retail_price` IS NOT NULL
                        THEN pr.`retail_price`
                        ELSE i.`unit_price`
                        END) unit_price,
                        i.`description`,um.`name` unit_measurable
                FROM client cl JOIN customer_group cg
                ON cl.price_tier_id=cg.id
                  AND cl.id=:client_id JOIN price_book pb 
                  ON cg.id=pb.group_id JOIN pricings pr
                  ON pb.id=pr.price_book_id
                  AND pb.status=:status RIGHT JOIN item i
                ON pr.item_id=i.id
                  AND :quantity BETWEEN min_unit AND max_unit LEFT JOIN unit_measurable um 
                  ON um.id = i.unit_measurable_id
                WHERE i.id=:item_id
                AND i.status=:status
                GROUP BY i.`id`,i.`name`,i.`item_number`,cg.group_name,i.`description`,um.`name`";

        if (!is_numeric($item_id)) {
            $item_id = 'NULL';
        }

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':item_id' => $item_id,
                ':client_id' => $client_id,
                ':status' => param('active_status'),
                ':quantity' => $quantity,
            )
        );

        return $result;
    }

    // public function getItemPriceTierItemNum($item_id, $price_tier_id)
    // {
    //     $sql = "SELECT i.`id`,i.`name`,i.`item_number`,
    //                 CASE WHEN ipt.`price` IS NOT NULL THEN ipt.`price`
    //                     ELSE i.`unit_price`
    //                 END unit_price,
    //                 i.`description`,um.`name` unit_measurable
    //         FROM `item` i LEFT JOIN item_price_tier ipt ON ipt.`item_id`=i.id
    //                 AND ipt.`price_tier_id`=:price_tier_id
    //              LEFT JOIN unit_measurable um ON um.id = i.unit_measurable_id
    //         WHERE i.item_number=:item_id
    //         AND status=:status";

    //     $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
    //             ':item_id' => $item_id,
    //             ':price_tier_id' => $price_tier_id,
    //             ':status' => param('active_status'),
    //         )
    //     );

    //     return $result;
    // }


    public function getItemPriceTierItemNum($item_id, $price_book_id, $quantity)
    {
        $sql = "SELECT i.`id`,i.`name`,i.`item_number`,cg.group_name,
                    MIN(CASE 
                        WHEN 
                            pr.`retail_price` IS NOT NULL
                        THEN pr.`retail_price`
                        ELSE i.`unit_price`
                        END) unit_price,
                        i.`description`,um.`name` unit_measurable
                  FROM client cl JOIN customer_group cg
                    ON cl.price_tier_id=cg.id JOIN price_book pb 
                    ON cg.id=pb.group_id JOIN pricings pr
                    ON pb.id=pr.price_book_id
                    AND pb.status=:status RIGHT JOIN item i
                    ON pr.item_id=i.id
                    AND :quantity BETWEEN min_unit AND max_unit LEFT JOIN unit_measurable um 
                    ON um.id = i.unit_measurable_id
                  WHERE i.item_number=:item_id
                  AND i.status=:status
                  GROUP BY i.`id`,i.`name`,i.`item_number`,cg.group_name,i.`description`,um.`name`";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':item_id' => $item_id,
                ':price_book_id' => $price_book_id,
                ':status' => param('active_status'),
                ':quantity' => $quantity
            )
        );

        return $result;
    }

    public function deleteItem($id)
    {
        Item::model()->updateByPk((int)$id, array('status' => param('inactive_status')));
    }

    public function undodeleteItem($id)
    {
        Item::model()->updateByPk((int)$id, array('status' => param('active_status')));
    }

    public static function itemAlias($type, $code = null)
    {

        $_items = array(
            'number_per_page' => array(
                '' => '0',
                20 => '20',
                50 => '50',
                100 => '100',
                200 => '200',
                500 => '500',
            ),
            'stock_count_interval' => array(
                1 => Yii::t('app', 'Daily'),
                7 => Yii::t('app', 'Weekly'),
                14 => Yii::t('app', 'Bi-Weekly'),
                30 => Yii::t('app', 'Monthly'),
            ),
        );

        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else {
            return isset($_items[$type]) ? $_items[$type] : false;
        }
    }

    public function suggest($keyword, $limit = 20)
    {
        $models = $this->findAll(array(
            'condition' => '(name LIKE :keyword or item_number=:item_number) and status=:status',
            'order' => 'name',
            'limit' => $limit,
            'params' => array(
                ':keyword' => "%$keyword%",
                ':item_number' => $keyword,
                ':status' => param('active_status')
            )
        ));
        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model->name . ' : ' . Yii::app()->settings->get('site', 'currencySymbol') . $model->unit_price, //. ' - ' . $model->quantity,
                // label for dropdown list
                'value' => $model->name,
                // value for input field
                'id' => $model->id,
                // return values from autocomplete
                'unit_price' => $model->unit_price,
                'quantity' => $model->quantity,
            );
        }

        return $suggest;
    }


    public function suggestRecv($keyword, $limit = 20)
    {
        $models = $this->findAll(array(
            'condition' => '(name LIKE :keyword or item_number=:item_number) and status=:status',
            'order' => 'name',
            'limit' => $limit,
            'params' => array(
                ':keyword' => "%$keyword%",
                ':item_number' => $keyword,
                ':status' => param('active_status')
            )
        ));
        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model->name . ' - ' . $model->cost_price . ' - ' . $model->quantity,
                // label for dropdown list
                'value' => $model->name,
                // value for input field
                'id' => $model->id,
                // return values from autocomplete
                'unit_price' => $model->unit_price,
                'quantity' => $model->quantity,
            );
        }

        return $suggest;
    }

    public function saveStockCount($interval)
    {
        $sql = "SELECT func_stock_count(:interval)";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':interval' => $interval,
            )
        );

        return $result;
    }

    public function stockItem($interval)
    {
        $sql1 = "SELECT item_id,`name`,quantity,null actual_qty,
                    date_format(modified_date,'%d-%m-%Y') count_datetime,
                    date_format(next_count_date,'%d-%m-%Y') next_count_date,upper(concat_ws(' - ',last_name,first_name)) employee
                   FROM item_count_schedule ic ,employee e 
                   WHERE e.id=ic.employee_id
                   AND count_interval=:interval";

        $rawData = Yii::app()->db->createCommand($sql1)->queryAll(true, array(':interval' => $interval));

        return $rawData;
    }

    public function stockItemDash()
    {
        $daily_qty = 0;
        $weeky_qty = 0;
        $biweekly_qty = 0;
        $monthly_qty = 0;
        $all_qty = 0;

        $sql = "SELECT
                        IFNULL(SUM(CASE WHEN count_interval=1 THEN nitem END),0) daily,
                        IFNULL(SUM(CASE WHEN count_interval=7 THEN nitem END),0) weekly,
                        IFNULL(SUM(CASE WHEN count_interval=14 THEN nitem END),0) biweekly,
                        IFNULL(SUM(CASE WHEN count_interval=14 THEN nitem END),0) monthly,
                        IFNULL(SUM(CASE WHEN count_interval=999 THEN nitem END),0) all_qty
                   FROM (
                           SELECT count_interval,COUNT(*) nitem
                           FROM item_count_schedule
                           WHERE DATE(next_count_date) = CURRENT_DATE()
                           GROUP BY count_interval
                           UNION ALL
                           SELECT 999,COUNT(*) nitem
                           FROM item_count_schedule
                           WHERE DATE(next_count_date) = CURRENT_DATE()
                   ) AS t1";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true);

        if ($result) {
            foreach ($result as $record) {
                $daily_qty = $record['daily'];
                $weeky_qty = $record['weekly'];
                $biweekly_qty = $record['biweekly'];
                $monthly_qty = $record['monthly'];
                $all_qty = $record['all_qty'];
            }
        }

        return array($daily_qty, $weeky_qty, $biweekly_qty, $monthly_qty, $all_qty);

    }

    public function saveItemCounSchedule($item_id)
    {
        $sql = "SELECT func_cu_item_schedule(:item_id)";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':item_id' => $item_id,
            )
        );

        return $result;
    }

    public static function getItemColumns() {
        return array(
            array(
                'name' => 'name',
                'value' => '$data->status=="1" ? CHtml::link($data->name, Yii::app()->createUrl("item/itemSearch",array("result"=>$data->primaryKey))) : "<s class=\"red\">  $data->name <span>" ',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'price',
                'value' => '$data->status=="1" ? $data->unit_price : "<s class=\"red\">  $data->unit_price <span>"',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'item_number',
                'value' => '$data->status=="1" ? $data->item_number : "<s class=\"red\">  $data->item_number <span>"',
                'type' => 'raw',
                'filter' => '',
            ),
            /*
            array(
                'name' => 'location',
                'value' => '$data->status=="1" ? $data->location : "<s class=\"red\">  $data->location <span>"',
                'type' => 'raw',
                'filter' => '',
            ),
            */
            array(
                'name' => 'category_id',
                'value' => '$data->category_id==null? " " : $data->category->name',
                //'filter' => CHtml::listData(Category::model()->findAll(array('order' => 'name')), 'id', 'name'),
                'filter' => '',
            ),
            array(
                'name' => 'quantity',
                'value' => '$data->status=="1" ? $data->quantity : "<s class=\"red\">  $data->quantity <span>"',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app','Action'),
                'template' => '<div class="hidden-sm hidden-xs btn-group">{detail}{cost}{price}{delete}{undeleted}{update}</div>',
                'buttons' => array(
                    'detail' => array(
                        'click' => 'updateDialogOpen',
                        'label' => Yii::t('app', 'Stock'),
                        'url' => 'Yii::app()->createUrl("Inventory/admin", array("item_id"=>$data->id))',
                        'options' => array(
                            'data-toggle' => 'tooltip',
                            'data-update-dialog-title' => 'Stock History',
                            'class' => 'btn btn-xs btn-pink',
                            'title' => 'Stock History',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.index") ',
                    ),
                    'cost' => array(
                        'click' => 'updateDialogOpen',
                        'label' => Yii::t('app', 'Cost'),
                        'url' => 'Yii::app()->createUrl("Item/CostHistory", array("item_id"=>$data->id))',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'Cost History'),
                            'class' => 'btn btn-xs btn-info',
                            'title' => 'Cost History',
                        ),
                        'visible' => '$data->status=="1"  && (Yii::app()->user->checkAccess("item.create") || Yii::app()->user->checkAccess("item.update") || Yii::app()->user->checkAccess("item.cost"))',
                    ),
                    'price' => array(
                        'click' => 'updateDialogOpen',
                        //'label'=>"<span class='text-info'>" . Yii::t('app','Price') . "</span><i class='icon-info-sign'></i> ",
                        'label' => Yii::t('app', 'Price'),
                        'url' => 'Yii::app()->createUrl("Item/PriceHistory", array("item_id"=>$data->id))',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'Price History'),
                            'class' => 'btn btn-xs btn-success',
                            'title' => 'Price History',
                        ),
                        'visible' => '$data->status=="1"  && (Yii::app()->user->checkAccess("item.create") || Yii::app()->user->checkAccess("item.update"))',
                    ),
                    'delete' => array(
                        'label' => Yii::t('app', 'Delete Item'),
                        'icon' => 'bigger-120 fa fa-trash',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Restore Item'),
                        'url' => 'Yii::app()->createUrl("Item/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'url' => 'Yii::app()->createUrl("Item/updateImage", array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn-xs btn-info',
                        ),
                        'visible' => '$data->status=="1"  && (Yii::app()->user->checkAccess("item.cost") || Yii::app()->user->checkAccess("item.update"))',
                    ),
                ),
            ),
        );
    }

    public static function getProduct2($name = '')
    {
        // Recommended: Secure Way to Write SQL in Yii
        $sql = "SELECT id ,name AS text 
                    FROM item 
                    WHERE (name LIKE :name)";

        $name = '%' . $name . '%';
        return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));
    }

    public function getNextId($id)
    {
        $record = self::model()->find(array(
            'condition' => 'id>:current_id',
            'order' => 'id ASC',
            'limit' => 1,
            'params' => array(':current_id' => $id),
        ));
        if ($record !== null)
            return $record->id;
        return null;
    }

    public function getPreviousId($id)
    {
        $record = self::model()->find(array(
            'condition' => 'id<:current_id',
            'order' => 'id DESC',
            'limit' => 1,
            'params' => array(':current_id' => $id),
        ));
        if ($record !== null)
            return $record->id;
        return null;
    }

    public function itemByCategory($category_id)
    {
        $sql = "SELECT i.id,i.name,i.description,i.cost_price,i.unit_price,
(SELECT filename image FROM item_image im WHERE im.item_id=i.id ORDER BY im.id ASC LIMIT 1) image
        FROM `item` i JOIN `category` c
        ON (i.category_id=c.id) 
        WHERE (c.id=:category_id  or c.parent_id=:category_id)";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':category_id' => (int)$category_id));

        return $result;
    }
    public function itemDetail($id){
        $sql = "SELECT i.id,i.name,i.description,i.cost_price,i.unit_price,i.quantity,b.name brand,s.company_name,c.name category,(SELECT filename image FROM item_image im WHERE im.item_id=i.id ORDER BY im.id ASC LIMIT 1) image
        FROM `item` i left join `brand` b
        on i.brand_id=b.id left join `supplier` s
        on i.supplier_id=s.id left join `category` c
        on i.category_id=c.id
        WHERE i.id=:id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':id' => (int)$id));

        return $result;
    }

}