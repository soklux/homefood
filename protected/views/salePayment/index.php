<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Payment') => array('salePayment/index'),
    Yii::t('app', 'Index'),
);

?>

<?php $this->renderPartial('//layouts/alert/_gritter'); ?>

<div id="payment_container">

    <?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>

    <?php $this->renderPartial('partial/_search', array('model' => $model, 'client_name' => $client_name)); ?>

    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
        'title' => Yii::t('app', 'Payment') . ' :  ' . $client_name,
        'headerIcon' => 'ace-icon fa fa-credit-card',
        'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    )); ?>

        <!-- Flash message layouts.partial._flash_message -->
        <?php /*$this->renderPartial('//layouts/partial/_flash_message'); */?>

        <div class="row">
            <div class="sidebar-nav" id="client_cart">
                <?php
                if ($client_name == '') {
                    $this->renderPartial('partial/_client', array('model' => $model));
                } else {
                    $this->renderPartial('partial/_client_selected', array('model' => $model,
                            'balance' => $balance,
                            'client_id' => $client_id,
                            'client_name' => $client_name
                        )
                    );
                }
                ?>

                <?php if ($sale_id !== null ) {
                    $this->renderPartial('partial/_invoice_selected', array('sale_id' => $sale_id, 'invoice_balance' => $invoice_balance, 'employee_id' => $employee_id));
                } ?>

            </div>
        </div>

        <div id="sale_payment_cart">

            <?php $this->renderPartial('partial/_payment_form', array('model' => $model, 'save_button' => $save_button, 'invoice_balance' => $invoice_balance)); ?>

        </div>


        <?php $this->renderPartial('partial/_invoice_payment_sub', array('model' => $model, 'client_id' => $client_id, 'balance' => $balance)); ?>

    <?php $this->endWidget(); ?>


</div>

