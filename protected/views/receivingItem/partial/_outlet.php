<div class="col-sm-12 form-group">

        <?php $outlet = Yii::app()->receivingCart->getTransferHeader('outlet') ? Yii::app()->receivingCart->getTransferHeader('outlet') : Yii::app()->session['employee_outlet'];?>
        <?php 
            if(isset($label) && $label==true){ 
                echo CHtml::label('Select Outlet', 1, array('class' => 'control-label'));
            } 
        ?>
        <?php echo $form->dropDownList($model,'outlet', 
            CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),
            array(
                //'empty'=>'All Outlet',
                'id'=>'outlet',
                'options' => array($outlet=>array('selected'=>'selected'))
            )
        ); ?>
        <?php echo $form->error($model,'to_outlet'); ?>

</div>