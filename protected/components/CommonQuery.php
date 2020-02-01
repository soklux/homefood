<?php
class CommonQuery
{

    public static function saleInvoice($compare_operator) {

        return  "SELECT sale_id,sale_time,client_name,quantity,sub_total,
                   discount_amount,vat_amount,total,paid,balance
                 FROM v_sale_outstanding
                 WHERE client_id=:client_id
                 AND balance $compare_operator 0
                 ORDER BY sale_time";

    }
}