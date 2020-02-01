<div id="footer">
    <div class="col-xs-12">
        <table class="table">
            <tbody>
            <tr class="gift_receipt_element">
                <td colspan="4" style='text-align:left;border-top:2px solid #000000;'></td>
                <td colspan="" style='text-align:right;border-top:2px solid #000000;'><?php echo Yii::t('app','Sub Total'); ?></td>
                <td colspan="2" style='text-align:right;border-top:2px solid #000000;'> <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($sub_total,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?></td>
            </tr>

            <tr class="gift_receipt_element">
                <td colspan="4" style='text-align:left;'></td>
                <td colspan="<?php //echo $colspan; */ ?>" style='text-align:right;'><?php echo $total_discount . '%' . Yii::t('app', 'Discount');  ?></td>
                <td colspan="2" style='text-align:right;'>
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                </td>
            </tr>

            <tr class="gift_receipt_element">
                <td colspan="4" style='text-align:left;'></td>
                <td colspan="<?php //echo $colspan; */ ?>" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','Total'));  ?></td>
                <td colspan="2" style='text-align:right;'>
                    <span style="font-size:12px;font-weight:bold">
                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total,Yii::app()->shoppingCart->getDecimalPlace(), '.', ','); ?>
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="space-6"></div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">Prepared By </div>
            <div class="col-xs-3">Authorized By </div>
            <!--<div class="col-xs-3">Account Process </div>-->
            <div class="col-xs-3">Delivered By </div>
            <div class="col-xs-3 align-right">Received By </div>
        </div>
        <div class="row">
            <div class="col-xs-10"></div>
            <div class="col-xs-2 align-right"><?php echo TbHtml::encode(ucwords($cust_fullname)); ?></div>
        </div>
    </div>
</div>
