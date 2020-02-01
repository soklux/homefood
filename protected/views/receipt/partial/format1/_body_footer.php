<tbody>
<tr class="gift_receipt_element">
    <td colspan="4" style='text-align:left;border-top:2px solid #000000;'></td>
    <td colspan="" style='text-align:right;border-top:2px solid #000000;'><?= Yii::t('app','Sub Total'); ?></td>
    <td colspan="2" style='text-align:right;border-top:2px solid #000000;'> <?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($sub_total,Common::getDecimalPlace(), '.', ','); ?></td>
</tr>

<tr class="gift_receipt_element">
    <td colspan="4" style='text-align:left;'></td>
    <td colspan="<?php //echo $colspan; */ ?>" style='text-align:right;'><?= $total_discount . '%' . Yii::t('app', 'Discount');  ?></td>
    <td colspan="2" style='text-align:right;'>
        <?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount,Common::getDecimalPlace(), '.', ','); ?>
    </td>
</tr>

<tr class="gift_receipt_element">
    <td colspan="4" style='text-align:left;'></td>
    <td colspan="<?php //echo $colspan; */ ?>" style='text-align:right;'><?= TbHtml::b(Yii::t('app','Total'));  ?></td>
    <td colspan="2" style='text-align:right;'>
        <span style="font-size:12px;font-weight:bold">
        <?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($total,Common::getDecimalPlace(), '.', ','); ?>
        </span>
    </td>
</tr>
</tbody>