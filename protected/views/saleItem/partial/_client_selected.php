<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'client_selected_form',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'action'=>Yii::app()->createUrl('saleItem/removeCustomer/'),
)); ?>
 
        <div class="clear">
            <ul class="list-unstyled">
                <li>
                    <strong>
                        <?php echo TbHtml::link(ucwords($cust_fullname.'('.$group_name.')'),$this->createUrl('Client/View/',array('id'=>$customer_id)), array(
                            'class'=>'update-dialog-open-link',
                            'data-update-dialog-title' => Yii::t('app','Customer Information'),
                        )); ?>
                    </strong>
                    <?php echo TbHtml::encode(' ( Balance ' . number_format($acc_balance,Common::getDecimalPlace()) . ' )'); ?>
                </li>
            </ul>
        </div>

        <?php echo TbHtml::linkButton(Yii::t( 'app', 'Edit' ),array(
            'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
            'size'=>TbHtml::BUTTON_SIZE_MINI,
            'icon'=>'glyphicon-edit white',
            'class'=>'btn btn-sm edit-customer',
            'url'=>Yii::app()->createUrl("client/Update/",array("id"=>$customer_id,'sale_mode'=>'Y')),
        )); ?>

        <?php if ($sale_mode=='NEW') { ?>

            <?php echo TbHtml::linkButton(Yii::t( 'app', 'Remove' ),array(
                'color'=>TbHtml::BUTTON_COLOR_WARNING,
                'size'=>TbHtml::BUTTON_SIZE_MINI,
                'icon'=>'glyphicon-remove white',
                'class'=>'btn btn-sm detach-customer',
            )); ?>

        <?php } ?>
        <!-- <?php if (PriceBook::model()->checkExists()<>0) { ?>
            <p>
                <?= $form->dropDownListControlGroup($model,'price_book_id', PriceBook::model()->getPriceBookSale(),array('id'=>'price_tier_id',
                    'options'=>array(Yii::app()->shoppingCart->getPriceTier()=>array('selected'=>true)),
                    'class'=>'col-xs-10 col-sm-8','empty'=>'None','labelOptions'=>array('label'=>Yii::t('app','Price Book')))); ?>

            </p>
        <?php } ?> -->

        <br /> <br />

        <?= $form->dropDownListControlGroup($model,'payment_term', Common::arrayFactory('payment_term'),
                array('id'=>'payment_term_id',
                      'options'=>array($cust_term=>array('selected'=>true)),
                      'class'=>'col-xs-10 col-sm-8',
                      'labelOptions'=>array('label'=>Yii::t('app','Term'))));
        ?>

<?php $this->endWidget(); ?>
