<div class="container">
    <div id="price-range">
        <?php $id=0; foreach($item_price_quantity as $k=>$item_price):?>
            <div class="range-<?php echo $item_price['id'] ?>">
            <div class="row">
                <hr style="width:90%; margin-left:0px;">
                <div class="col-sm-2">
                    <div class="form-group col-sm-12">
                        <?php echo CHtml::TextField('priceQuantity[price_qty'.$item_price["id"].'][from_quantity]', $item_price["from_quantity"] !== null ? round($item_price["from_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["from_quantity"], array('class'=>'form-control txt-from-qty0','placeholder'=>'From','title'=>'From Quantity','onkeyUp'=>'getValue(0)')); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group col-sm-12">
                        <?php echo CHtml::TextField('priceQuantity[price_qty'.$item_price["id"].'][to_quantity]', $item_price["to_quantity"] !== null ? round($item_price["to_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["to_quantity"], array('class'=>'form-control txt-from-qty0','placeholder'=>'To','title'=>'To Quantity','onkeyUp'=>'getValue(0)')); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group col-sm-12">
                        <?php echo CHtml::TextField('priceQuantity[price_qty'.$item_price["id"].'][unit_price]', $item_price["unit_price"] !== null ? round($item_price["unit_price"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["price"], array('class'=>'form-control txt-from-qty0','placeholder'=>'Unit Price','title'=>'Unit Price','onkeyUp'=>'getValue(0)')); ?>
                    </div>
                </div>
                <!-- <div class="col-sm-2">
                    <div class="form-group col-sm-12">
                        <?php echo CHtml::TextField('priceQuantity[price_qty'.$item_price["id"].'][start_date]', $item_price["start_date"] !== null ? $item_price["start_date"] : $item_price["start_date"], array('class'=>'form-control dt-start-date'.$item_price["id"],'placeholder'=>'yyyy/mm/dd','title'=>'Start Date','onkeyUp'=>'getValue(0)')); ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group col-sm-12">
                        <?php echo CHtml::TextField('priceQuantity[price_qty'.$item_price["id"].'][end_date]', $item_price["end_date"] !== null ? $item_price["end_date"] : $item_price["end_date"], array('class'=>'form-control dt-end-date'.$item_price["id"],'placeholder'=>'yyyy/mm/dd','title'=>'End Date','onkeyUp'=>'getValue(0)')); ?>
                    </div>
                </div> -->
                <div class="col-sm-2">
                    <input type="button" value="X" class="btn btn-small btn-danger" onClick="removePriceRange(<?php echo $item_price['id'] ?>)">
                </div>
            </div>
            
            </div>
        <?php $id=$item_price['id']; endforeach;?>
        <?php if(!empty($priceQty)):?>
            <?php foreach($priceQty as $k=>$v):?>
                <div class="row">
                    <hr style="width:90%; margin-left:0px;">
                    <div class="col-sm-2">
                        <div class="form-group col-sm-12">
                            <?php echo CHtml::TextField('priceQuantity[price_qty'.$k.'][from_quantity]', $v["From"] !== null ? round($v["From"], Yii::app()->shoppingCart->getDecimalPlace()) : $v["From"], array('class'=>'form-control txt-from-qty0','placeholder'=>'From','title'=>'From Quantity','onkeyUp'=>'getValue(0)'));?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group col-sm-12">
                            <?php echo CHtml::TextField('priceQuantity[price_qty'.$k.'][from_quantity]', $v["To"] !== null ? round($v["To"], Yii::app()->shoppingCart->getDecimalPlace()) : $v["To"], array('class'=>'form-control txt-from-qty0','placeholder'=>'To','title'=>'To Quantity','onkeyUp'=>'getValue(0)'));?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group col-sm-12">
                            <?php echo CHtml::TextField('priceQuantity[price_qty'.$k.'][from_quantity]', $v["Price"] !== null ? round($v["Price"], Yii::app()->shoppingCart->getDecimalPlace()) : $v["Price"], array('class'=>'form-control txt-from-qty0','placeholder'=>'Price','title'=>'Price','onkeyUp'=>'getValue(0)'));?>
                        </div>
                    </div>
                </div>
                <?php echo $k;?>
            <?php endforeach;?>
        <?php endif;?>
    </div>
    <div class="form-group col-sm-7">
        <?php echo CHtml::Button('Add Range',array('class'=>'btn-add-qty btn btn-sm btn-primary pull-right'))?>
        <!-- <?php echo CHtml::Button('Add Range',array('class'=>'btn btn-sm btn-primary pull-right','onClick'=>'addPriceRange('.$id.')'))?> -->
    </div>
</div>
<?php $this->renderPartial('partialList/_js'); ?>