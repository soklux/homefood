<div class="row">
    <div class="col-xs-12">
        <table class="table" id="receipt_items">
            <thead>
            <tr>
                <th><?= Yii::t('app','NO.'); ?></th>
                <th><?= Yii::t('app','Description'); ?></th>
                <th class="center" ><?= TbHtml::encode(Yii::t('app','QTY')); ?></th>
                <th class="center" ><?= TbHtml::encode(Yii::t('app','UOM')); ?></th>
                <th class="center"><?= Yii::t('app','PRICE'); ?></th>
                <th class="<?= 'center' . ' ' . Yii::app()->settings->get('sale','discount'); ?>">
                    <?= TbHtml::encode(Yii::t('app','Discount')); ?>
                </th>
                <th class="text-right"><?= TbHtml::encode(Yii::t('app','AMOUNT')); ?></th>
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
                        $total_item=number_format($item['price']*$item['quantity']-$item['price']*$item['quantity']*$discount_amt/100,common::getDecimalPlace());
                    }
                ?>
                <tr>
                    <td><?= TbHtml::encode($i); ?></td>
                    <td><?= TbHtml::encode($item['name']); ?></td>
                    <td class="center"><?= TbHtml::encode($item['quantity']); ?></td>
                    <td class="center"><?= TbHtml::encode($item['unit_measurable']); ?></td>
                    <td class="center"><?= TbHtml::encode(number_format($item['price'],Common::getDecimalPlace())); ?></td>
                    <td class="<?= 'center' . ' ' . Yii::app()->settings->get('sale','discount'); ?>">
                        <?= TbHtml::encode($item['discount']); ?></td>
                    <td class="text-right"><?= TbHtml::encode($total_item); ?>
                </tr>
            <?php endforeach; ?>

            <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/'  . $invoice_body_footer_view,
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
                    'invoice_no_prefix' => $invoice_no_prefix
                ));
            ?>

            </tbody>
        </table>
    </div>
</div>