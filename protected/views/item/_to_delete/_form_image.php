<style>
#imagePreview {
    width: 150px;
    height: 150px;
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    display: inline-block;
}
</style>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php endif; ?> 

<div id="user-profile-3">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
        'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php //echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldControlGroup($model,'item_number',array('class'=>'span3','maxlength'=>255)); ?>

        <?php echo $form->textFieldControlGroup($model,'batch_number',array('class'=>'span3','maxlength'=>255)); ?>

	<?php echo $form->textFieldControlGroup($model,'name',array('class'=>'span3','maxlength'=>100)); ?>
        
        <div class="unittype-wrapper" style="display:none">    
            <?php //echo $form->textFieldControlGroup($model,'sub_quantity',array('class'=>'span2','prepend'=>'$')); ?>
        </div>
        
        <?php echo $form->textFieldControlGroup($model,'cost_price',array('class'=>'span3')); ?>

	<?php echo $form->textFieldControlGroup($model,'unit_price',array('class'=>'span3')); ?>
        
        <?php foreach($price_tiers as $i=>$price_tier): ?>
            <div class="form-group">
                <?php echo CHtml::label($price_tier["tier_name"] . ' Price' , $i, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
                <div class="col-sm-9">
                    <?php echo CHtml::TextField(get_class($model) . 'Price[' . $price_tier["tier_id"] . ']',$price_tier["price"]!==null ? round($price_tier["price"],Yii::app()->shoppingCart->getDecimalPlace()) : $price_tier["price"],array('class'=>'span3 form-control')); ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php //echo $form->textFieldControlGroup($model,'quantity',array('class'=>'span3')); ?>
        
        <?php //echo $form->textFieldControlGroup($model,'promo_price',array('class'=>'span3')); ?>
        
        <?php //echo $form->textFieldControlGroup($model,'promo_start_date',array('class'=>'span3')); ?>
        
        <?php //echo $form->textFieldControlGroup($model,'promo_end_date',array('class'=>'span3')); ?>
        
        <!--
        <div class="form-group">
            <label class="col-sm-3 control-label" for="Item_item_number">Promotion Start</label>
            <div class="col-sm-9">
            <?php //$this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('model'=>$model,'attribute' =>'promo_start_date','pluginOptions' => array('format' => 'dd/mm/yyyy'),'htmlOptions'=>array('class'=>'span3 form-control'))); ?>
            </div>
        </div>
        
        <!--
        <div class="form-group">
            <label class="col-sm-3 control-label" for="Item_item_number">Promotion End</label>
            <div class="col-sm-9">
            <?php //$this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('model'=>$model,'attribute' =>'promo_end_date','pluginOptions' => array('format' => 'dd/mm/yyyy'),'htmlOptions'=>array('class'=>'span3 form-control'))); ?>
            </div>
        </div>
        -->
        
        <?php //echo $form->dropDownListControlGroup($model,'category_id', Category::model()->getCategory(),array('class'=>'span3','prompt'=>'-- Select --')); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="Item_category"><?php echo Yii::t('app','Category') ?></label>
                 <div class="col-sm-9">
                <?php 
                $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'asDropDownList' => false,
                    'model'=> $model, 
                    'attribute'=>'category_id',
                    'pluginOptions' => array(
                            'placeholder' => Yii::t('app','Category'),
                            'multiple'=>false,
                            'width' => '50%',
                            //'tokenSeparators' => array(',', ' '),
                            'allowClear'=>true,
                            //'minimumInputLength'=>1,
                            'ajax' => array(
                                'url' => Yii::app()->createUrl('category/GetCategory2/'), 
                                'dataType' => 'json',
                                'cache'=>true,
                                'data' => 'js:function(term,page) {
                                            return {
                                                term: term, 
                                                page_limit: 10,
                                                quietMillis: 100, 
                                                apikey: "e5mnmyr86jzb9dhae3ksgd73" 
                                            };
                                        }',
                                'results' => 'js:function(data,page){
                                    return { results: data.results };
                                 }',
                            ),
                            'initSelection' => "js:function (element, callback) {
                                    var id=$(element).val();
                                    if (id!=='') {
                                        $.ajax('".$this->createUrl('/category/initCategory')."', {
                                            dataType: 'json',
                                            data: { id: id }
                                        }).done(function(data) {callback(data);}); //http://www.eha.ee/labs/yiiplay/index.php/en/site/extension?view=select2
                                    }
                            }",
                            'createSearchChoice' => 'js:function(term, data) {
                                if ($(data).filter(function() {
                                    return this.text.localeCompare(term) === 0;
                                }).length === 0) {
                                    return {id:term, text: term, isNew: true};
                                }
                            }',
                            'formatResult' => 'js:function(term) {
                                if (term.isNew) {
                                    return "<span class=\"label label-important\">New</span> " + term.text;
                                }
                                else {
                                    return term.text;
                                }
                            }',
                    )));
                ?>
                 </div>
        </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="Item_unit_measurable"><?php echo Yii::t('app','Unit Of Measurable') ?></label>
        <div class="col-sm-9">
            <?php
            $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                'asDropDownList' => false,
                'model'=> $model,
                'attribute'=>'unit_measurable_id',
                'pluginOptions' => array(
                    'placeholder' => Yii::t('app','Unit Of Measurable'),
                    'multiple'=>false,
                    'width' => '50%',
                    //'tokenSeparators' => array(',', ' '),
                    'allowClear'=>true,
                    //'minimumInputLength'=>1,
                    'ajax' => array(
                        'url' => Yii::app()->createUrl('unitMeasurable/GetUnitMeasurable2/'),
                        'dataType' => 'json',
                        'cache'=>true,
                        'data' => 'js:function(term,page) {
                                            return {
                                                term: term,
                                                page_limit: 10,
                                                quietMillis: 100,
                                                apikey: "e5mnmyr86jzb9dhae3ksgd73"
                                            };
                                        }',
                        'results' => 'js:function(data,page){
                                    return { results: data.results };
                                 }',
                    ),
                    'initSelection' => "js:function (element, callback) {
                                    var id=$(element).val();
                                    if (id!=='') {
                                        $.ajax('".$this->createUrl('/unitMeasurable/InitUnitMeasurable')."', {
                                            dataType: 'json',
                                            data: { id: id }
                                        }).done(function(data) {callback(data);});
                                    }
                            }",
                    'createSearchChoice' => 'js:function(term, data) {
                                if ($(data).filter(function() {
                                    return this.text.localeCompare(term) === 0;
                                }).length === 0) {
                                    return {id:term, text: term, isNew: true};
                                }
                            }',
                    'formatResult' => 'js:function(term) {
                                if (term.isNew) {
                                    return "<span class=\"label label-important\">New</span> " + term.text;
                                }
                                else {
                                    return term.text;
                                }
                            }',
                )));
            ?>
        </div>
    </div>
        
        <?php //echo $form->dropDownListControlGroup($model,'supplier_id', Supplier::model()->getSupplier(),array('class'=>'span3','prompt'=>'-- Select --')); ?>
        
	<?php echo $form->textFieldControlGroup($model,'reorder_level',array('class'=>'span3')); ?>

	<?php echo $form->textFieldControlGroup($model,'location',array('class'=>'span3','maxlength'=>20)); ?>

	<?php //echo $form->textFieldControlGroup($model,'allow_alt_description',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldControlGroup($model,'is_serialized',array('class'=>'span4')); ?>
        
		<!--
        <div class="form-group">
            <label class="col-sm-3 control-label required" for="Item_unit_price"></label>
            <div class="col-sm-9">
                <div id="imagePreview">
                    <img alt="140x140" src=<?php //echo Yii::app()->baseUrl . '/images/profile-pic.jpg'; ?> width="140px" height="140px" />
                </div>
                <?php //echo $form->fileField($model, 'image'); ?>
                <input id="Item_image" type="file" name="image" class="img" />
            </div>
        </div>
		-->
        <?php //echo $form->fileFieldControlGroup($model, 'image'); ?>
      
	<?php echo $form->textAreaControlGroup($model,'description',array('rows'=>2, 'cols'=>10, 'class'=>'span3')); ?>
        
        <?php if (Yii::app()->settings->get('item', 'itemExpireDate')=='1') { ?>
            <?php echo $form->checkBoxControlGroup($model, 'is_expire', array()); ?>

        <?php } ?>
        
         <?php //echo $form->dropDownListControlGroup($model,'count_interval', Item::itemAlias('stock_count_interval'),array('class'=>'span3','prompt'=>'-- Select --')); ?>
        
	<?php //echo $form->textFieldControlGroup($model,'status',array('class'=>'span4')); ?>

	<div class="form-actions">
                 <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
		)); ?>
	</div>

<?php $this->endWidget(); ?>
        

<?php Yii::app()->clientScript->registerScript('setFocus',  '$("#Item_item_number").focus();'); ?>
        
</div>

 <script>
 $("form").submit(function () {
      if($(this).data("allreadyInput")){
            return false;
      }else{
        $("input[type=submit]", this).hide();
        $(this).data("allreadyInput", true);
        // regular checks and submit the form here
      }
});
 </script>
 
 <script type="text/javascript">
 $(function() { 
    $("#Item_image").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});
</script>

<script>
    $(document).ready(function () {
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2000);
    });
</script>


 

