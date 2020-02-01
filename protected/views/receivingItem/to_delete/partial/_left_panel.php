<div class="col-xs-12 col-sm-8 widget-container-col">
    <div class="message" style="display:none">
        <div class="alert in alert-block fade alert-success">Transaction Failed !</div>
    </div>

    <?php $this->renderPartial('partial/_left_panel_header', array(
        'model' => $model,
        'trans_header' => Yii::t('menu', $trans_header)
    )); ?>

    <div class="grid-view" id="grid_cart">
        <?php
        if (isset($warning)) {
            echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, $warning);
        }
        ?>

        <?= $this->renderPartial('//layouts/partial/_flash_message') ?>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><?php echo Yii::t('app', 'Item Name'); ?></th>
                <th><?php echo Yii::t('app', 'Quantity'); ?></th>
                <th class='<?php echo $hide_editcost; ?>'><?php echo Yii::t('app', 'Buy Price'); ?></th>
                <th class='<?php echo $hide_editprice; ?>'><?php echo Yii::t('app', 'Sell Price'); ?></th>
                <th class="<?php echo Yii::app()->settings->get('sale', 'discount'); ?>"><?php echo Yii::t('app',
                        'Discount'); ?></th>
                <th class='<?php echo $expiredate_class; ?>'><?php echo Yii::t('app', 'Expire Date'); ?></th>
                <th><?php echo Yii::t('app', 'Total'); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody id="cart_contents">
            <?php foreach (array_reverse($items, true) as $id => $item): ?>
                <?php
                $total_item = Common::calTotalAfterDiscount($item['discount'], $item['cost_price'],
                    $item['quantity']);
                $item_id = $item['item_id'];
                $cur_item_info = Item::model()->findbyPk($item_id);
                $qty_in_stock = $cur_item_info->quantity;

                $item_expiredate_class = '';
                if ($item['is_expire'] == 0) {
                    $item_expiredate_class = 'disabled';
                }

                /*
                $n_expire=0;
                if (Yii::app()->receivingCart->getMode()<>'receive') {
                    $n_expire=ItemExpire::model()->count('item_id=:item_id and quantity>0',array('item_id'=>(int)$item['item_id']));
                }
                 *
                */
                ?>
                <tr>
                    <td>
                        <?php echo $item['name']; ?><br/>
                            <span class="text-info"><?php echo $qty_in_stock . ' ' . Yii::t('app',
                                        'in stock') ?> </span>
                    </td>

                    <td>
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'method' => 'post',
                            'action' => Yii::app()->createUrl('receivingItem/editItem/',
                                array('item_id' => $item['item_id'])),
                            'htmlOptions' => array('class' => 'line_item_form'),
                        ));
                        ?>
                        <?php echo $form->textField($model, "quantity", array(
                            'value' => $item['quantity'],
                            'class' => 'input-small input-grid',
                            'id' => "quantity_$item_id",
                            'placeholder' => Yii::t('app', 'Quantity'),
                            'maxlength' => 10
                        )); ?>
                        <?php $this->endWidget(); ?>
                    </td>

                    <td class='<?php echo $hide_editcost; ?>'>
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'method' => 'post',
                            'action' => Yii::app()->createUrl('receivingItem/editItem/',
                                array('item_id' => $item['item_id'])),
                            'htmlOptions' => array('class' => 'line_item_form'),
                        ));
                        ?>
                        <?php echo $form->textField($model, "cost_price", array(
                            'value' => $item['cost_price'],
                            'class' => 'input-small input-grid',
                            'id' => "cost_price_$item_id",
                            'placeholder' => Yii::t('app', 'Buy Price'),
                            'maxlength' => 10,
                        )); ?>
                        <?php $this->endWidget(); ?>
                    </td>

                    <td class='<?php echo $hide_editprice; ?>'>
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'method' => 'post',
                            'action' => Yii::app()->createUrl('receivingItem/editItem/',
                                array('item_id' => $item['item_id'])),
                            'htmlOptions' => array('class' => 'line_item_form'),
                        ));
                        ?>
                        <?php echo $form->textField($model, "unit_price", array(
                            'value' => $item['unit_price'],
                            'class' => 'input-small input-grid',
                            'id' => "unit_price_$item_id",
                            'placeholder' => Yii::t('app', 'Sell Price'),
                            'maxlength' => 10
                        )); ?>
                        <?php $this->endWidget(); ?>
                    </td>

                    <td class="<?php echo Yii::app()->settings->get('sale', 'discount'); ?>">
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'method' => 'post',
                            'action' => Yii::app()->createUrl('receivingItem/editItem/',
                                array('item_id' => $item['item_id'])),
                            'htmlOptions' => array('class' => 'line_item_form'),
                        ));
                        ?>
                        <?php echo $form->textField($model, "discount", array(
                                'value' => $item['discount'],
                                'class' => 'input-small input-grid',
                                'id' =>
                                    "discount_$item_id",
                                'placeholder' => 'Discount',
                                'data-id' => "$item_id",
                                'maxlength' => 9,
                                'disabled' => $disable_discount,
                            )
                        );
                        ?>
                        <?php $this->endWidget(); ?>
                    </td>

                    <td class='<?php echo $expiredate_class; ?>'>
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'method' => 'post',
                            'action' => Yii::app()->createUrl('receivingItem/editItem/',
                                array('item_id' => $item['item_id'])),
                            'htmlOptions' => array('class' => 'line_item_form'),
                        ));
                        ?>
                        <?php echo $form->textField($model, "expire_date", array(
                                'value' => $item['expire_date'],
                                'class' => 'input-small input-grid input-mask-date',
                                'id' => "discount_$item_id",
                                'placeholder' => '99/99/9999',
                            )
                        );
                        ?>
                        <?php /*$this->widget('yiiwheels.widgets.maskinput.WhMaskInput', array(
                            'model' => $model,
                            'attribute' => 'expire_date',
                            'mask' => '00/00/0000',
                            'value' => $item['expire_date'],
                            'htmlOptions' => array(
                                //'id' => "expire_date_$item_id",
                                'placeholder' => '00/00/0000',
                                'value' => $item['expire_date'],
                                'class' => "input-xs input-grid",
                                //"$item_expiredate_class" => true
                            )
                        )); */?>
                        <?php $this->endWidget(); ?>
                    </td>
                    <td><?php echo $total_item; ?>
                    <td><?php echo TbHtml::linkButton('', array(
                            'color' => TbHtml::BUTTON_COLOR_DANGER,
                            'size' => TbHtml::BUTTON_SIZE_MINI,
                            'icon' => 'glyphicon-trash',
                            'url' => array('deleteItem', 'item_id' => $item_id),
                            'class' => 'delete-item',
                            //'title' => Yii::t( 'app', 'Remove' ),
                        )); ?>
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
                <div class="col-xs-8"></div>
                <div class="col-xs-4" id="total_discount_cart">
                    <span class="input-icon">
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'method' => 'post',
                            'action' => Yii::app()->createUrl('receivingItem/setTotalDiscount/'),
                            'id' => 'total_discount_form'
                        ));
                        ?>
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

    </div>


</div>