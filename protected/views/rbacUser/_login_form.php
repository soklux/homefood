<?php echo $form->textFieldControlGroup($user,'user_name',array('class'=>'span8','maxlength'=>60,'placeholder'=>'User name', 'autocomplete'=>'off','data-required'=>'true','disabled' => $disabled)); ?>

<?php if ($model->isNewRecord) { ?>

    <?php echo $form->passwordFieldControlGroup($user,'Password',array('class'=>'span8','maxlength'=>128,'placeholder'=>'User Password','autocomplete'=>'off')); ?>

    <?php echo $form->passwordFieldControlGroup($user,'PasswordConfirm',array('class'=>'span8','maxlength'=>128, 'placeholder'=>'Password Confirm','autocomplete'=>'off')); ?>

    <?php //echo $form->dropDownListControlGroup($model, 'location', Location::model()->getLocationChk(),array('class'=>'ace-checkbox-2')); ?>

<?php } elseif (Yii::app()->user->isAdmin) { ?>
    <?php echo $form->passwordFieldControlGroup($user,'ResetPassword',array('class'=>'span8','maxlength'=>128,'placeholder'=>'User Password','autocomplete'=>'off')); ?>
<?php } ?>

<?php //if ($n_location>1) { ?>
<?php //echo $form->inlineCheckBoxListControlGroup($model, 'visit_location', Location::model()->getLocationChk(),array('class'=>'ace-checkbox-2')); ?>
<?php //} ?>

<?php //echo $form->textFieldControlGroup($user,'employee_id',array('class'=>'span5')); ?>