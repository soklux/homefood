<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
<?php
$arr = Category::model()->buildTree($categories);
$option=Category::model()->buildOptions($arr,null);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    //'action'=>$this->createUrl('Item/Create'),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

<?php /*$this->renderPartial('_header', array('model' => $model)) */?>


<div class="col-sm-12">
    <div class="errorMessage" id="formResult"></div>
    <h4 class="header blue">
        <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Basic Information') ?>
    </h4>

    <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span>
        <?= Yii::t('app', 'are required'); ?></p>
        <div class="row">
            
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'name',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_brand"><?= Yii::t('app','Brand') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-brand" name="Item[brand_id]">
                            <option value=""></option>
                            <?php foreach($brand as $key=>$value):?>
                                <option value="<?=$value['id']?>" <?php echo $model['brand_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label>Description</label>
                <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
                    'model'=>$model,
                    'attribute'=>'description',
                    'language'=>'en',
                    'editorTemplate'=>'basic',
                    'htmlOptions'=>array('placeholder'=>'Description')
                )); ?>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="col-sm-1">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tag</label>
            </div>
            <div class="col-sm-11" title="Enter text then press comma(,) or Enter">
                <?php echo $form->textField($model, 'tags', array('class' => 'span3','id'=>'form-field-tags','value'=>Yii::app()->session['tags'],'placeholder'=>'Tag Text')); ?>
            </div>
        </div>
        <h4 class="header blue">
            <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Product Image') ?>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        
                        <?php if(!empty($item_image)):?>
                            <label for="id-input-file-3" class="ace-file-input ace-file-multiple">
                                <input style="display: none;" multiple="multiple" name="image[]" type="file" id="id-input-file-3" />
                                <div  id="item-image">
                                <span class="ace-file-container">
                                     
                                    <?php foreach($item_image as $i=>$image):?>
                                        <span class="ace-file-name" data-file="<?=$image['filename']?>">
                                            <img class="middle" src='<?=Yii::app()->baseUrl.'/ximages/'. strtolower(get_class($model)) . '/' . $model->id.'/'.$image['filename']?>' height="50px">
                                        </span>
                                    <?php endforeach;?>

                                </span>
                                <a class="remove">
                                    <i class=" ace-icon fa fa-times"></i>
                                </a>
                            </div>
                            </label>
                        <?php else:?>
                            <input multiple="multiple" name="image[]" type="file" id="id-input-file-3" />
                        <?php endif;?>
                        <!-- /section:custom/file-input -->
                    </div>
                </div>
            </div>
        </div>
        <h4 class="header blue">
            <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Inventory') ?>
        </h4>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'sku',array('class'=>'span3 txt-barcode','maxlength'=>32,'data-rel'=>'tooltip','title'=>'Stock Keeping Unit(Define product code for internal use)')); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'mpn',array('class'=>'span3 form-control','maxlength'=>255,'data-rel'=>'tooltip','title'=>'Manufacturing Part Number unambiguously identify a part design')); ?>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'item_number',array('class'=>'span3 form-control','maxlength'=>255,'data-rel'=>'tooltip','title'=>'Twelve digit unique number associated with barcode(Universal Product Code)')); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'isbn',array(
                        'class'=>'span3 txt-barcode',
                        'maxlength'=>32,
                        'data-rel'=>'tooltip',
                        'title'=>'Thirteen digit unique commercial book identifier(International Standard Book Number')
                ); ?>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_supplier"><?= Yii::t('app','Supplier') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-supplier" name="Item[supplier_id]">
                            <option value=""></option>
                            <?php foreach($supplier as $key=>$value):?>
                                <option value="<?=$value['id']?>" <?php echo $model['supplier_id']==$value['id'] ? 'selected' : ''?>><?=$value['company_name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldControlGroup($model, 'quantity', array(
                        'class' => 'span3',
                        'data-rel'=>'tooltip',
                        'title'=>'Opening Quantity is refer to quantity of the item on hand before you start tracking inventory for the item in the Peedorify system'
                    )
                );
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_product-type"><?= Yii::t('app','Type') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-product-type" name="Item[type_id]" >
                             <option value=""></option>
                            <?php foreach($product_types as $key=>$value):?>
                                <option value="<?=$value['id']?>" <?php echo $model['type_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_product_model"><?= Yii::t('app','Model') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-product-model" name="Item[model_id]">
                            <option value=""></option>
                            <?php foreach($product_models as $key=>$value):?>
                                <option value="<?=$value['id']?>" <?php echo $model['model_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_category"><?= Yii::t('app','Category') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-category" name="Item[category_id]" onchange="showCategoryDialog(event.target.value)">
                            <option value=""></option>
                            <!-- <?php foreach($categories as $key=>$value):?>

                                <option value="<?=$value['id']?>" <?php echo $model['category_id']==$value['id'] ? 'selected' : ''?>><?= $value['name'] ?></option>
                            <?php endforeach;?> -->
                            <?=Category::model()->buildOptions($arr,$model['category_id'])?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_unit_measurable"><?= Yii::t('app','Unit Of Measurable') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-measurable" name="Item[unit_measurable_id]">
                            <option value=""></option>
                            <?php foreach($measurable as $key=>$value):?>
                                <option value="<?=$value['id']?>" <?php echo $model['unit_measurable_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'reorder_level',array('class'=>'span3 txt-reorder-level pull-right',)); ?>
            </div>
            
        </div>
        <h4 class="header blue">
            <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Pricing') ?>
        </h4>
        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->textFieldControlGroup($model, 'cost_price', array('class' => 'span3')); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->textFieldControlGroup($model, 'markup', array('class' => 'span3','value'=>0)); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->textFieldControlGroup($model, 'unit_price', array('class' => 'span3')); ?>
            </div>
        </div>

    <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
        )); ?>
    </div>

</div>

<?php //$this->renderPartial('partial/_to_refactor'); ?>

<?php $this->endWidget(); ?>

<?php $this->renderPartial('partialList/_measurable_modal',array('measurable'=>$measurable)); ?>
<?php $this->renderPartial('partialList/_supplier_modal',array('supplier'=>$supplier)); ?>
<?php $this->renderPartial('partialList/_brand_modal',array('brand'=>$brand)); ?>
<?php $this->renderPartial('partialList/_product_type_modal',array('product_types'=>$product_types)); ?>
<?php $this->renderPartial('partialList/_product_model_modal',array('product_models'=>$product_models)); ?>

</div>


<script>
    function beforeValidate() {
    var form = $(this);
    if(form.find('.has-error').length) {
            return false;
    }else{
        return true;
    }
}
</script>
<div id="modal-container"></div>
<?php $this->renderPartial('partialList/_action',array('option'=>$option)) ?>

<style type="text/css">
    .margin-top-15{
        margin-left: 15px;
        margin-top: 15px;
    }
    .tag-container{
        display: inline-block;
        height: auto;
        min-height: 35px;
        border-radius: 3px;
        width: 100%;
        border:solid 1px #ccc;
    }
    .tag-box{
        border:none !important;
        float: left;
        width: 200px;
    }
    .tag-item-box{
        float: left;
        height: auto;
    }
    .tag-item{
        padding: 5px;
        background-color: #ccc;
        position: relative;
        float: left;
        top: 0px;
        bottom: 10px;
        margin: 10px 5px 10px 5px !important;
        border-radius: 3px;
    }
    .tags{
        width: 100% !important;
    }
    .tags input[type="text"], .tags input[type="text"]:focus{
        width: 250px !important;
    }
</style>