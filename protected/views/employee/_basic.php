<?= $form->textFieldControlGroup($model, 'last_name', array('class' => 'span10', 'maxlength' => 50, 'data-required' => 'true')); ?>

<?= $form->textFieldControlGroup($model, 'first_name', array('class' => 'span10', 'maxlength' => 50, 'data-required' => 'true')); ?>

<?= $form->textFieldControlGroup($model, 'mobile_no', array('class' => 'span10', 'maxlength' => 15)); ?>

<?= $form->dropDownListControlGroup($model, 'report_to', Employee::model()->getEmployee(), array(
        'class' => 'span3',
        'empty' => Yii::t('app', 'Select Supervisor'),
    )
); ?>

<div class="form-group">

    <label class="col-sm-3 control-label"
           for="Employee_dob"><?= Yii::t('app', 'Date of Birth') ?></label>

    <div class="col-sm-9">

        <?= CHtml::activeDropDownList($model, 'day', Employee::itemAlias('day'), array('prompt' => yii::t('app', 'Day'))); ?>

        <?= CHtml::activeDropDownList($model, 'month', Employee::itemAlias('month'), array('prompt' => yii::t('app', 'Month'))); ?>

        <?= CHtml::activeDropDownList($model, 'year', Employee::itemAlias('year'), array('prompt' => yii::t('app', 'Year'))); ?>

        <span class="help-block"> <?= $form->error($model, 'dob'); ?> </span>
    </div>

</div>

<?= $form->textFieldControlGroup($model, 'email', array('class' => 'span10', 'maxlength' => 30, 'data-type' => 'email')); ?>

<?= $form->textAreaControlGroup($model, 'notes', array('rows' => 2, 'cols' => 20, 'class' => 'span10')); ?>