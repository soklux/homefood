<?php foreach ($price_tiers as $i => $price_tier): ?>
    <div class="form-group">
        <?php echo CHtml::label($price_tier["tier_name"] . ' Price', $i, array('class' => 'col-sm-3 control-label no-padding-right')); ?>
        <div class="col-sm-9">
            <?php echo CHtml::TextField(get_class($model) . 'Price[' . $price_tier["tier_id"] . ']', $price_tier["price"] !== null ? round($price_tier["price"], Yii::app()->shoppingCart->getDecimalPlace()) : $price_tier["price"], array('class' => 'span3 form-control')); ?>
        </div>
    </div>
<?php endforeach; ?>