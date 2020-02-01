<!-- #right.panel -->
<div class="col-xs-12 col-sm-4 widget-container-col">

    <!-- #section:right.panel.header -->
    <?php /*$this->renderPartial('partial/_right_panel_header', array(
        'count_item' => $count_item,
    )); */?>
    <!-- #/section:right.panel.header -->

    <!-- #section:right.panel.client -->
    <?php $this->renderPartial('partial/_right_panel_client', array(
        'model' => $model,
        'customer' => $customer,
        'cust_fullname' => $cust_fullname,
        'customer_id' => $customer_id,
        'group_name'=>$group_name,
        'acc_balance' => $acc_balance,
        'sale_mode' => $sale_mode,
        'cust_term' => $cust_term,
    )); ?>
    <!-- #/section:right.panel.client -->

    <!-- To be refactoring here -->

    <?php if ($tran_type=='1') { ?>

        <!-- #section:right.panel.payment -->
        <?php $this->renderPartial('partial/_right_panel_payment', array(
            'model' => $model,
            'count_item' => $count_item,
            'total' => $total,
            'sub_total' => $sub_total,
            'total_khr_round' => $total_khr_round,
            'discount_amount' => $discount_amount,
            'total_gst' => $total_gst,
            'count_payment' => $count_payment,
            'total_due' => $total_due,
            'customer' => $customer,
            'payments' => $payments,
            'amount_change' => $amount_change,
            'amount_change_whole' => $amount_change_whole,
            'amount_change_fraction_khr' => $amount_change_fraction_khr,
            'amount_change_khr_round' => $amount_change_khr_round,
            'discount_symbol' => $discount_symbol,
            'discount_amt' => $discount_amt,
            'gst_amount' => $gst_amount,
            'sale_save_url' => $sale_save_url,
            'color_style' => $color_style,
        )); ?>
        <!-- #/section:right.panel.payment -->

    <?php } else { ?>

        <?php $this->renderPartial('partial/_right_panel_footer', array(
            'model' => $model,
            'count_item' => $count_item,
            'total' => $total,
            'sub_total' => $sub_total,
            'total_khr_round' => $total_khr_round,
            'discount_amount' => $discount_amount,
            'total_gst' => $total_gst,
            'count_payment' => $count_payment,
            'total_due' => $total_due,
            'customer' => $customer,
            'payments' => $payments,
            'amount_change' => $amount_change,
            'amount_change_whole' => $amount_change_whole,
            'amount_change_fraction_khr' => $amount_change_fraction_khr,
            'amount_change_khr_round' => $amount_change_khr_round,
            'discount_symbol' => $discount_symbol,
            'discount_amt' => $discount_amt,
            'gst_amount' => $gst_amount,
            'sale_save_url' => $sale_save_url,
            'color_style' => $color_style,
        )); ?>

    <?php } ?>

</div> <!-- /right.panel -->
