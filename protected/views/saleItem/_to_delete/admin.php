<div id="register_container">
<div class="col-xs-12 col-sm-8 widget-container-col">
    <div class="message expire_date" style="display:none">
        <div class="alert in alert-block fade alert-success">Transaction Failed !</div>
    </div>

    <?php $this->renderPartial('_search', array('model' => $model,'employee_id' => $employee_id )); ?>

    <!-- #section:grid.cart.layout -->
    <div class="grid-view" id="grid_cart">

        <?php
        if (isset($warning)) {
            echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, $warning);
        }
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
                                    'url' => array('DeleteItem', 'item_id' => $item_id),
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

    <i class="ace-icon fa fa-book"></i>
    <?php echo TbHtml::tooltip('Keyboard Shortcuts Help','#',
            '[ESC] => Set the focus to the "Cancel Sale". [Enter] will trigger the functionality <br>
             [F2] => Set the focus to "Customer Box" <br>
             [F1] => Set the focus to "Payment Amount" [Enter] to make payment, Press another [Enter] to Complete Sale',
             array('data-html' => 'true','placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,)
    ); ?>

</div> <!--/span8-->

<div class="col-xs-12 col-sm-4 widget-container-col">
    <!-- #section:canel-cart.layout -->
    <div class="row">
        <div id="cancel_cart">
            <?php if ($count_item <> 0) { ?>
                <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'suspend_sale_form',
                    'action' => Yii::app()->createUrl('saleItem/SuspendSale/'),
                    'enableAjaxValidation' => false,
                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
                ));
                ?>
                    <div align="right">
                        <?php
                        echo TbHtml::linkButton(Yii::t('app', 'Suspend Sale'), array(
                            'color' => TbHtml::BUTTON_COLOR_WARNING,
                            'size' => TbHtml::BUTTON_SIZE_SMALL,
                            'icon' => 'glyphicon-pause white',
                            'url' => Yii::app()->createUrl('SaleItem/SuspendSale/'),
                            'class' => 'suspend-sale',
                            //'title' => Yii::t('app', 'Suspend Sale'),
                        ));
                        ?>

                        <?php
                        echo TbHtml::linkButton(Yii::t('app', 'Cancel Sale'), array(
                            'color' => TbHtml::BUTTON_COLOR_DANGER,
                            'size' => TbHtml::BUTTON_SIZE_SMALL,
                            'icon' => '	glyphicon-remove white',
                            'url' => Yii::app()->createUrl('SaleItem/CancelSale/'),
                            'class' => 'cancel-sale',
                            'id' => 'cancel_sale_button',
                            //'title' => Yii::t('app', 'Cancel Sale'),
                        ));
                        ?>
                    </div>
                <?php $this->endWidget(); ?>
            <?php } ?>
        </div>
    </div> <!-- #section:canel-cart.layout -->

    <!-- #section:client.layout -->
    <div class="row">
        <div class="sidebar-nav" id="client_cart">
            <?php
            if ($customer!== null) {
                $this->widget('yiiwheels.widgets.box.WhBox', array(
                    'title' => Yii::t('app', 'Customer Information'),
                    'headerIcon' => 'ace-icon fa fa-info-circle ',
                    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                    'content' => $this->renderPartial('_client_selected', array(
                        'model' => $model,
                        'cust_fullname' => $cust_fullname,
                        'customer_id' => $customer_id,
                        'acc_balance' => $acc_balance,
                        'sale_mode' => $sale_mode
                    ), true),
                ));
            } else {
                $this->widget('yiiwheels.widgets.box.WhBox', array(
                    'title' => Yii::t('app', 'Select Customer (Optional)'),
                    'headerIcon' => 'ace-icon fa fa-users',
                    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
                    'content' => $this->renderPartial('_client', array('model' => $model), true)
                ));
            }
            ?>
        </div>
    </div> <!-- #section:client.layout -->

    <!-- #section:payment-cart.layout -->
    <div class="row">
        <div class="sidebar-nav" id="payment_cart">
            <?php if ($count_item <> 0) { ?>
                    <?php
                    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id' => 'finish_sale_form',
                        'action' => Yii::app()->createUrl('saleItem/completeSale/'),
                        'enableAjaxValidation' => false,
                        'layout' => TbHtml::FORM_LAYOUT_INLINE,
                    ));
                    ?>
                        <table class="table table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td><?php echo Yii::t('app', 'Item in Cart'); ?> :</td>
                                    <td><?php echo $count_item; ?></td>
                                </tr>
                                <?php //if ($total_discount!==NULL && $discount_amount>0) { ?>
                                <?php if ( $discount_amount>0 ) { ?>
                                <tr>
                                    <td><?php echo Yii::t('app', 'Sub Total'); ?> :</td>
                                    <td><span class="badge badge-info bigger-120"><?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($sub_total, Common::getDecimalPlace(), '.', ','); ?></span></td>
                                </tr>
                                <tr>
                                    <td><?php echo $discount_symbol . $discount_amt . ' '. Yii::t('app', 'Discount'); ?> :</td>
                                    <td><span class="badge badge-info bigger-120"><?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount, Common::getDecimalPlace(), '.', ','); ?></span></td>
                                </tr>
                                <?php } ?>

                                <?php if ($total_gst!==NULL && $total_gst>0) { ?>
                                    <tr>
                                        <td><?php echo $total_gst . '% ' . Yii::t('app', 'VAT'); ?> :</td>
                                        <td><span class="badge badge-info bigger-120"><?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($gst_amount, Common::getDecimalPlace(), '.', ','); ?></span></td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td><?php echo Yii::t('app', 'Total'); ?> :</td>
                                    <td><span class="badge badge-info bigger-120"><?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total, Common::getDecimalPlace(), '.', ','); ?></span></td>
                                </tr>
                                 <tr>
                                    <td><?php echo Yii::t('app', 'Total in KHR'); ?> :</td>
                                    <td><span class="badge badge-success bigger-120">
                                         <?php //echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($total_khr, 0, '.', ','); ?>

                                         <?php echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($total_khr_round, 0, '.', ','); ?>
                                        </span>
                                    </td>
                                </tr>

                                <?php if ($count_payment > 0) { ?>
                                    <?php foreach ($payments as $id => $payment): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo TbHtml::linkButton('', array(
                                                'size' => TbHtml::BUTTON_SIZE_MINI,
                                                'color' => TbHtml::BUTTON_COLOR_DANGER,
                                                'icon' => 'glyphicon-remove',
                                                'url' => Yii::app()->createUrl('SaleItem/DeletePayment', array('payment_id' => $payment['payment_type'])),
                                                'class' => 'delete-payment pull-right',
                                                'title' => Yii::t('app', 'Delete Payment'),
                                            ));
                                            ?>
                                            <?php echo Yii::t('App','Paid Amount') . ' [' . $payment['payment_type'] .']'; ?></td>
                                        <td>
                                            <span class="badge badge-info bigger-120">
                                                <?php echo Yii::app()->numberFormatter->formatCurrency(($payment['payment_amount']), Yii::app()->settings->get('site', 'currencySymbol')); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>

                                    <?php if ($amount_change<=0) { ?>
                                        <tr>
                                            <td>
                                               <?php echo Yii::t('app', 'Change Due'); ?>:
                                            </td>
                                            <td>
                                                <span class="badge badge-info bigger-120">
                                                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($amount_change, Common::getDecimalPlace(), '.', ','); ?>
                                                </span>
                                                    &nbsp; OR &nbsp;
                                                <span class="badge badge-info bigger-120">
                                                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($amount_change_whole,0,'.',','); ?>
                                                    &
                                                    <?php echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_fraction_khr, 0, '.', ','); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               <?php echo Yii::t('app', 'Change Due in KHR'); ?>:
                                            </td>
                                            <td>
                                                <span class="badge badge-success bigger-120">
                                                    <?php echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_khr_round, 0, '.', ','); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php  } else { ?>
                                        <tr>
                                            <td>
                                                <span class="label label-danger">
                                                    <?php echo TbHtml::b(Yii::t('app', 'Change Owe')); ?></td>
                                                </span>
                                            <td>
                                                <span class="badge badge-important bigger-120">
                                                    <strong>
                                                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($amount_change, Common::getDecimalPlace(), '.', ','); ?>
                                                    </strong>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               <span class="label label-danger">
                                               <?php echo TbHtml::b(Yii::t('app', 'Change Due in KHR')); ?>:
                                               </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-important bigger-120">
                                                    <?php echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_khr_round, 0, '.', ','); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>


                                <tr style="display:none">
                                    <td><?php echo Yii::t('app', 'Payment Type'); ?>:</td>
                                    <td>
                                        <?php echo $form->dropDownList($model, 'payment_type', InvoiceItem::itemAlias('payment_type'), array('id' => 'payment_type_id')); ?>
                                    </td>
                                </tr>


                                <?php if ($count_payment == 0) { ?>
                                    <tr>
                                        <td colspan="2" style='text-align:right'>
                                                <?php echo $form->textFieldControlGroup($model, 'alt_payment_amount', array(
                                                        //'value' => $amount_change,
                                                        'class' => 'input-small text-right payment-amount-txt',
                                                        'id' => 'alt_payment_amount_id',
                                                        'data-url' => Yii::app()->createUrl('SaleItem/AddPayment/'),
                                                        'placeholder'=>Yii::t('app','Payment Amount') . ' ' .   Yii::app()->settings->get('site', 'altcurrencySymbol'),
                                                        'prepend' =>  Yii::app()->settings->get('site', 'altcurrencySymbol'),
                                                    ));
                                                ?>
                                                <?php echo $form->textFieldControlGroup($model, 'payment_amount', array(
                                                        'value' => $total_due,//'', //$amount_change,
                                                        'class' => 'input-mini text-right payment-amount-txt',
                                                        'id' => 'payment_amount_id',
                                                        'data-url' => Yii::app()->createUrl('SaleItem/AddPayment/'),
                                                        'placeholder'=>Yii::t('app','Payment Amount') . ' '  . Yii::app()->settings->get('site', 'currencySymbol'),
                                                        'prepend' =>  Yii::app()->settings->get('site', 'currencySymbol'),
                                                    ));
                                                ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style='text-align:right'><?php
                                            echo TbHtml::linkButton(Yii::t('app', 'Add Payment'), array(
                                                'color' => TbHtml::BUTTON_COLOR_INFO,
                                                'size' => TbHtml::BUTTON_SIZE_MINI,
                                                'icon' => 'glyphicon-plus white',
                                                'url' => Yii::app()->createUrl('SaleItem/AddPayment/'),
                                                'class' => 'add-payment',
                                                //'title' => Yii::t('app', 'Add Payment'),
                                            ));
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($customer!== null) { ?>
                                    <tr>
                                        <td><?php echo TbHtml::b(Yii::t('app', 'Total Due'))  ; ?> :</td>
                                        <td>
                                            <span class="badge badge-success bigger-140">
                                                <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total_due, Common::getDecimalPlace(), '.', ',') ; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php } ?>


                            </tbody>
                        </table>

                        <?php if ($count_payment > 0) { ?>
                            <table class="table table-striped table-condensed">
                                <!--
                                <thead class="thin-border-bottom">
                                    <tr><th>Type</th><td>Amount</th><th></tr>
                                </thead>
                                <tbody id="payment_content">
                                    <?php //foreach ($payments as $id => $payment): ?>
                                    <tr>
                                        <td><?php //echo $payment['payment_type']; ?></td>
                                        <td><?php //echo Yii::app()->numberFormatter->formatCurrency(($payment['payment_amount']), Yii::app()->settings->get('site', 'currencySymbol')); ?></td>
                                        <td>
                                            <?php /*
                                            echo TbHtml::linkButton('', array(
                                                //'color'=>TbHtml::BUTTON_COLOR_INFO,
                                                'size' => TbHtml::BUTTON_SIZE_MINI,
                                                'icon' => 'glyphicon-remove',
                                                'url' => Yii::app()->createUrl('SaleItem/DeletePayment', array('payment_id' => $payment['payment_type'])),
                                                'class' => 'delete-payment',
                                                //'title' => Yii::t('app', 'Delete Payment'),
                                            ));
                                             *
                                            */
                                            ?>
                                        </td>
                                    </tr> -->
                                    <?php //endforeach; ?>

                                    <?php //if ($amount_change<=0) { ?>

                                        <td colspan="3" style='text-align:right'>
                                        <?php
                                        echo TbHtml::linkButton(Yii::t('app', 'Complete Sale'), array(
                                            'color' => TbHtml::BUTTON_COLOR_SUCCESS,
                                            'icon' => 'glyphicon glyphicon-off white',
                                            //'url' => Yii::app()->createUrl('SaleItem/CompleteSale/'),
                                            'class' => 'complete-sale',
                                            'id' => 'finish_sale_button',
                                            //'title' => Yii::t('app', 'Complete Sale'),
                                        ));
                                        ?>
                                        </td>
                                        <!--
                                        <div id="comment_content" align="right">
                                        <?php //echo $form->textArea($model,'comment',array('rows'=>1, 'cols'=>20,'class'=>'input-small','maxlength'=>250,'id'=>'comment_id'));  ?>
                                        </div>
                                        -->
                                    <?php //} ?>

                                </tbody>
                            </table>
                    <?php } ?>

                <?php $this->endWidget(); ?>
             <?php } ?>

        </div> <!-- /section:custom/widget-main -->

    </div> <!-- payment cart -->
 </div> <!-- #section:payment-cart.layout -->


<div class="waiting"><!-- Place at bottom of page --></div>
