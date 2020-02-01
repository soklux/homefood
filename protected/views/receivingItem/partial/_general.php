<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'action'=>Yii::app()->createUrl('receivingItem/SetHeader'),
        'id' => 'set-outlet-form',
        'method'=>'post',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>
<div>

    <?php
        $outlet = Yii::app()->receivingCart->getTransferHeader('from_outlet') ? Yii::app()->receivingCart->getTransferHeader('from_outlet') : Yii::app()->session['employee_outlet'];
        $created_date = Yii::app()->receivingCart->getTransferHeader('created_date') ? Yii::app()->receivingCart->getTransferHeader('created_date') : date('Y-m-d');
        $count_time = Yii::app()->receivingCart->getTransferHeader('count_time') ? Yii::app()->receivingCart->getTransferHeader('count_time') : date('H:i:s');
        $count_name = Yii::app()->receivingCart->getTransferHeader('count_name') ? Yii::app()->receivingCart->getTransferHeader('count_name') : 'InventoryCount_'.date('Y-m-d');
    ?>
    <div class="row">
        <!-- <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span>
    <?= Yii::t('app', 'are required'); ?></p> -->
        
        <div class="col-sm-11 col-md-11">
            <div class="col-sm-12 form-group">
                <?php echo CHtml::label('Start Date *', 1, array('class' => 'control-label')); ?>
                <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                        'attribute' => 'created_date',
                        'model' => $model,
                        'pluginOptions' => array(
                            'format' => 'yyyy-mm-dd',
                        ),
                        'htmlOptions'=>array('value'=>$created_date)
                    ));
                ?>
            </div>
        </div>
        <div class="col-sm-11 col-md-11">
            <div class="col-sm-12 form-group">
                <?php echo CHtml::label('Time *', 1, array('class' => 'control-label')); ?>
                <?php echo CHtml::TextField('InventoryCount[count_time]',$count_time,array('class'=>'form-control span10','id'=>'InventoryCount_count_time','value'=>date('H:i:s'))); ?>
            </div>
        </div>
        <div class="col-sm-11 col-md-11">
            <div class="col-sm-12 form-group">
                <?php echo CHtml::label('Count Name *', 1, array('class' => 'control-label')); ?>
                <?php echo CHtml::TextField('InventoryCount[count_name]',$count_name,array('class'=>'form-control','placeholder'=>'hh:mm:ss','id'=>'InventoryCount_count_name')); ?>
            </div>
        </div>
        
    </div>
</div>
<?php $this->endWidget()?>