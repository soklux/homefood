<?php

class Dashboard extends CFormModel
{

    /***
     * Amount of sale specific day
     */
    public function totalSaleSPD($interval=0)
    {
        $sql = "SELECT IFNULL(SUM(sub_total),0) sale_amount
                FROM v_sale
                WHERE sale_time>=CURDATE() - :interval
                AND `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => Yii::app()->params['sale_complete_status'] ,  ':interval' => (int) $interval));

        foreach ($result as $record) {
            $result = $record['sale_amount'];
        }

        return number_format($result,Common::getDecimalPlace());
    }

    public function totalSale2Date($date_func)
    {
        if($date_func == ''){
            $where = "WHERE date(sale_time) = date(curdate()) and `status`=:status";
        }else if($date_func == 'WEEK'){
            $where = "WHERE date(sale_time) >= date(curdate())-6 and date(sale_time)<=date(curdate()) and `status`=:status";
        }else if($date_func == 'MONTH'){
            $where = "WHERE concat(YEAR(sale_time),$date_func(sale_time)) = concat(YEAR(curdate()),$date_func(curdate()))  and `status`=:status";
        }
        
        $sql = "SELECT IFNULL(SUM(sub_total),0) sale_amount
                FROM v_sale ".$where;

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => param('sale_complete_status')));

        foreach ($result as $record) {
            $result = $record['sale_amount'];
        }

        return number_format($result,Common::getDecimalPlace());
    }

    public function totalSale2Y()
    {
        $sql = "SELECT IFNULL(SUM(sub_total),0) sale_amount
                FROM v_sale
                WHERE YEAR(sale_time) = YEAR(CURDATE())
                AND `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => param('sale_complete_status')));

        foreach ($result as $record) {
            $result = $record['sale_amount'];
        }

        return number_format($result,Common::getDecimalPlace());
    }

    public function countCustomer()
    {
        $sql = "SELECT count(*) nCount
                FROM `client`
                WHERE `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' =>  Yii::app()->params['active_status']));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    

    public function count2dNewCust()
    {
        $sql = "SELECT count(*) nCount
                FROM `client`
                WHERE `status`=:status
                AND DATE(created_at)=DATE(NOW())";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => Yii::app()->params['active_status']));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    public function countStock($criteria)
    {
        $sql = "SELECT count(*) nCount
                FROM `item`
                WHERE quantity $criteria
                AND `status`=:status";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':status' => Yii::app()->params['active_status']));

        foreach ($result as $record) {
            $result = $record['nCount'];
        }

        return $result;
    }

    public function saleDailyChart()
    {
        $sql = "SELECT date_format(s.sale_time,'%d/%m/%y') date,sum(sub_total) sub_total,sum(sub_total-discount_amount) total
                FROM v_sale s
                WHERE ( s.sale_time BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
                AND s.status=:status
                GROUP BY date_format(s.sale_time,'%d/%m/%y')
                ORDER BY 1";

        return Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':status' => Yii::app()->params['sale_complete_status'],
        ));
    }

    public function topProduct()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,SUM(si.quantity) qty,SUM(price*si.quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id
                     AND sale_time between DATE_FORMAT(NOW() ,'%Y') AND NOW()
                     AND s.status=:status
                GROUP BY item_name
                ORDER BY qty DESC LIMIT 10
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':status' => Yii::app()->params['sale_complete_status'],
        ));

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

    public function dashtopProductbyAmount()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,item_name,qty,amount
                FROM (
                SELECT (SELECT NAME FROM item i WHERE i.id=si.item_id) item_name,SUM(si.quantity) qty,SUM(price*si.quantity) amount
                FROM sale_item si INNER JOIN sale s ON s.id=si.sale_id
                     AND sale_time between DATE_FORMAT(NOW() ,'%Y') AND NOW()
                     AND IFNULL(s.status,'1')='1'
                GROUP BY item_name
                ORDER BY amount DESC LIMIT 10
                ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true);

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

    public function dbBestCustomer()
    {

        $sql = "SELECT  @ROW := @ROW + 1 AS rank,customer_name,amount amount
                FROM (
                    SELECT CONCAT(c.first_name,' ',last_name) customer_name,SUM(s.sub_total) amount
                    FROM sale s ,`client` c
                    WHERE s.client_id = c.id
                    AND s.status=:status
                    GROUP BY customer_name
                    ORDER BY amount DESC LIMIT 10
                     ) t1, (SELECT @ROW := 0) r";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true,array( 'status'=> Yii::app()->params['active_status']));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'rank',
            /* 'sort' => array(
                 'attributes' => array(
                     'customer_name',
                 ),
             ),*/
            'pagination' => false,
        ));

        return $dataProvider;
    }

    public function dbAgedPurchase()
    {

        $sql = "SELECT ord,aged_purchase,sum(nclient) nclient
                FROM v_aged_customer_purchase
                GROUP BY ord,aged_purchase
                ORDER BY ord";

        return Yii::app()->db->createCommand($sql)->queryAll(true);
    }



}
