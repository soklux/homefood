<div class="grid-view" id="grid_cart">
    <?php 
    //echo json_encode(Yii::app()->session['pre']);
    // echo json_encode(Yii::app()->session['deleted_item']);
    ?>
    <table class="table table-hover table-condensed">
        <thead>
        <tr><th><?php echo Yii::t('app', 'Item Name'); ?></th>
            <th><?php echo Yii::t('app', 'Quantity'); ?></th>
            <th><?php echo Yii::t('app', 'Price'); ?></th>
            <th class="<?php echo Yii::app()->settings->get('sale', 'discount'); ?>"><?php echo Yii::t('app', 'Discount'); ?></th>
            <th><?php echo Yii::t('app', 'Total'); ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody id="cart_contents">
        <?php foreach (array_reverse($items, true) as $id => $item): ?>
            <?php
            $total_item = Common::calTotalAfterDiscount($item['discount'],$item['price'],$item['quantity']);
            $item_id = $item['item_id'];
            $cur_item_info = Item::model()->findbyPk($item_id);
            $qty_in_stock = $cur_item_info->quantity;
            ?>
            <tr>
                <td>
                    <?php echo $item['name']; ?><br/>
                    <span class="text-info"><?php echo $qty_in_stock . ' ' . Yii::t('app', 'in stock'); ?> </span>
                </td>
                <td>
                    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                        'method'=>'post',
                        'action' => Yii::app()->createUrl('saleItem/editItem/',array('item_id'=>$item['item_id'])),
                        'htmlOptions'=>array('class'=>'line_item_form'),
                    ));
                    ?>
                    <?php echo $form->textField($model, "quantity", array('value' => $item['quantity'], 'class' => 'input-small input-grid', 'id' => "quantity_$item_id", 'placeholder' => 'Quantity','maxlength' => 10)); ?>
                    <?php $this->endWidget(); ?>
                </td>
                <td>
                    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                        'method'=>'post',
                        'action' => Yii::app()->createUrl('saleItem/editItem/',array('item_id'=>$item['item_id'])),
                        'htmlOptions'=>array('class'=>'line_item_form'),
                    ));
                    ?>
                    <?php echo $form->textField($model, "price", array('value' => $item['price'], 'class' => 'input-small input-grid', 'id' => "price_$item_id", 'placeholder' => 'Price', 'maxlength' => 10,'disabled'=>$disable_editprice)); ?>
                    <?php $this->endWidget(); ?>
                </td>
                <td class="<?php echo Yii::app()->settings->get('sale', 'discount'); ?>">
                    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                        'method'=>'post',
                        'action' => Yii::app()->createUrl('saleItem/editItem/',array('item_id'=>$item['item_id'])),
                        'htmlOptions'=>array('class'=>'line_item_form'),
                    ));
                    ?>
                    <?php echo $form->textField($model, "discount", array('value' => $item['discount'],
                            'class' => 'input-small input-grid', 'id' =>
                                "discount_$item_id",
                            'placeholder' => 'Discount',
                            'data-id' => "$item_id",
                            'maxlength' => 9,
                            'disabled'=>$disable_discount,
                        )
                    );
                    ?>
                    <?php $this->endWidget(); ?>
                </td>
                <td><?php echo $total_item; ?>
                <td><?php
                    echo TbHtml::linkButton('', array(
                        'color'=>TbHtml::BUTTON_COLOR_DANGER,
                        'size' => TbHtml::BUTTON_SIZE_MINI,
                        'icon' => 'glyphicon glyphicon-trash ',
                        'url' => array('DeleteItem', 'item_id' => $item_id,'quantity'=>$item['quantity']),
                        'class' => 'delete-item',
                        'title' => Yii::t('app', 'Remove'),
                    ));
                    ?>
                </td>
            </tr>
        <?php endforeach; ?> <!--/endforeach-->

        </tbody>
    </table>

    <?php
    if (empty($items)) {
        echo Yii::t('app', 'There are no items in the cart');
    }
    ?>

    <?php if (!empty($items)) { ?>
        <div class="widget-toolbox padding-8 clearfix">
            <div class="col-xs-5"></div>
            <div class="col-xs-4" id="total_gst_cart">
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'method' => 'post',
                    'action' => Yii::app()->createUrl('saleItem/setGST/'),
                    'id' => 'total_gst_form'
                ));
                ?>
                <span class="input-icon">
                        <?php echo $form->textField($model, 'total_gst', array(
                                'id' => 'total_gst_id',
                                'class' => 'col-xs-12 input-totalgst align-right pull-right',
                                'placeholder' => 'General Sale Tax (VAT)',
                                'maxlength' => 25,
                                'append' => '%',
                            )
                        ); ?>
                    <i class="ace-icon fa fa-plus-square green"></i>
                    </span>
                <?php $this->endWidget(); ?>
            </div>
            <div class="col-xs-3" id="total_discount_cart">
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'method' => 'post',
                    'action' => Yii::app()->createUrl('saleItem/setTotalDiscount/'),
                    'id' => 'total_discount_form'
                ));
                ?>
                <span class="input-icon">
                    <?php echo $form->textField($model, 'total_discount', array(
                            'id' => 'total_discount_id',
                            'class' => 'col-xs-12 input-totaldiscount align-right',
                            'placeholder' => 'Total Discount',
                            'maxlength' => 25,
                            'append' => $discount_symbol,
                            'disabled' => $disable_discount
                        )
                    ); ?>
                    <?php $this->endWidget(); ?>
                    <i class="ace-icon fa fa-minus-square orange"></i>
                </span>
            </div>
        </div>
    <?php } ?>

</div> <!-- #section:grid.cart.layout -->