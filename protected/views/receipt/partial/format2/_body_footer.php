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