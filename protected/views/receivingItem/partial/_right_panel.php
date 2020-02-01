<div class="col-xs-12 col-sm-4 widget-container-col">
    <!-- #section:canel-cart.layout -->
    <!--<div class="row">
        <div id="cancel_cart">
            <?php /*if ($count_item <> 0) { */?>
                <?php
/*                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'cancel_recv_form',
                    'action' => Yii::app()->createUrl('receivingItem/cancelRecv/'),
                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
                ));
                */?>
                <div align="right">
                    <?php
/*                    echo TbHtml::linkButton(Yii::t('app', 'Cancel'), array(
                        'color' => TbHtml::BUTTON_COLOR_DANGER,
                        'size' => TbHtml::BUTTON_SIZE_SMALL,
                        'icon' => '	glyphicon-remove white',
                        'url' => Yii::app()->createUrl('receivingItem/cancelRecv/'),
                        'class' => 'cancel-receiving',
                        'id' => 'cancel_receiving_button',
                        //'title' => Yii::t('app', 'Cancel Receiving'),
                    ));
                    */?>
                </div>
                <?php /*$this->endWidget(); */?>
            <?php /*} */?>
        </div>
    </div>-->
    <!-- #section:canel-cart.layout -->

    <div class="row">
        <div class="sidebar-nav" id="supplier_cart">
            <?php
            if ($trans_mode == 'physical_count' || $trans_mode == 'adjustment_out' || $trans_mode =='adjustment_out') {
                $this->widget('yiiwheels.widgets.box.WhBox', array(
                    'title' => Yii::t('app', $trans_header) . ' By : ' . ucwords(Yii::app()->session['emp_fullname']),
                    'headerIcon' => 'menu-icon fa fa-users',
                    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                    'content' => $this->renderPartial('partial/_employee', array(
                            'model' => $model,
                            'supplier' => $supplier,
                            'count_item' => $count_item,
                            'trans_mode' => $trans_mode
                        ), true
                    )
                ));

            } else {
                if (isset($supplier)) {
                    $this->widget('yiiwheels.widgets.box.WhBox', array(
                        'title' => Yii::t('app', 'Supplier Info'),
                        'headerIcon' => 'menu-icon fa fa-info-circle',
                        'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                        'content' => $this->renderPartial('partial/_supplier_selected', array(
                                'model' => $model,
                                'supplier' => $supplier,
                                'trans_mode' => $trans_mode), true
                        ),
                    ));
                } else {
                    $this->widget('yiiwheels.widgets.box.WhBox', array(
                        'title' => Yii::t('app', 'Select Supplier (Optional)'),
                        'headerIcon' => 'menu-icon fa fa-users',
                        'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                        'headerButtons' => array(
                            TbHtml::buttonGroup(
                                array(
                                    array('label' => Yii::t('app','New'),
                                        'url'=>$this->createUrl('Supplier/Create/',array('recv_mode'=>'Y','trans_mode'=>$trans_mode)),
                                        'icon'=>'fa fa-plus white',
                                    ),
                                ),array('color'=>TbHtml::BUTTON_COLOR_INFO,'size'=>TbHtml::BUTTON_SIZE_SMALL)
                            ),
                        ),
                        'content' => $this->renderPartial('partial/_supplier',
                            array('model' => $model,
                                'supplier' => $supplier,
                                'count_item' => $count_item,
                                'trans_mode' => $trans_mode
                            ), true)
                    ));
                }
            }
            ?>
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('receivingItem/SetOutlet'),
                'id' => 'set-outlet-form',
                'method'=>'post',
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
            )); ?>
            <div>
                <?php
                    $this->widget('yiiwheels.widgets.box.WhBox', array(
                        'title' => Yii::t('app', 'Select Outlet'),
                        'headerIcon' => 'menu-icon fa fa-university',
                        'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                        'content' => $this->renderPartial('partial/_outlet',
                            array('model' => $model,
                                'supplier' => $supplier,
                                'count_item' => $count_item,
                                'trans_mode' => $trans_mode,
                                'form' => $form
                            ), true)
                    ));
                ?>
            <?php $this->endWidget()?>
        </div>
        
    </div>

    <div class="row">
        <div id="task_cart">
            <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                'title' => Yii::t('app', 'Total Quantity') . ' : ' . $count_item,
                'headerIcon' => 'menu-icon fa fa-tasks',
                'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
            )); ?>

            <table class="table table-bordered table-condensed">
                <tbody>
                <tr>
                    <td><?php echo Yii::t('app', 'Item in Cart'); ?> :</td>
                    <td><?php echo $count_item; ?></td>
                </tr>
                <?php if ($discount_amount > 0) { ?>
                    <tr>
                        <td><?php echo Yii::t('app', 'Sub Total'); ?> :</td>
                        <td><span class="badge badge-info bigger-120"><?php echo Yii::app()->settings->get('site',
                                        'currencySymbol') . number_format($sub_total,
                                        Common::getDecimalPlace(), '.', ','); ?></span></td>
                    </tr>
                    <tr>
                        <td><?php echo $discount_symbol . $discount_amt . ' ' . Yii::t('app', 'Discount'); ?> :</td>
                        <td><span class="badge badge-info bigger-120"><?php echo Yii::app()->settings->get('site',
                                        'currencySymbol') . number_format($discount_amount,
                                        Common::getDecimalPlace(), '.', ','); ?></span></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td><?php echo Yii::t('app', 'Total'); ?> :</td>
                    <td><span class="badge badge-info bigger-120"><?php echo Yii::app()->settings->get('site',
                                    'currencySymbol') . number_format($total,
                                    Common::getDecimalPlace(), '.', ','); ?></span></td>
                </tr>
                </tbody>
            </table>

            <?php if ($count_item <> 0) { ?>
                <div align="right">

                    <?php echo TbHtml::linkButton(Yii::t('app', 'Done'), array(
                        'color' => TbHtml::BUTTON_COLOR_SUCCESS,
                        'size' => TbHtml::BUTTON_SIZE_SMALL,
                        'icon' => 'glyphicon-off white',
                        'url' => Yii::app()->createUrl('ReceivingItem/CompleteRecv/'),
                        'class' => 'complete-recv',
                        'title' => Yii::t('app', 'Complete'),
                    )); ?>
                </div>
            <?php } ?>
            <?php $this->endWidget(); ?> <!--/endtaskwidget-->
        </div>
    </div>
</div>