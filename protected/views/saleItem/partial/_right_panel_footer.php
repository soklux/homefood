<div class="row">
    <div class="sidebar-nav" id="payment_cart">

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
                <td><span class="badge badge-info bigger-120">
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
            <td><?= Yii::t('app', 'Total'); ?> :</td>
            <td><span
                    class="badge badge-info bigger-120"><?= Yii::app()->settings->get('site', 'currencySymbol') . number_format($total, Common::getDecimalPlace(), '.', ','); ?></span>
            </td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Total in KHR'); ?> :</td>
            <td>
                <span class="badge badge-success bigger-120">
                    <?= Yii::app()->settings->get('site', 'altcurrencySymbol') . number_format($total_khr_round, 0, '.', ','); ?>
                </span>
            </td>
        </tr>
        <?php if(getTransType()==param('sale_complete_status')):?>
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
        <?php endif;?>
        </tbody>
    </table>

    <?php $this->renderPartial('partial/_right_panel_complete',array(
        'count_check' => $count_item,
        'sale_save_url' => $sale_save_url,
        'color_style' => $color_style
    )); ?>

        <?php $this->endWidget(); ?>


    </div>
</div>
