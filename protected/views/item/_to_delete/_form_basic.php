<div class="col-sm-5">
    <div class="errorMessage" id="formResult"></div>
    <h4 class="header blue">
        <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Basic Information') ?>
    </h4>

    <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span>
        <?= Yii::t('app', 'are required'); ?></p>

    <?= $form->textFieldControlGroup($model,'item_number',array('class'=>'span3','maxlength'=>255)); ?>

    <?= $form->textFieldControlGroup($model,'name',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>

    <?php echo $form->textFieldControlGroup($model, 'cost_price', array('class' => 'span3')); ?>

    <?php echo $form->textFieldControlGroup($model, 'unit_price', array('class' => 'span3')); ?>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="Item_category"><?= Yii::t('app','Category') ?></label>
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
        <label class="col-sm-3 control-label" for="Item_unit_measurable"><?= Yii::t('app','Unit Of Measurable') ?></label>
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

    <?= $form->textFieldControlGroup($model,'reorder_level',array('class'=>'span3 txt-reorder-level',)); ?>

    <?= $form->textFieldControlGroup($model,'location',array('class'=>'span3 txt-location','maxlength'=>20)); ?>

    <?= $form->textAreaControlGroup($model,'description',array('rows'=>2, 'cols'=>10, 'class'=>'span3 txt-description')); ?>

</div>
<div class="col-sm-7">
    <h4 class="header blue">
        <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Stock Information') ?>
    </h4>
</div>