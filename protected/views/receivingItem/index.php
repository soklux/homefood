<div id="register_container">

    <?php $this->renderPartial('//layouts/alert/' . sysNotificationType()); ?>

    <!--left.panel-->
    <?php $this->renderPartial('partial/_left_panel',
        array(
            'model' => $model,
            'trans_header' => $trans_header,
            'hide_editcost' => $hide_editcost,
            'hide_editprice' => $hide_editprice,
            'expiredate_class' => $expiredate_class,
            'items' => $items,
            'disable_discount' => $disable_discount,
            'discount_symbol' => $discount_symbol,
            'count_item' => $count_item,
        )); ?>
    <!--/left.panel-->

    <!--right.panel-->
    <?php $this->renderPartial('partial/_right_panel',
        array(
            'model' => $model,
            'supplier' => $supplier,
            'count_item' => $count_item,
            'trans_mode' => $trans_mode,
            'discount_amount' => $discount_amount,
            'total' => $total,
            'trans_header' => $trans_header,
        )); ?>
    <!--/right.panel-->

    <?php $this->renderPartial('partial/_js'); ?>

