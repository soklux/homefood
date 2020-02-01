<style>
    #sale_return_policy {
        width: 80%;
        margin: 0 auto;
        text-align: center;
    }

    #receipt_wrapper {
        font-family: Arial;
        width: 98% !important;
        font-size: 13px !important;
        margin: 0 auto !important;
        padding: 0 !important;
    }

    #receipt_items td {
        //position: relative;
        padding: 3px;
    }

    @media print {
        body {
            position: relative;
        }

        #footer {
            position: fixed;
            bottom: 0;
            width:100%;
        }
    }
</style>

<?php
if (isset($error_message))
{
    echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $error_message);
    exit();
}
?>

<div class="container" id="receipt_wrapper">

    <?php $this->renderPartial('//receipt/partial/' . $receipt_header_view,
        array(
            'sale_id' => $sale_id,
			'cust_fullname' => $cust_fullname,
			'cust_address1' => $cust_address1,
			'cust_address2' => $cust_address2,
			'cust_mobile_no' => $cust_mobile_no,
			'cust_contact_fullname' => $cust_contact_fullname,
			'cust_fax' => $cust_fax,
            'transaction_date' => $transaction_date,
            'cust_notes' => $cust_notes,
            'salerep_fullname' => $salerep_fullname,
            'salerep_tel' => $salerep_tel,
            'invoice_no_prefix' => $invoice_no_prefix
        ));
    ?>

    <?php $this->renderPartial('//receipt/partial/' . $receipt_body_view,
        array(
            'salerep_fullname' => $salerep_fullname,
            'cust_fullname' => $cust_fullname,
            'sale_id' => $sale_id,
            'transaction_date' => $transaction_date,
            'transaction_time' => $transaction_time,
            'items' => $items,
            'colspan' => $colspan,
            'total_discount' => $total_discount,
            'discount_amount' => $discount_amount,
            'sub_total' => $sub_total,
            'total' => $total,
            'total_khr_round' => $total_khr_round,
            'amount_change' => $amount_change,
            'amount_change_khr_round' => $amount_change_khr_round,
            'cust_address1' => $cust_address1,
        ));
    ?>

    <?php if ($receipt_footer_view !== null) { ?>

        <?php $this->renderPartial('//receipt/partial/' . $receipt_footer_view,
            array(
                'sub_total' => $sub_total,
                'total' => $total,
                'total_discount' => $total_discount,
                'discount_amount' => $discount_amount,
                'cust_fullname' => $cust_fullname,
            ));
        ?>

    <?php } ?>

    <?php $this->renderPartial('//receipt/partial/_js'); ?>

</div>