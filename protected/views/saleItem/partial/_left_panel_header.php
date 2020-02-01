<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
    'title'         =>  $sale_header,
    'headerIcon'    => $sale_header_icon,
    'headerButtons' => array(
        TbHtml::buttonGroup(
            array(
                    /*array('label' => Yii::t('app',$sale_header),
                        'url' =>Yii::app()->createUrl('SaleItem/list'),
                        'icon'=>'ace-icon fa fa-eye'),*/
                //array('label'=>' | '),
                array('label' => Yii::t('app','New Item'),
                    'url' =>Yii::app()->createUrl('Item/create',array('grid_cart'=>'S')),
                    'icon'=>'ace-icon fa fa-plus white',
                    'visible' => ckacc('item.create')
                ),
            ),array('color' => $color_style,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        ),
    ),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));
?>
    <div class="widget-main">
        <div id="itemlookup" class="col-xs-12 col-sm-10">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('saleItem/add'),
                'method'=>'post',
                'layout'=>TbHtml::FORM_LAYOUT_INLINE,
                'id'=>'add_item_form',
            )); ?>

            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$model,
                'attribute'=>'item_id',
                'source'=>$this->createUrl('request/suggestItem'),
                //'scriptFile'=>'',
                //'scriptUrl'=> Yii::app()->theme->baseUrl.'/js/',
                'htmlOptions'=>array(
                    'size'=>'35'
                ),
                'options'=>array(
                    'showAnim'=>'fold',
                    'minLength'=>'1',
                    'delay' => 10,
                    'autoFocus'=> false,
                    'select'=>'js:function(event, ui) {
                            event.preventDefault();
                            $("#SaleItem_item_id").val(ui.item.id);
                            $("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: qtyScannedSuccess(ui.item.id)});                        }',
                    //'search' => 'js:function(){ $(".waiting").show(); }',
                    //'open' => 'js:function(){ $(".waiting").hide(); }',
                ),
            ));
            ?>

            <?php /*echo $form->dropDownList($model,'employee_id', Employee::model()->getEmpRep($employee_id),
                array(
                    'id'=>'sale_rep_id',
                    'prompt' => ' - Select Sale Representative -',
                    'options'=>array(Yii::app()->shoppingCart->getSaleRep()=>array('selected'=>true),
                    ))
            );*/?>

            <?php /* echo TbHtml::linkButton('',array(
                'color'=>TbHtml::BUTTON_COLOR_INFO,
                'size'=>TbHtml::BUTTON_SIZE_SMALL,
                'icon'=>'glyphicon-hand-up white',
                'url'=>$this->createUrl('Item/SelectItem/'),
                'class'=>'update-dialog-open-link',
                'data-update-dialog-title' => Yii::t('app','select items'),
            )); */ ?>

            <?php $this->endWidget(); ?>
        </div>

        <div class="col-xs-12 col-sm-2" id="cancel_cart">
            <?php if ($count_item <> 0) { ?>
                <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'suspend_sale_form',
                    'action' => Yii::app()->createUrl('saleItem/cancelSale/'),
                    'enableAjaxValidation' => false,
                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
                ));
                ?>
                    <?php
                    echo TbHtml::linkButton(Yii::t('app', ''), array(
                        'color' => TbHtml::BUTTON_COLOR_DANGER,
                        'size' => TbHtml::BUTTON_SIZE_SMALL,
                        'icon' => 'bigger-140 fa fa-trash',
                        'url' => Yii::app()->createUrl('saleItem/cancelSale/'),
                        'class' => 'cancel-sale',
                        'id' => 'cancel_sale_button',
                        //'title' => Yii::t('app', 'Cancel Sale'),
                    ));
                    ?>
                <?php $this->endWidget(); ?>
            <?php } ?>
        </div>

    </div>

<?php $this->endWidget(); ?>