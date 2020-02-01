<div class="row">


    <?php if (invIfSaleRep()) {  ?>

    <div class="col-xs-6">
        <p>
            <?php echo Yii::t('app','Cashier') . " : ". TbHtml::encode(ucwords($salerep_fullname)); ?> <br>
            <?php echo Yii::t('app','Customer') . " : ". TbHtml::encode(ucwords($cust_fullname)); ?> <br>
        </p>
    </div>

    <?php } ?>

    <div class="col-xs-6 col-xs-offset-0 text-right">
        <p>
            <?php echo TbHtml::encode(Yii::t('app','Invoice ID') . " : "  . $sale_id); ?> <br>
            <?php echo TbHtml::encode(Yii::t('app','Date') . " : ". $transaction_date . ' ' . $transaction_time); ?> <br>
        </p>
    </div>

    <table class="table" id="receipt_items">
        <thead>
        <tr>
            <th><?php echo Yii::t('app','Name'); ?></th>
            <th class="center"><?php echo Yii::t('app','Price'); ?></th>
            <th class="center" ><?php echo TbHtml::encode(Yii::t('app','Qty')); ?></th>
            <th class="<?php echo 'center' . ' ' . Yii::app()->settings->get('sale','discount'); ?>">
                <?php echo TbHtml::encode(Yii::t('app','Discount')); ?>
            </th>
            <th class="text-right"><?php echo TbHtml::encode(Yii::t('app','Total')); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $i=0; ?>
        <?php foreach(array_reverse($items,true) as $id=>$item): ?>
            <?php
            $i=$i+1;
            $discount_arr=Common::Discount($item['discount']);
            $discount_amt=$discount_arr[0];
            $discount_symbol=$discount_arr[1];
            if ($discount_symbol=='$') {
                $total_item=number_format($item['price']*$item['quantity']-$discount_amt,Common::getDecimalPlace());
            } else {
                $total_item=number_format($item['price']*$item['quantity']-$item['price']*$item['quantity']*$discount_amt/100,Common::getDecimalPlace());
            }
            ?>
            <tr>
                <td><?php echo TbHtml::encode($item['name']); ?></td>
                <td class="center"><?php echo TbHtml::encode(number_format($item['price'],Common::getDecimalPlace())); ?></td>
                <td class="center"><?php echo TbHtml::encode($item['quantity']); ?></td>
                <td class="<?php echo 'center' . ' ' . Yii::app()->settings->get('sale','discount'); ?>"><?php echo TbHtml::encode($item['discount']); ?></td>
                <td class="text-right"><?php echo TbHtml::encode($total_item); ?>
            </tr>
        <?php endforeach; ?> <!--/endforeach-->
        <tr class="gift_receipt_element">
            <td colspan="<?php echo $colspan; ?>" style='text-align:right;border-top:2px solid #000000;'><?php echo Yii::t('app','Sub Total'); ?></td>
            <td colspan="2" style='text-align:right;border-top:2px solid #000000;'> <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($sub_total,Common::getDecimalPlace(), '.', ','); ?></td>
        </tr>
        <tr class="gift_receipt_element">
            <td colspan="<?php echo $colspan; ?>" style='text-align:right;'><?php echo $total_discount . '% ' . Yii::t('app', 'Discount'); ?></td>
            <td colspan="2" style='text-align:right;'>
                <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount,Common::getDecimalPlace(), '.', ','); ?>
            </td>
        </tr>

        <tr class="gift_receipt_element">
            <td colspan="<?php echo $colspan; ?>" style='text-align:right;'><?php echo TbHtml::b(Yii::t('app','Total')); ?></td>
            <td colspan="2" style='text-align:right;'>
                            <span style="font-size:12px;font-weight:bold">
                            <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total,Common::getDecimalPlace(), '.', ','); ?>
                            <?php echo Yii::t('app','OR'); ?>
                            <?php echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($total_khr_round,0, '.', ','); ?>
                            </span>
            </td>
        </tr>

        <tr>
            <td colspan="<?php echo $colspan; ?>" style='text-align:right'><?php echo Yii::t('app','Change Due'); ?></td>
            <td colspan="2" style='text-align:right'>
                <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($amount_change,Common::getDecimalPlace(), '.', ','); ?>
                <?php echo Yii::t('app','OR'); ?>
                <?php echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_khr_round,0, '.' , ','); ?>
            </td>
        </tr>

        </tbody>
    </table>

    <div id="sale_return_policy"> <?php echo TbHtml::encode(Yii::t('app',Yii::app()->settings->get('site', 'returnPolicy'))); ?> </div>

</div>