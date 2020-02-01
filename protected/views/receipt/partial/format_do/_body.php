<div class="row">
    <div class="col-xs-12">
        <table class="table" id="receipt_items">
            <thead>
            <tr>
                <th><?= 'ល.រ' ?></th>
                <th><?= 'បរិយាយមុខទំនិញ' ?></th>
                <th class="center" >
                    <?= 'បរិមាណ' ?>
                </th>
                <th align="right"> ថ្ងៃផុតកំណត់  សំគាល់</th>
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
                    <td class="center"><?= $item["unit_measurable"]  .  '  ' . TbHtml::encode($item['quantity']); ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>