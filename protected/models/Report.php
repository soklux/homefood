<?php

/**
 * This is the model class for table "sale".
 *
 * The followings are the available columns in table 'sale':
 * @property integer $id
 * @property string $sale_time
 * @property integer $customer_id
 * @property integer $employee_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $status
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property SaleItem[] $saleItems
 */
class Report extends CFormModel
{

    public $search;
    public $amount;
    public $quantity;
    public $from_date;
    public $to_date;
    public $sale_id;
    public $receive_id;
    public $employee_id;
    public $search_id;

    public $name;
    public $supplier;
    public $unit_price;
    public $cost_price;
    public $reorder_level;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('sale_time', 'required'),
            array('client_id, employee_id', 'numerical', 'integerOnly' => true),
            array('sub_total', 'numerical'),
            array('status', 'length', 'max' => 25),
            array('payment_type', 'length', 'max' => 255),
            array('sale_time', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('remark, sale_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sale_time, client_id, employee_id, sub_total, payment_type,status, remark', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'date' => Yii::t('app', 'date'),
            'supplier' => Yii::t('app', 'Supplier'),
        );
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        );
    }

    public function saleListByStatusUser($status='2',$user_id) {


        if ($this->search_id !== '') {
            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,'' payment_term
               FROM v_sale_invoice_2
               WHERE sale_id=:search_id
               AND status=:status
               AND created_by=:user_id
               AND (printeddo_by is NULL or printeddo_by is null)
               UNION ALL
               SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,'' payment_term
               FROM v_sale_invoice_2
               WHERE sale_id=:search_id
               AND status=:status
               AND created_by in (select id from employee where report_to=:user_id)
               AND (printeddo_by is NULL or printeddo_by is null)
               ORDER By sale_time desc";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':search_id' => $this->search_id,
                    ':status' => $status,
                    ':user_id' => $user_id)
            );

        } else {
            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,'' payment_term
               FROM v_sale_invoice_2
               -- WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
               -- AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               WHERE status=:status
               AND created_by=:user_id
               AND (printeddo_by is NULL or printeddo_by is null)
               UNION ALL
               SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,'' payment_term
               FROM v_sale_invoice_2
               -- WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
               -- AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               WHERE status=:status
               AND created_by in (select id from employee where report_to=:user_id)
               AND (printeddo_by is NULL or printeddo_by is null)
               ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                    ':status' => $status,
                    ':user_id' => $user_id)
            );
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleListByStatus($status='2')
    {

        if ($this->search_id !== '') {
            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,'' payment_term
               FROM v_sale_invoice_2
               -- WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
               -- AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               WHERE status=:status
               AND (printeddo_by is NULL or printeddo_by is null)
               ORDER By sale_time desc";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                    ':status' => $status)
            );
        } else {
            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,'' payment_term
               FROM v_sale_invoice_2
               -- WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
               -- AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               WHERE status=:status
               AND (printeddo_by is NULL or printeddo_by is null)
               ORDER By sale_time desc";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                    ':status' => $status)
            );
        }



        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleListAll() {
        $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,'' payment_term
               FROM v_sale_invoice_2
               WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
               AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               AND printeddo_by is null
               ORDER By sale_time desc";


        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':from_date' => $this->from_date,
                ':to_date' => $this->to_date,
               )
        );

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleCountByStatus($status='1')
    {
        $n_count=0;

        $sql = "SELECT count(*) n_count
               FROM sale
               WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
               AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               AND status=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':from_date' => $this->from_date,
                ':to_date' => $this->to_date,
                ':status' => $status)
        );

        foreach ($result as $record) {
            $n_count = $record['n_count'];
        }

        return $n_count;
    }

    public function saleInvoiceApp()
    {

        if ($this->search_id !== '') {


            $sql = "SELECT sale_id,new_id new_sale_id,sale_time,client_name,remark,0 current_balance,
                        employee_name,employee_id,client_id,quantity,sub_total,
                        discount_amount,vat_amount,total,paid,balance,status,status_f,
                        payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                    FROM v_sale_invoice_2
                    WHERE (sale_id=:search_id OR (c_first_name like :first_name OR c_last_name like :last_name OR client_name like :full_name ))
                    and status=:sale_validate_status
                    and client_status=:completed_customer
                    ORDER By sale_time desc";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':search_id' => $this->search_id,
                    ':first_name' => '%' . $this->search_id . '%',
                    ':last_name' => '%' . $this->search_id . '%',
                    ':full_name' => '%' . $this->search_id . '%',
                    ':sale_validate_status' => param("sale_validate_status"),
                    ':completed_customer' => param("create_customer_complete_status"))
            );

        } else {

            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,remark,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,
                      payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                   FROM v_sale_invoice_2
                   WHERE status=:sale_validate_status
                   and client_status=:completed_customer
                   ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':sale_validate_status' => param("sale_validate_status"),
                    ':completed_customer' => param("create_customer_complete_status"))
            );
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleInvoiceHis()
    {

        if ($this->search_id !== '') {

            $sql = "SELECT sale_id,new_id new_sale_id,sale_time,client_name,remark,0 current_balance,
                        employee_name,employee_id,client_id,quantity,sub_total,
                        discount_amount,vat_amount,total,paid,balance,status,status_f,
                        payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                    FROM v_sale_invoice_2
                    WHERE (sale_id=:search_id OR (c_first_name like :first_name OR c_last_name like :last_name OR client_name like :full_name ))
                    ORDER By sale_time desc";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':search_id' => $this->search_id,
                    ':first_name' => '%' . $this->search_id . '%',
                    ':last_name' => '%' . $this->search_id . '%',
                    ':full_name' => '%' . $this->search_id . '%',
                    //':sale_validate_status' => param("sale_validate_status"),
                    //':completed_customer' => param("create_customer_complete_status")
                  )
            );

        } else {

            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,remark,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,
                      payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                   FROM v_sale_invoice_2
                   WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                   AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                   ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':from_date' => $this->from_date,
                ':to_date' => $this->to_date,)
            );
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleInvoice()
    {

        if ($this->search_id !== '') {


            $sql = "SELECT sale_id,new_id new_sale_id,sale_time,client_name,remark,0 current_balance,
                        employee_name,employee_id,client_id,quantity,sub_total,
                        discount_amount,vat_amount,total,paid,balance,status,status_f,
                        payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                    FROM v_sale_invoice_2
                    WHERE (
                           sale_id=:search_id OR 
                           (c_first_name like :first_name OR c_last_name like :last_name OR client_name like :full_name )
                      )
                    -- and status=:sale_submit_status
                    -- and client_status=:completed_customer
                    ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':search_id' => $this->search_id,
                    ':first_name' => '%' . $this->search_id . '%',
                    ':last_name' => '%' . $this->search_id . '%',
                    ':full_name' => '%' . $this->search_id . '%'
                    //':sale_submit_status' => param("sale_submit_status"),
                    //':completed_customer' => param("create_customer_complete_status")
                )
            );

        } else {

            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,remark,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,
                      payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                   FROM v_sale_invoice_2
                   WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                   AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                   ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                    //':sale_submit_status' => param("sale_submit_status"),
                    //':completed_customer' => param("create_customer_complete_status")
                )
            );
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function SaleDelivery()
    {

        if ($this->search_id !== '') {

            $sql = "SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                        employee_name,employee_id,client_id,quantity,sub_total,
                        discount_amount,vat_amount,total,paid,balance,status,status_f,
                        payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                    FROM v_sale_invoice_2
                    WHERE status=:approved 
                     and (sale_id=:search_id OR (c_first_name like :first_name OR c_last_name like :last_name OR client_name like :full_name ))
                    ORDER By sale_time desc";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':search_id' => $this->search_id,
                    ':first_name' => '%' . $this->search_id . '%',
                    ':last_name' => '%' . $this->search_id . '%',
                    ':full_name' => '%' . $this->search_id . '%',
                    ':approved'=>param("sale_complete_status"))
            );

        } else {

            $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,
                      payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                   FROM v_sale_invoice_2
                   WHERE status=:approved
                   and sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                   AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                   ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                    ':approved'=>param("sale_complete_status"))
            );
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleInvoiceDetail()
    {
        $sql= "SELECT sale_id,item_id,name,quantity,price,description,sub_total
               FROM v_sale_item
               WHERE sale_id=:sale_id";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => $this->sale_id));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function allSaleInvoiceDetail($clientId)
    {
        $sql= "SELECT sale_id,new_id new_sale_id,sale_time,client_name,remark,0 current_balance,
                      employee_name,employee_id,client_id,quantity,sub_total,
                      discount_amount,vat_amount,total,paid,balance,status,status_f,
                      payment_term,validate_by,approve_by,checked_at, reviewed_at, printeddo_at, printed_at
                   FROM v_sale_invoice_2
                   WHERE client_id=:client_id

                   ORDER By sale_time desc";


            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':client_id' => $clientId,
            ));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_id', 'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleInvoiceAlert()
    {

        if (isset($this->sale_id)) {
            $sql = "SELECT s.id,
                             date_format(s.sale_time,'%d-%m-%Y %H-%i') sale_time,sum(quantity) quantity,
                             sum(
                             case 
                                when discount_type='%' then (quantity*price-(quantity*price*discount_amount)/100) 
                                else (quantity*price)-discount_amount
                             end) amount, 
                             (SELECT CONCAT_WS(' ',first_name,last_name) FROM `client` c WHERE c.id=s.client_id) customer_id,
                             (SELECT concat_ws(' ',first_name,last_name) from employee e where e.id=s.employee_id) employee_id,
                             remark
                       FROM sale s INNER JOIN sale_item si ON si.`sale_id`=s.id 
                       WHERE s.id=:sale_id
                       AND IFNULL(s.status,'1')='1'
                       GROUP BY s.id,date_format(s.sale_time,'%d-%m-%Y %H-%i')";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':sale_id' => $this->sale_id));
        } else {
            $sql = "SELECT id,sale_time,quantity,sub_total,amount,customer_id,employee_id,remark
                      FROM (
                      SELECT s.id,
                             date_format(s.sale_time,'%d-%m-%Y %H-%i') sale_time,sum(quantity) quantity,
                             sub_total,
                             sum(
                             case 
                                when discount_type='%' then (quantity*price-(quantity*price*discount_amount)/100) 
                                else (quantity*price)-discount_amount
                             end) amount,
                             (SELECT CONCAT_WS(' ',first_name,last_name) FROM `client` c WHERE c.id=s.client_id) customer_id,
                             (SELECT concat_ws(' ',first_name,last_name) from employee e where e.id=s.employee_id) employee_id,
                             remark
                       FROM sale s INNER JOIN sale_item si ON si.`sale_id`=s.id 
                       WHERE s.sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                       AND IFNULL(s.status,'1')='1'
                       AND s.sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                       GROUP BY s.id,date_format(s.sale_time,'%d-%m-%Y %H-%i')
                       ) as T1
                       WHERE sub_total<>amount";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'sale_time', 'amount',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function receiveInvoice()
    {

        if (isset($this->receive_id)) {
            
            $sql="SELECT s.id,
                    DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i') receive_time,
                    SUM(sub_total) sub_total,SUM(quantity) quantity,`status`,remark,
                    (SELECT CONCAT_WS(' ',first_name,last_name) FROM employee e WHERE e.id=s.employee_id) employee_id
               FROM v_receiving s , v_receiving_item_sum si 
               WHERE si.`receive_id`=s.id 
               AND s.id=:receive_id
               GROUP BY s.id,DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i'),`status`,remark
               ";
            
            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':receive_id' => $this->receive_id));
        } else {
          
            $sql="SELECT s.id,
                    DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i') receive_time,
                    SUM(sub_total) sub_total,SUM(quantity) quantity,`status`,remark,
                    (SELECT CONCAT_WS(' ',first_name,last_name) FROM employee e WHERE e.id=s.employee_id) employee_id
               FROM v_receiving s , v_receiving_item_sum si 
               WHERE si.`receive_id`=s.id 
               AND s.receive_time>=str_to_date(:from_date,'%d-%m-%Y') 
               AND s.receive_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               GROUP BY s.id,DATE_FORMAT(s.receive_time,'%d-%m-%Y %H-%i'),`status`,remark
               ";
            
            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'receive_time', 'sub_total',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleDaily()
    {
        $sql = "SELECT DATE_FORMAT(sale_time,'%d-%m-%Y') date_report,
               SUM(sub_total) sub_total,
               SUM(discount_amount) discount_amount,
               SUM(vat_amount) vat_amount,
	           SUM(total) total,
	           SUM(quantity) quantity
	           FROM v_sale_invoice
	           WHERE sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y')
               AND sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               AND status=:status
               GROUP BY date_format(sale_time,'%d-%m-%Y') WITH ROLLUP";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=> Yii::app()->params['active_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'date_report',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleDailyTotals()
    {
        $sub_total=0;
        $discount_amount=0;
        $total=0;
        $quantity=0;
        
        $sql="SELECT SUM(s.sub_total) sub_total,
                      SUM(s.discount_amount) discount_amount,
                      SUM(s.sub_total-s.discount_amount) total,
                      SUM(sm.quantity) quantity
            FROM v_sale s, v_sale_item_sum sm
            WHERE s.id=sm.sale_id 
            AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
            AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
            AND s.status=:status
            GROUP BY date_format(s.sale_time,'%d-%m-%Y')";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=>Yii::app()->params['active_status']));

        foreach ($result as $record) {
            $sub_total = $record['sub_total'];
            $total = $record['total'];
            $discount_amount = $record['discount_amount'];
            $quantity = $record['quantity'];
        }

        return array($quantity,$sub_total,$discount_amount,$total);
    }

    public function saleHourly()
    {
        $sql = "SELECT DATE_FORMAT(s.`sale_time`,'%H') hours,sum(si.quantity) qty,
                  sum(case 
                    when si.discount_type='%' then (si.quantity*price-(si.quantity*price*si.discount_amount)/100) 
                    else (si.quantity*price)-si.discount_amount
                  end) amount  
                  FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id AND IFNULL(s.status,'1')='1'
                            AND DATE_FORMAT(sale_time,'%d-%m-%Y')=str_to_date(:to_date,'%d-%m-%Y')
                  GROUP BY DATE_FORMAT(s.`sale_time`,'%H')";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'hours',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleHourlyTotalAmount()
    {
        $sql = "SELECT sum(case 
                                when si.discount_type='%' then (quantity*price-(quantity*price*si.discount_amount)/100) 
                                else (quantity*price)-si.discount_amount
                         end) amount
                  FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id AND IFNULL(s.status,'1')='1'
                  AND DATE_FORMAT(sale_time,'%d-%m-%Y')=str_to_date(:to_date,'%d-%m-%Y')
                  ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':to_date' => $this->to_date));

        foreach ($result as $record) {
            $amount = $record['amount'];
        }

        return $amount;
    }

    public function saleHourlyTotalQty()
    {
        $sql = "SELECT sum(quantity) qty
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id  AND IFNULL(s.status,'1')='1'
                AND DATE_FORMAT(sale_time,'%d-%m-%Y')=str_to_date(:to_date,'%d-%m-%Y')";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':to_date' => $this->to_date));

        foreach ($result as $record) {
            $qty = $record['qty'];
        }

        return $qty;
    }

    public function saleSummary()
    {

        $sql = "SELECT COUNT(id) no_of_invoice,SUM(sm.quantity) quantity,SUM(s.sub_total) sub_total,SUM(s.discount_amount) discount_amount,SUM(s.sub_total-s.discount_amount) total
                FROM v_sale s , v_sale_item_sum sm
                WHERE s.id=sm.sale_id 	
                AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
                AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                AND s.status=:status";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=>Yii::app()->params['active_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'no_of_invoice',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function profitDailySum()
    {
        
        $sql ="SELECT date_report,
                 SUM(sub_total) sub_total,SUM(discount_amount) discount_amount,
                 SUM(vat_amount) vat_amount,SUM(total) total,SUM(profit) cross_profit,
                 SUM(profit - discount_amount) profit,
                 SUM(FORMAT(((profit - discount_amount)/total)*100,2)) margin
              FROM (
                SELECT DATE_FORMAT(s.`sale_time`,'%d-%m-%Y') date_report,
                  SUM(s.sub_total) sub_total,
                  SUM(s.discount_amount) discount_amount,
                  SUM(s.vat_amount) vat_amount,
                  SUM(s.total) total,
                  SUM(sm.profit) profit
                FROM v_sale s , v_sale_item_sum sm
                WHERE s.id=sm.sale_id 
                AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
                AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                AND s.status=:status
                GROUP BY DATE_FORMAT(s.`sale_time`,'%d-%m-%Y')
             ) as t
             GROUP BY date_report WITH ROLLUP";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=>Yii::app()->params['active_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'date_report',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function profitByInvoice()
    {

        $sql ="SELECT sale_id,date_report,sub_total,discount_amount,vat_amount,total,
                 profit cross_profit,
                (profit - discount_amount) profit,
                format(((profit - discount_amount)/total)*100,2) margin
              FROM (
                SELECT s.id sale_id,DATE_FORMAT(s.`sale_time`,'%d-%m-%Y') date_report,
                  SUM(s.sub_total) sub_total,
                  SUM(s.discount_amount) discount_amount,
                  SUM(s.vat_amount) vat_amount,
                  SUM(s.total) total,
                  SUM(sm.profit) profit
                FROM v_sale s , v_sale_item_sum sm
                WHERE s.id=sm.sale_id
                AND DATE(s.sale_time)=STR_TO_DATE(:from_date,'%d-%m-%Y')
                AND s.status=:status
                GROUP BY s.id,DATE_FORMAT(s.`sale_time`,'%d-%m-%Y')
             ) as t";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date,':status'=>Yii::app()->params['active_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleDailyProfitTotals()
    {
        $sub_total = 0;
        $total = 0;
        $profit = 0;
        
        $sql ="SELECT SUM(s.sub_total) sub_total,SUM(s.sub_total-s.discount_amount) total,SUM(sm.profit) profit
               FROM v_sale s , v_sale_item_sum sm
               WHERE s.id=sm.sale_id 
               AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
               AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               AND s.status=:status";
    
        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=>Yii::app()->params['active_status']));

         foreach ($result as $record) {
            $sub_total = $record['sub_total'];
            $total = $record['total'];
            $profit = $record['profit'];
        }

        return array($sub_total,$total,$profit);
    }

    public function saleMonthlyProfit()
    {
         $sql ="SELECT DATE_FORMAT(s.`sale_time`,'%m-%Y') date_report,
	       SUM(s.sub_total) sub_total,SUM(sm.profit) profit,
               SUM(format((profit/sub_total)*100,2)) margin
            FROM v_sale s , v_sale_item_sum sm
            WHERE s.id=sm.sale_id 
            -- AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
            -- AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
            AND s.status=:status
            GROUP BY DATE_FORMAT(s.`sale_time`,'%m-%Y')";
        

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status'=>Yii::app()->params['active_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'date_report',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleMonthlyProfitTotals()
    {
        $sql ="SELECT SUM(s.sub_total) sub_total,SUM(s.sub_total-s.discount_amount) total,SUM(sm.profit) profit,SUM(format((profit/sub_total)*100,2))  margin
               FROM v_sale s , v_sale_item_sum sm
               WHERE s.id=sm.sale_id 
               AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y') 
               AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               AND s.status=:status";   

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status'=>Yii::app()->params['active_status']));

        foreach ($result as $record) {
            $sub_total = $record['sub_total'];
            $total = $record['total'];
            $profit = $record['profit'];
            $margin = $record['margin'];
        }
        return array($sub_total,$total,$profit, $margin);
    }

    public function payment()
    {

        $sql = "SELECT payment_type,COUNT(*) quantity,SUM(payment_amount) amount
                FROM sale_payment	
                WHERE sale_id IN (SELECT id FROM sale  WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY))
                GROUP BY payment_type";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'payment_type',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function paymentReceiveByEmployee() {

        $sql ="SELECT IFNULL(date_report,'Total') date_report,IFNULL(employee_name,'Total') employee_name,payment_amount,give_away
             FROM (
               SELECT DATE_FORMAT(date_paid,'%d-%m-%Y %H-%i') date_report,CONCAT(emp_first_name,emp_last_name) employee_name,
               SUM(payment_amount) payment_amount,SUM(give_away) give_away
               FROM `v_payment_history`
               WHERE date_paid>=STR_TO_DATE(:from_date,'%d-%m-%Y')
               AND date_paid<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
               GROUP BY CONCAT(emp_first_name,emp_last_name),DATE_FORMAT(date_paid,'%d-%m-%Y %H-%i')
               WITH ROLLUP ) as t";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'date_report',
            'pagination' => false,
            /*
            'sort' => array(
                'attributes' => array(
                    'date_report',
                ),
            ),
            */
        ));

        return $dataProvider;
    }

    public function paymentTotalAmount()
    {
        $sql = "SELECT SUM(payment_amount) amount
                  FROM sale_payment	
                  WHERE sale_id IN (SELECT id FROM sale  WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                  AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY))
                  ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        foreach ($result as $record) {
            $amount = $record['amount'];
        }

        return $amount;
    }

    public function paymentTotalQty()
    {
        $sql = "SELECT COUNT(*) qty
                  FROM sale_payment	
                  WHERE sale_id IN (SELECT id FROM sale  WHERE sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                  AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY))
                  ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        foreach ($result as $record) {
            $qty = $record['qty'];
        }

        return $qty;
    }

    public function topItem()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,sum(si.quantity) qty,SUM(si.price*si.quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id 
                     AND sale_time>=str_to_date(:from_date,'%d-%m-%Y') 
                     AND sale_time<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                     AND IFNULL(s.status,'1')='1'
                GROUP BY item_name
                ORDER BY qty DESC LIMIT 5
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function inventory($filter)
    {

        if ($this->search_id !== '') {
            $sql ="SELECT t1.id,t1.name,t3.name category_name,t1.quantity,t1.cost_price,t1.unit_price,t1.reorder_level,GROUP_CONCAT(DISTINCT t2.company_name) supplier
                   FROM item t1 LEFT JOIN v_item_supplier t2
                        ON t2.item_id=t1.id LEFT JOIN category t3 on t3.id = t1.category_id
                   WHERE (t1.name like :search_id or t3.name like :search_id)
                   AND t1.status=:status
                   GROUP BY t1.id,t1.name,t1.quantity,t1.cost_price,t1.unit_price,t1.reorder_level,t3.name";

            $search_str = $this->search_id . '%';

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status' => Yii::app()->params['active_status'], ':search_id' => $search_str));
        } else {

            $condition = $this->inventoryFilter($filter);
            $sql ="SELECT t1.id,t1.name,t3.name category_name,t1.quantity,t1.cost_price,t1.unit_price,t1.reorder_level,GROUP_CONCAT(DISTINCT t2.company_name) supplier
                   FROM item t1 LEFT JOIN v_item_supplier t2
                        ON t2.item_id=t1.id LEFT JOIN category t3 on t3.id = t1.category_id
                   $condition
                   AND t1.status=:status
                   GROUP BY t1.id,t1.name,t1.quantity,t1.cost_price,t1.unit_price,t1.reorder_level,t3.name";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status' => Yii::app()->params['active_status']));

        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'quantity','name','category_name'
                ),
            ),
            'pagination' => true,
        ));

        return $dataProvider; // Return as array object
    }
    
    public function stockCount($interval)
    {
 
        if ($interval=='all') {
            $sql="SELECT id,`name`,quantity 
                  FROM item
                  WHERE status=:status";
            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status'=>$this->item_active));
        } else {
            $sql="SELECT i.id,i.`name`,i.quantity,null actual_qty,
                    date_format(ic.modified_date,'%d-%m-%Y') modified_date,
                    date_format(ic.next_count_date,'%d-%m-%Y') next_count_date,
                    upper(concat_ws(' - ',last_name,first_name)) employee
                  FROM item i,item_count_schedule ic,employee e 
                  WHERE i.id=ic.item_id 
                  AND i.status=:status 
                  AND e.id=ic.employee_id
                  AND ic.count_interval=:interval
                  -- AND DATE(ic.next_count_date) = CURRENT_DATE()";
            
            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':interval'=>$interval,':status'=>$this->item_active));
        }
        
        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'id',
            'sort' => array(
                'attributes' => array(
                    'quantity',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }
   
    public function itemExpiry($filter)
    {
        $sql = "SELECT name,total_qty,quantity,expire_date,n_month_expire
                FROM v_item_expire
                WHERE n_month_expire <= :month_to_expire
                ORDER BY n_month_expire";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':month_to_expire' => $filter));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'name',
            'sort' => array(
                'attributes' => array(
                    'name',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function itemExpiryCount($moth_to_expire)
    {
        $sql = "SELECT count(*) nitem,ifnull(sum(quantity),0) qty
                  FROM (
                    SELECT ie.`receiving_id`,
                            (SELECT receive_time FROM receiving r WHERE r.id=ie.receiving_id) received,
                            i.`name`,
                            i.`quantity`,
                            ie.`expire_date`,EXTRACT(YEAR_MONTH  FROM ie.expire_date) month_expire,
                            PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM ie.expire_date),EXTRACT(YEAR_MONTH FROM CURRENT_DATE())) n_month_expire
                     FROM `item_expire` ie  INNER JOIN item i ON ie.`item_id`=i.`id`
                    ) AS t1
                 WHERE n_month_expire=:month_to_expire";
        //GROUP BY month_expire,n_month_expire";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':month_to_expire' => $moth_to_expire));

        foreach ($result as $record) {
            $result = array($record['nitem'], $record['qty']);
        }

        return $result;
    }

    public function itemAsset()
    {
        $sql = "SELECT SUM(quantity) total_qty,SUM(cost_price*quantity) total_amount
                  FROM item
                  WHERE quantity>0
                  and status=:status";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(":status"=>$this->item_active));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'total_qty',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function itemInactive($filter)
    {

        if ($filter == 1) {
            $con = 'between 3 and 6';
        } elseif ($filter == 2) {
            $con = 'between 7 and 12';
        } elseif ($filter == 3) {
            $con = '>=12';
        }

        $sql = "SELECT PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM CURRENT_DATE()),EXTRACT(YEAR_MONTH FROM sale_time)) month_diff,
                    sale_time,item_id,name,description,quantity
                 FROM (
                 SELECT s.sale_time,si.item_id,it.name,it.description,it.quantity
                 FROM sale s INNER JOIN sale_item si ON si.`sale_id`=s.id 
                         INNER JOIN item it ON it.id=si.item_id        
                 UNION ALL
                 SELECT created_date sale_tie,id item_id,`name`,description,quantity
                 FROM item
                 WHERE id NOT IN (SELECT DISTINCT item_id FROM sale_item)
                 ) t1
                 WHERE PERIOD_DIFF(EXTRACT(YEAR_MONTH  FROM CURRENT_DATE()),EXTRACT(YEAR_MONTH FROM sale_time)) $con
                 ORDER BY NAME";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':month_to_expire' => $filter));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'month_diff',
            'sort' => array(
                'attributes' => array(
                    'name',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleDailyChart()
    {
        $sql = "SELECT date_format(s.sale_time,'%d/%m%y') date,sum(quantity) quantity,
                   SUM(case when si.discount_type='%' then (quantity*price-(quantity*price*si.discount_amount)/100) 
                                else (quantity*price)-si.discount_amount
                    end) amount
                   FROM sale s INNER JOIN sale_item si ON si.sale_id=s.id 
                   WHERE ( s.sale_time between DATE_FORMAT(NOW() ,'%Y-%m-01') and NOW() )
                   AND IFNULL(s.status,'1')='1'
                   GROUP BY date_format(s.sale_time,'%d/%m/%y')
                   ORDER BY 1";

        return Yii::app()->db->createCommand($sql)->queryAll(true);
    }

    public function saleItemSummary()
    {
        $sql="SELECT i.name item_name,CONCAT_WS(' - ', from_date, to_date) date_report,sub_total,t1.quantity,profit
            FROM (
            SELECT sm.item_id,MIN(DATE_FORMAT(s.sale_time,'%d-%m-%Y')) from_date, MAX(DATE_FORMAT(s.sale_time,'%d-%m-%Y')) to_date,
                  SUM(sm.quantity) quantity,SUM(sm.price*sm.quantity) sub_total,sum((sm.price-sm.cost_price) * sm.quantity) profit
            FROM v_sale s , sale_item sm
            WHERE s.id=sm.sale_id
            AND s.sale_time>=str_to_date(:from_date,'%d-%m-%Y')  
            AND s.sale_time<date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY) 
            AND s.status=:status
            GROUP BY sm.item_id
            ) t1 JOIN item i ON i.id=t1.item_id";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=>Yii::app()->params['sale_complete_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'item_name',
            'sort' => array(
                'attributes' => array(
                    'date_report',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }
    
    public function userLogSummary()
    {  
        $sql="SELECT ul.`employee_id`,
                UCASE(CONCAT(e.`first_name`,' ',e.`last_name`)) fullname,
                DATE_FORMAT(`login_time`,'%d-%m-%Y') date_log,
                COUNT(*) nlog
            FROM `user_log` ul , employee e
            WHERE ul.`employee_id`=e.`id`
            AND ul.login_time>=str_to_date(:from_date,'%d-%m-%Y')  
            AND ul.login_time<date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
            GROUP BY ul.`employee_id`,CONCAT(e.`first_name`,' ',e.`last_name`),DATE_FORMAT(`login_time`,'%d-%m-%Y')";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'employee_id',
            'sort' => array(
                'attributes' => array(
                    'date_log',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    /* To view all outstanding invoices */
    public function outstandingInvoice()
    {

        if ($this->search_id !== '') {
            $sql = "SELECT t1.client_id,t1.client_name,t1.invoices,t1.balance,MAX(date_paid) last_payment,CONCAT(DATEDIFF(CURDATE(),MAX(date_paid)), ' days ago') days
                FROM v_outstanding_inv t1 LEFT JOIN payment_history t2 ON t1.client_id = t2.client_id
                WHERE t1.first_name like :search_id or t1.last_name like :search_id
                GROUP BY t1.client_id,t1.client_name,t1.invoices,t1.balance";

            $client_name = $this->search_id . '%';
            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':search_id' => $client_name));

        } else {

            $sql = "SELECT t1.client_id,t1.client_name,t1.invoices,t1.balance,MAX(date_paid) last_payment,CONCAT(DATEDIFF(CURDATE(),MAX(date_paid)), ' days ago') days
                FROM v_outstanding_inv t1 LEFT JOIN payment_history t2 ON t1.client_id = t2.client_id
                GROUP BY t1.client_id,t1.client_name,t1.invoices,t1.balance";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'client_id',
            'sort' => array(
                'attributes' => array(
                    'balance',
                    'last_payment',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleSummaryBySaleRep()
    {
        if ($this->employee_id == '') {
            $sql = "SELECT CONCAT(e.`last_name`,' ',e.`first_name`)  sale_rep,
                  COUNT(s.id) no_of_invoice,SUM(sm.quantity) quantity,SUM(s.sub_total) sub_total,SUM(s.discount_amount) discount_amount,SUM(s.sub_total-s.discount_amount) total
                FROM v_sale s , v_sale_item_sum sm , employee e
                WHERE s.id=sm.sale_id
                AND e.id = s.`employee_id`
                AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y')
                AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                AND s.status=:status
                GROUP BY CONCAT(e.`last_name`,' ',e.`first_name`)";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                    ':status' => Yii::app()->params['active_status'],
                )
            );

        } else {

            $sql = "SELECT CONCAT(e.`last_name`,' ',e.`first_name`)  sale_rep,
                   COUNT(s.id) no_of_invoice,SUM(sm.quantity) quantity,SUM(s.sub_total) sub_total,SUM(s.discount_amount) discount_amount,SUM(s.sub_total-s.discount_amount) total
                FROM v_sale s , v_sale_item_sum sm , employee e
                WHERE s.id=sm.sale_id
                AND e.id = s.`employee_id`
                AND s.`employee_id` = :employee_id
                AND s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y')
                AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                AND s.status=:status
                GROUP BY CONCAT(e.`last_name`,' - ',e.`last_name`)";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':employee_id' => $this->employee_id,
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                    ':status' => Yii::app()->params['active_status'],
                )
            );
        }


        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'sale_rep',
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }
	
	public function saleItemSumyCust()
    {
        $sql="SELECT i.`name` item_name, CONCAT( c.`first_name`,' ', last_name) client_name,
                   SUM(si.`quantity`) quantity, SUM(si.`quantity`*si.`price`) amount
                FROM sale s JOIN sale_item si ON si.`sale_id` = s.id
                 JOIN `client` c ON c.`id` = s.`client_id`
                   JOIN item i ON i.id = si.`item_id`
                WHERE s.sale_time>=str_to_date(:from_date,'%d-%m-%Y')
                AND s.sale_time<date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
                AND s.status=:status
                GROUP BY client_name,item_name
                ORDER BY item_name";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=>Yii::app()->params['sale_complete_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'item_name',
            'sort' => array(
                'attributes' => array(
                    'item_name',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function saleWeeklyByCustomer() {
        $sql="SELECT client_name,item_name,
             SUM(CASE WHEN week_no=3 THEN amount END) '1',
             SUM(CASE WHEN week_no=3 THEN amount END) '2',
             SUM(CASE WHEN week_no=3 THEN amount END) '3',
             SUM(CASE WHEN week_no=4 THEN amount END) '4',
             SUM(CASE WHEN week_no=5 THEN amount END) '5',
             SUM(CASE WHEN week_no=6 THEN amount END) '6',
             SUM(CASE WHEN week_no=7 THEN amount END) '7',
             SUM(CASE WHEN week_no=8 THEN amount END) '8',
             SUM(CASE WHEN week_no=9 THEN amount END) '9',
             SUM(CASE WHEN week_no=10 THEN amount END) '10',
             SUM(CASE WHEN week_no=11 THEN amount END) '11',
             SUM(CASE WHEN week_no=12 THEN amount END) '12',
             SUM(CASE WHEN week_no=13 THEN amount END) '13',
             SUM(CASE WHEN week_no=14 THEN amount END) '14',
             SUM(CASE WHEN week_no=15 THEN amount END) '15',
             SUM(CASE WHEN week_no=16 THEN amount END) '16',
             SUM(CASE WHEN week_no=17 THEN amount END) '17',
             SUM(CASE WHEN week_no=18 THEN amount END) '18',
             SUM(CASE WHEN week_no=19 THEN amount END) '19',
             SUM(CASE WHEN week_no=20 THEN amount END) '20',
             SUM(CASE WHEN week_no=21 THEN amount END) '21',
             SUM(CASE WHEN week_no=22 THEN amount END) '22',
             SUM(CASE WHEN week_no=23 THEN amount END) '23',
             SUM(CASE WHEN week_no=24 THEN amount END) '24',
             SUM(CASE WHEN week_no=25 THEN amount END) '25',
             SUM(CASE WHEN week_no=26 THEN amount END) '26',
             SUM(CASE WHEN week_no=27 THEN amount END) '27',
             SUM(CASE WHEN week_no=28 THEN amount END) '28',
             SUM(CASE WHEN week_no=29 THEN amount END) '29',
             SUM(CASE WHEN week_no=30 THEN amount END) '30',
             SUM(CASE WHEN week_no=31 THEN amount END) '31',
             SUM(CASE WHEN week_no=32 THEN amount END) '32',
             SUM(CASE WHEN week_no=33 THEN amount END) '33',
             SUM(CASE WHEN week_no=34 THEN amount END) '34',
             SUM(CASE WHEN week_no=35 THEN amount END) '35',
             SUM(CASE WHEN week_no=36 THEN amount END) '36',
             SUM(CASE WHEN week_no=37 THEN amount END) '37',
             SUM(CASE WHEN week_no=38 THEN amount END) '38',
             SUM(CASE WHEN week_no=39 THEN amount END) '39',
             SUM(CASE WHEN week_no=40 THEN amount END) '40',
             SUM(CASE WHEN week_no=41 THEN amount END) '41',
             SUM(CASE WHEN week_no=42 THEN amount END) '42',
             SUM(CASE WHEN week_no=43 THEN amount END) '43',
             SUM(CASE WHEN week_no=44 THEN amount END) '44',
             SUM(CASE WHEN week_no=45 THEN amount END) '45',
             SUM(CASE WHEN week_no=46 THEN amount END) '46',
             SUM(CASE WHEN week_no=47 THEN amount END) '47',
             SUM(CASE WHEN week_no=48 THEN amount END) '48',
             SUM(CASE WHEN week_no=49 THEN amount END) '49',
             SUM(CASE WHEN week_no=50 THEN amount END) '50',
             SUM(CASE WHEN week_no=51 THEN amount END) '51',
             SUM(CASE WHEN week_no=52 THEN amount END) '52'
        FROM
        (
        SELECT
            CONCAT( c.`first_name`,' ', last_name) client_name,i.`name` item_name,
            WEEK(DATE(s.sale_time)) week_no,
            SUM(si.`quantity`) quantity, TRUNCATE(SUM(si.`quantity`*si.`price`),2) amount
        FROM v_sale s JOIN sale_item si ON si.`sale_id` = s.id
         JOIN `client` c ON c.`id` = s.`client_id`
           JOIN item i ON i.id = si.`item_id`
        WHERE  s.sale_time>=STR_TO_DATE(:from_date,'%d-%m-%Y')
        AND s.sale_time<=DATE_ADD(STR_TO_DATE(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
        AND s.status=:status
        GROUP BY WEEK(DATE(s.sale_time)),i.`name`,CONCAT( c.`first_name`,' ', last_name)
        ) AS t1
        GROUP BY client_name,item_name WITH ROLLUP";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':from_date' => $this->from_date, ':to_date' => $this->to_date,':status'=>Yii::app()->params['sale_complete_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'item_name',
            /*'sort' => array(
                'attributes' => array(
                    'item_name',
                ),
            ),*/
            'pagination' => false,
        ));

        return $dataProvider;
    }

    /**
     * @param $filter
     * @return string
     */
    protected function inventoryFilter($filter)
    {
        switch ($filter) {
            case 'all':
                $condition = '';
                break;
            case 'low':
                $condition = 'WHERE IFNULL(reorder_level,0)>quantity';
                break;
            case 'outstock':
                $condition = 'WHERE quantity=0';
                break;
            case 'onstock':
                $condition = 'WHERE quantity>0';
                break;
            case 'negative':
                $condition = 'WHERE quantity<0';
                break;
        }

        return $condition;
    }

    public function ListSuspendSale($sale_status)
    {

        $sql = "SELECT s.id sale_id,
                      CONCAT(c.first_name,' ',c.last_name) customer_name, s.client_id,
                      DATE_FORMAT(s.sale_time,'%d-%m-%Y %H:%i') sale_time,st.items,remark,s.status,
                      s.total,s.sub_total
                FROM v_sale s INNER JOIN (SELECT si.sale_id, GROUP_CONCAT(i.name) items
                                          FROM sale_item si INNER JOIN item i ON i.id=si.item_id 
                                          GROUP BY si.sale_id
                                          ) st ON st.sale_id=s.id
                     left join `client` c on c.`id` = s.`client_id`
                WHERE s.status=:status";

        $sql = "SELECT s.sale_id sale_id,
                      CONCAT(s.c_first_name,' ',s.c_last_name) customer_name, 
                      s.client_id,
                      DATE_FORMAT(s.sale_time,'%d-%m-%Y %H:%i') sale_time,st.items,s.status,s.status_f,
                      s.sub_total,s.total,s.discount_amount,s.vat_amount,
                      c.current_balance,s.balance
                FROM v_sale_invoice s INNER JOIN (SELECT si.sale_id, GROUP_CONCAT(i.name) items
                                          FROM sale_item si INNER JOIN item i ON i.id=si.item_id 
                                          GROUP BY si.sale_id
                                          ) st ON st.sale_id=s.sale_id
                         INNER JOIN account c on c.client_id = s.client_id
                     -- left join `client` c on c.`id` = s.`client_id`
                WHERE s.status=:status";


        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array(':status' => $sale_status));

        $dataProvider = new CArrayDataProvider($rawData, array(
            //'id'=>'saleinvoice',
            'keyField' => 'sale_id',
            'sort' => array(
                'attributes' => array(
                    'sale_time',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function commonData($grid_id,$title,$advance_search=null,$header_view='_header',$grid_view='_grid')
    {
        $report = new Report;

        $data['report'] = $report;
        $data['from_date'] = isset($_GET['Report']['from_date']) ? $_GET['Report']['from_date'] : date('d-m-Y');
        $data['to_date'] = isset($_GET['Report']['to_date']) ? $_GET['Report']['to_date'] : date('d-m-Y');
        $data['search_id'] = isset($_GET['Report']['search_id']) ? $_GET['Report']['search_id'] : '';
        $data['advance_search'] = $advance_search;
        $data['header_tab'] = '';

        $data['grid_id'] = $grid_id;
        $data['title'] = Yii::t('app', $title) . ' ' . Yii::t('app',
                'From') . ' ' . $data['from_date'] . '  ' . Yii::t('app', 'To') . ' ' . $data['to_date'];
        $data['header_view'] = $header_view;
        $data['grid_view'] = $grid_view;

        $data['report']->from_date = $data['from_date'];
        $data['report']->to_date = $data['to_date'];
        $data['report']->search_id = $data['search_id'];

        return $data;

    }

    public function ItemCountList()
    {

        if ($this->search_id !== '') {
            $sql= " select icd.count_id, ic.name, created_date counted_at, (select outlet_name from outlet o where o.id = ic.outlet_id) outlet,
             sum(expected) expected, sum(counted) counted, sum(unit) unit, sum(cost) cost
             from inventory_count ic join inventory_count_detail icd
             on ic.id = icd.count_id
             WHERE created_date = :search_id
             group by icd.count_id, ic.name, created_date, outlet_id";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':search_id' => $this->search_id,
                )
            );

        } else {
            $sql= " select icd.count_id, ic.name, created_date counted_at, 
             sum(expected) expected, sum(counted) counted, sum(unit) unit, sum(cost) cost
             from inventory_count ic join inventory_count_detail icd
             on ic.id = icd.count_id
             WHERE created_date>=str_to_date(:from_date,'%d-%m-%Y')
             AND created_date<=date_add(str_to_date(:to_date,'%d-%m-%Y'),INTERVAL 1 DAY)
             group by icd.count_id, ic.name, created_date";

            $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':from_date' => $this->from_date,
                    ':to_date' => $this->to_date,
                )
            );
        }

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'count_id',
            'sort' => array(
                'attributes' => array(
                    'count_id', 'counted_at',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object

    }

    public function getItemCountDetail($count_id)
    {
        $sql = "select io.id, incd.count_id,io.name,expected,counted,unit,cost
                 from inventory_count inc join inventory_count_detail incd
                 on inc.id = incd.count_id join item io
                 on incd.item_id = io.id
                 WHERE (incd.count_id = :count_id)";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':count_id' => $count_id));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'count_id',
            'sort' => array(
                'attributes' => array(
                    'count_id',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object

    }

    public function AgedCustomerPurchase($filter)
    {
        
        $sql = "SELECT vc.client_id, c.first_name fullname,vc.first_purchase_date,vc.last_purchase_date,vc.total, 
                vcpp.products,city.city_name, d.district_name
                FROM v_client_update vc INNER JOIN client c on c.id=vc.client_id 
                    LEFT JOIN city on c.city_id=city.id 
                    LEFT JOIN district d ON c.district_id=d.id 
                    INNER JOIN v_client_purchase_producs vcpp ON vc.client_id=vcpp.client_id
                WHERE vc.ord = :filter";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':filter' => $filter));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'client_id',
            'sort' => array(
                'attributes' => array(
                    'client_id',
                ),
            ),
            'pagination' => false,
        ));

        return $dataProvider; // Return as array object
    }

    public function renderStatus()
    {
        return "banners";
    }

    public static function getQuanityItemPurchased($clientId, $itemId){

        $sql = "SELECT SUM(s.`quantity`) q_item_purschase FROM `sale` s INNER JOIN sale_item si ON s.id=si.sale_id WHERE s.status=1 AND si.item_id=:item_id AND s.client_id=:client_id";
        
        $rawData = Yii::app()->db->createCommand($sql)->queryRow(true, array(':item_id'=>$itemId,':client_id' => $clientId));
        return $rawData['q_item_purschase'];
    }


}
