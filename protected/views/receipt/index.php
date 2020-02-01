<style>
    #sale_return_policy {
        width: 80%;
        margin: 0 auto;
        text-align: center;
    }

    /*Receipt styles start*/
    #receipt_wrapper {
        font-family: Arial;
        width: 92% !important;
        font-size: 11px !important;
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

    .row-bordered:after {
        content: "";
        display: block;
        border-bottom: 2px solid #000000;
        margin: 0 15px;
    }

    .receipt-title-kh-font{
        font-family: 'khmer os';
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
    <?php if((isset($_GET['print'])  && $_GET['print'] == 'false') || !isset($_GET['print'])):?>
        <?php $this->renderPartial('//receipt/partial/_header_view_invoice',array(
            'sale_id'=>$sale_id,
            'customer_id'=>$customer_id,
            'paid_amount'=>isset($paid_amount) ? $paid_amount : 0,
            'status'=>isset($status) ? $status : Yii::app()->session['tran_type']
        ))?>
    <?php endif;?>
    
    <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/' . $invoice_header_view,
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
            'invoice_no_prefix' => $invoice_no_prefix,
            'receipt_header_title_kh' => $receipt_header_title_kh,
            'receipt_header_title_en' => $receipt_header_title_en,
            'payment_term' => $payment_term
        ));
    ?>

    <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/' . $invoice_header_body_view,
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
            'invoice_no_prefix' => $invoice_no_prefix,
            'payment_term' => $payment_term
        ));
    ?>

    <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/'  . $invoice_body_view,
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
            'invoice_no_prefix' => $invoice_no_prefix,
            'invoice_body_footer_view' => $invoice_body_footer_view,
            'gst_amount' => $gst_amount
        ));
    ?>

    <?php if ($invoice_body_footer_view !== null) { ?>

    <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/' . $invoice_footer_view,
        array(
            'sub_total' => $sub_total,
            'total' => $total,
            'total_discount' => $total_discount,
            'discount_amount' => $discount_amount,
            'cust_fullname' => $cust_fullname,
        ));
    ?>

    <?php } ?>
    <?php if(isset($_GET['print']) && $_GET['print'] == 'true'):?>
        <?php $this->renderPartial('//receipt/partial/_js'); ?>
    <?php endif;?>
