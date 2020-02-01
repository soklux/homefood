<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'client_form',
        'method'=>'post',
        'action' => Yii::app()->createUrl('saleItem/selectCustomer/'),
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
          <?php 
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute'=>'client_id',
                    'source'=>$this->createUrl('request/suggestClient'), 
                    'htmlOptions'=>array(
                        'size'=>'30'
                    ),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength'=>'1',
                        'delay' => 10,
                        'autoFocus'=> false,
                        'select'=>'js:function(event, ui) {
                            event.preventDefault();
                            $("#SaleItem_client_id").val(ui.item.id);
                            $("#client_form").ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});

                        }',
                    ),
                ));
          ?>

        <?php if (ckacc('customer.create')) { ?>

            <?php echo TbHtml::linkButton(Yii::t( 'app', 'New' ),array(
                    'color'=>TbHtml::BUTTON_COLOR_INFO,
                    'size'=>TbHtml::BUTTON_SIZE_SMALL,
                    'icon'=>'glyphicon-plus white',
                    'url'=>$this->createUrl('Client/Create/',array('sale_mode'=>'Y')),
              )); ?>

        <?php } ?>

       
        <!-- <?php if (PriceBook::model()->checkExists()<>0) { ?>
            <p>
                <?= $form->dropDownListControlGroup($model,'price_book_id', PriceBook::model()->getPriceBookSale(),array('id'=>'price_tier_id',
                    'options'=>array(Yii::app()->shoppingCart->getPriceTier()=>array('selected'=>true)),
                    'class'=>'col-xs-10 col-sm-8','empty'=>'None','labelOptions'=>array('label'=>Yii::t('app','Price Book')))); ?>

            </p>
        <?php } ?> -->
      
<?php $this->endWidget(); ?>


