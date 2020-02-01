<div class="row">
    <div class="col-xs-6">
		<!--
        <p>
            <?php //echo TbHtml::encode('Sale to Doctor or Pharmacy' . " : "  .ucwords($cust_fullname)); ?> <br>
            <?php //echo Yii::t('app','Address') . " : ". TbHtml::encode(ucwords($cust_address1)); ?> <br>
        </p>
		-->
    </div>
    <div class="col-xs-6 col-xs-offset-0 text-right">
        <p>
            <?php echo TbHtml::encode(Yii::t('app','TIME') . " : " . $transaction_time); ?> <br>
        </p>
    </div>

    <div class="col-xs-12">
        <table class="table" id="receipt_items">
            <thead>
            <tr>
                <th><?php echo Yii::t('app','NO.'); ?></th>
                <th><?php echo Yii::t('app','Bar Code'); ?></th>
                <th><?php echo Yii::t('app','Description'); ?></th>
                <th class="center" ><?php echo TbHtml::encode(Yii::t('app','QTY')); ?></th>
                <th class="center" ><?php echo TbHtml::encode(Yii::t('app','UOM')); ?></th>
                <th class="center"><?php echo Yii::t('app','PRICE'); ?></th>
                <th class="<?php echo 'center' . ' ' . Yii::app()->settings->get('sale','discount'); ?>">
                    <?php echo TbHtml::encode(Yii::t('app','Discount')); ?>
                </th>
                <th class="text-right"><?php echo TbHtml::encode(Yii::t('app','AMOUNT')); ?></th>
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
                    $total_item=number_format($item['price']*$item['quantity']-$discount_amt,Yii::app()->shoppingCart->getDecimalPlace());
                } else {
                    $total_item=number_format($item['price']*$item['quantity']-$item['price']*$item['quantity']*$discount_amt/100,Yii::app()->shoppingCart->getDecimalPlace());
                }
                ?>
                <tr>
                    <td><?php echo TbHtml::encode($i); ?></td>
                    <td><?php echo TbHtml::encode($item['item_number']); ?></td>
                    <td><?php echo TbHtml::encode($item['name']); ?></td>
                    <td class="center"><?php echo TbHtml::encode($item['quantity']); ?></td>
                    <td class="center"><?php echo TbHtml::encode($item['unit_measurable']); ?></td>
                    <td class="center"><?php echo TbHtml::encode(number_format($item['price'],Yii::app()->shoppingCart->getDecimalPlace())); ?></td>
                    <td class="<?php echo 'center' . ' ' . Yii::app()->settings->get('sale','discount'); ?>"><?php echo TbHtml::encode($item['discount']); ?></td>
                    <td class="text-right"><?php echo TbHtml::encode($total_item); ?>
                </tr>
            <?php endforeach; ?> <!--/endforeach-->

            </tbody>
        </table>
    </div>

</div>