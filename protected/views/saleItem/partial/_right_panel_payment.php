<div class="row">
    <div class="sidebar-nav" id="payment_cart">
        <?php if ($count_item <> 0) { ?>
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'finish_sale_form',
                'action' => Yii::app()->createUrl($sale_save_url),
                'enableAjaxValidation' => false,
                'layout' => TbHtml::FORM_LAYOUT_INLINE,
            ));
            ?>

            <table class="table table-bordered table-condensed">
                <tbody>
                <tr>
                    <td><?= Yii::t('app', 'Item in Cart'); ?> :</td>
                    <td><?= $count_item; ?></td>
                </tr>
                <?php //if ($total_discount!==NULL && $discount_amount>0) { ?>
                <?php if ($discount_amount > 0) { ?>
                    <tr>
                        <td><?= Yii::t('app', 'Sub Total'); ?> :</td>
                        <td><span
                                class="badge badge-info bigger-120">
                                <?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($sub_total, Common::getDecimalPlace(), '.', ','); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><?= $discount_symbol . $discount_amt . ' ' . Yii::t('app', 'Discount'); ?> :</td>
                        <td><span
                                class="badge badge-info bigger-120"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($discount_amount, Common::getDecimalPlace(), '.', ','); ?></span>
                        </td>
                    </tr>
                <?php } ?>

                <?php if ($total_gst !== NULL && $total_gst > 0) { ?>
                    <tr>
                        <td><?php echo $total_gst . '% ' . Yii::t('app', 'VAT'); ?> :</td>
                        <td><span
                                class="badge badge-info bigger-120"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($gst_amount, Common::getDecimalPlace(), '.', ','); ?></span>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td><?php echo Yii::t('app', 'Total'); ?> :</td>
                    <td><span
                            class="badge badge-info bigger-120"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($total, Common::getDecimalPlace(), '.', ','); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Total in KHR'); ?> :</td>
                    <td><span class="badge badge-success bigger-120">
                                         <?php //echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($total_khr, 0, '.', ','); ?>

                                         <?= Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($total_khr_round, 0, '.', ','); ?>
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
                                <?= Yii::t('App', 'Paid Amount') . ' [' . $payment['payment_type'] . ']'; ?></td>
                            <td>
                                    <span class="badge badge-info bigger-120">
                                        <?= Yii::app()->numberFormatter->formatCurrency(($payment['payment_amount']), Yii::app()->settings->get('site', 'currencySymbol')); ?>
                                    </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if ($amount_change <= 0) { ?>
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
                                    <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($amount_change_whole, 0, '.', ','); ?>
                                    &
                                    <?php echo Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_fraction_khr, 0, '.', ','); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= Yii::t('app', 'Change Due in KHR'); ?>:
                            </td>
                            <td>
                                <span class="badge badge-success bigger-120">
                                    <?= Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_khr_round, 0, '.', ','); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } else { ?>
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
                               <?= TbHtml::b(Yii::t('app', 'Change Due in KHR')); ?>:
                               </span>
                            </td>
                            <td>
                                <span class="badge badge-important bigger-120">
                                    <?= Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($amount_change_khr_round, 0, '.', ','); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>


                <tr style="display:none">
                    <td><?= Yii::t('app', 'Payment Type'); ?>:</td>
                    <td>
                        <?= $form->dropDownList($model, 'payment_type', InvoiceItem::itemAlias('payment_type'), array('id' => 'payment_type_id')); ?>
                    </td>
                </tr>


                <?php if ($count_payment == 0) { ?>
                    <tr>
                        <td colspan="2" style='text-align:right;display:none'>
                            <?php echo $form->textFieldControlGroup($model, 'alt_payment_amount', array(
                                //'value' => $amount_change,
                                'class' => 'input-small text-right payment-amount-txt',
                                'id' => 'alt_payment_amount_id',
                                'data-url' => Yii::app()->createUrl('SaleItem/AddPayment/'),
                                'placeholder' => Yii::t('app', 'Payment Amount') . ' ' . Yii::app()->settings->get('site', 'altcurrencySymbol'),
                                'prepend' => Yii::app()->settings->get('site', 'altcurrencySymbol'),
                            ));
                            ?>
                            <?php echo $form->textFieldControlGroup($model, 'payment_amount', array(
                                'value' =>  0,//$total_due,//'', //$amount_change,
                                'class' => 'input-mini text-right payment-amount-txt',
                                'id' => 'payment_amount_id',
                                'data-url' => Yii::app()->createUrl('SaleItem/AddPayment/'),
                                'placeholder' => Yii::t('app', 'Payment Amount') . ' ' . Yii::app()->settings->get('site', 'currencySymbol'),
                                'prepend' => Yii::app()->settings->get('site', 'currencySymbol'),
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style='text-align:right;display:none'><?php
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

                <?php if ($customer !== null) { ?>
                    <tr>
                        <td><?php echo TbHtml::b(Yii::t('app', 'Total Due')); ?> :</td>
                        <td>
                            <span class="badge badge-success bigger-140">
                                <?php echo Yii::app()->settings->get('site', 'currencySymbol') . number_format($total_due, Common::getDecimalPlace(), '.', ','); ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="2" align="right">
                        Choose Invoice Format
                        <?php echo $form->dropDownList($model,'employee_id', Common::arrayFactory('invoice_format'),
                            array(
                                'id'=>'invoice_format_id',
                                'options'=>array(Yii::app()->shoppingCart->getInvoiceFormat()=>array('selected'=>true),
                                ))
                        );?>
                    </td>
                </tr>

                </tbody>
            </table>

            <?php $this->renderPartial('partial/_right_panel_complete',array(
                    'count_check' => $count_item,
                    'sale_save_url' => $sale_save_url,
                    'color_style' => $color_style
            )); ?>

            <?php $this->endWidget(); ?>

        <?php } ?>


    </div>
    <!-- /section:custom/widget-main -->

</div>

