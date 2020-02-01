<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'outlet-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>true,
            'validateOnType'=>true,
        ),
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <div class="col-sm-6">
        <h4 class="header blue"><i class="ace-icon fa fa-info-circle blue"></i><?php echo Yii::t('app',
                'Outlet Basic Information') ?></h4>

        <p class="help-block">Fields with <span class="required">*</span> are required.</p>

            <?= $form->textFieldControlGroup($model, 'outlet_name', array('class' => 'span3', 'maxlength' => 128)); ?>

            <?= $this->renderPartial('//address/_address',array('model'=> $model ,'form' => $form)) ?>

            <?= $form->textFieldControlGroup($model, 'state', array('class' => 'span3', 'maxlength' => 128)); ?>

            <?= $form->textFieldControlGroup($model, 'postcode', array('class' => 'span3', 'maxlength' => 10)); ?>


            <?= $form->textFieldControlGroup($model,'email',array('class'=> 'span3','maxlength'=>128)); ?>

            <?= $form->textFieldControlGroup($model,'phone',array('class'=> 'span3','maxlength'=>32)); ?>

    </div>

    <div class="col-sm-6">

        <h4 class="header blue"><i class="ace-icon fa fa-info-circle blue"></i><?php echo Yii::t('app',
                'Out Settings') ?></h4>

            <?php //echo $form->textFieldControlGroup($model,'tax_id',array('class'=> 'span3')); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="Item_unit_measurable"><?= Yii::t('app','Default Sale Tax') ?></label>
                <div class="col-sm-9">
                    <select class="form-control" id="db-measurable" name="Outlet[tax_id]" onchange="showMeasurableDialog(event.target.value)">
                        <option value="">Choose Tax</option>
                        <?php foreach($tax as $key => $value):?>
                            <option value="<?=$value['id']?>" <?= $model['tax_id']==$value['id'] ? 'selected' : ''?>><?= $value['tax_name'] ?></option>
                        <?php endforeach;?>
                        <optgroup >
                            <option value="addnew">
                                Create New
                            </option>
                        </optgroup >
                    </select>
                </div>
            </div>

        <div class="form-actions">
            <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                //  'size'=>TbHtml::BUTTON_SIZE_LARGE,
            )); ?>
        </div>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->