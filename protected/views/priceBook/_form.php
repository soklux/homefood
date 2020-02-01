<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    'action'=>$this->createUrl('PriceBook/SavePriceBook/'.@$_GET['id']),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
        'beforeValidate'=>"js:beforeValidate()",
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data')
)); ?>

<div>
    <!-- <?=print_r($_SESSION['pricebookHeader'])?> -->
    <h4>General</h4>  
    <hr> 
    <div class="container">
        <div class="row">
            <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span>
        <?= Yii::t('app', 'are required'); ?></p>
            <div class="col-sm-11 col-md-6">
                <div class="form-group">
                    <?php echo CHtml::label('Name *', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('PriceBook[price_book_name]',isset($_SESSION['pricebookHeader']) ? $_SESSION['pricebookHeader']['name'] : '',array('class'=>'form-control','id'=>'PriceBook_name','value'=>date('H:i:s'))); ?>
                    <span style="color:#f00;"><?=@$_GET['status']=='error' ? $_GET['name']=='' ? 'Field name is rquired' : 'Price book name '.@$_GET['name'].' already taken!' : ''?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-11 col-md-3">
                <div class="form-group">
                    <?php echo CHtml::label('Customer Group', 1, array('class' => 'control-label')); ?>
                    <select name='PriceBook[group_id]' class="form-control" id="db-group">
                        <?php foreach($customer_group as $key=>$value):?> 

                            <?php if($value['id']==@$_SESSION['pricebookHeader']['customer_group']):?>

                                <option value="<?=$value['id']?>" selected><?=$value['group_name']?></option>

                            <?php else:?>

                                <option value="<?=$value['id']?>"><?=$value['group_name']?></option>

                            <?php endif;?>

                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="col-sm-11 col-md-3 margin-left-10">
                <div class="form-group">
                    <?php echo CHtml::label('Outlet', 1, array('class' => 'control-label')); ?>
                    <select name='PriceBook[outlet_id]' class="form-control" id="db-outlet">
                        <?php foreach($outlet as $key=>$value):?>

                            <?php if($value['id']== @$_SESSION['pricebookHeader']['outlet']):?>

                                <option value="<?=$value['id']?>" selected><?=$value['outlet_name']?></option>

                            <?php else:?>

                                <option value="<?=$value['id']?>"><?=$value['outlet_name']?></option>

                            <?php endif;?>

                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>   
        <div class="row"> 
            <div class="col-sm-11 col-md-3">
                <div class="form-group">
                    <?php echo CHtml::label('Valid From', 1, array('class' => 'control-label')); ?>
                    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                            'attribute' => 'start_date',
                            'model' => $model,
                            'pluginOptions' => array(
                                'format' => 'yyyy-mm-dd',
                            ),
                            'htmlOptions'=>array('value'=>isset($_POST['PiceBook']['start_date']) ? $_POST['PiceBook']['start_date'] : isset($_SESSION['pricebookHeader']['start_date']) ? $_SESSION['pricebookHeader']['start_date'] : date('Y-m-d H:i:s'))
                        ));
                    ?>
                </div>
            </div>
            <div class="col-sm-11 col-md-3 margin-left-10">
                <div class="form-group">
                    <?php echo CHtml::label('Valid To', 1, array('class' => 'control-label')); ?>
                    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                            'attribute' => 'end_date',
                            'model' => $model,
                            'pluginOptions' => array(
                                'format' => 'yyyy-mm-dd',
                            ),
                            'htmlOptions'=>array('value'=>isset($_POST['PiceBook']['end_date']) ? $_POST['PiceBook']['end_date'] : isset($_SESSION['pricebookHeader']['end_date']) ? $_SESSION['pricebookHeader']['end_date'] : date('2050-12-30 00:00:00'))
                        ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div class="row">
        <div class="col-sm-12">
            <h4>Items</h4>  
            <hr> 
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="col-sm-5 margin-3">
                            <div class="form-group">
                                <input type="hidden" class="txt-pro-id">
                                <label>Search Product</label>
                                <?php 
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'id',
                                            'source'=>$this->createUrl('request/suggestItemRecv'),
                                            'htmlOptions'=>array(
                                                'size'=>'10',
                                                'class'=>'txt-pro-name form-control',
                                                'onfocus'=>'this.select();'
                                            ),
                                            'options'=>array(
                                                'showAnim'=>'fold',
                                                'minLength'=>'1',
                                                'delay' => 10,
                                                'autoFocus'=> false,
                                                'select'=>'js:function(event, ui) {
                                                    event.preventDefault();
                                                    $(".btn-count").prop("disabled",false);
                                                    $(".txt-pro-name").val(ui.item.value);
                                                    $(".txt-pro-id").val(ui.item.id);
                                                    priceBook(1,"")
                                                }',
                                            ),
                                        ));
                                    ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?php echo CHtml::Button('Add',array('class'=>'btn btn-primary btn-count','onClick'=>'priceBook(1,"")','style'=>'margin-top:20px;'))?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->renderPartial('partial/_table', array(
                'model'=>$model,
                'outlet'=>$outlet,
                'items'=>$items,
                'customer_group'=>$customer_group,
            )); ?>

            <!--<div class="row">
                <div class='col-sm-12'>
                    <input type="button" class="btn btn-primary pull-right" onclick="form.submit()" value="Save">
                </div>
            </div>-->

            <div class="form-actions">
                <?php echo TbHtml::submitButton(isset($_GET['id']) ? Yii::t('app','Save') : Yii::t('app','Create'),array(
                    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
                    'onClick'=> 'form.submit()'
                )); ?>
            </div>

        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<style type="text/css">
    .margin-3{
        margin:0px 3px 0px 3px;
    }
    .border-bottom-1{
        border-bottom: solid 1px #f5f5f5;
    }
    .margin-left-10{
        margin-left: 10px !important; 
    }
</style>