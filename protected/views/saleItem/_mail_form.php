<div class="form">

    <?php $this->renderPartial('//layouts/alert/_flash'); ?>

    <?php $form = $this->beginWidget('\TbActiveForm', array(
        'id' => 'fff',
        'enableAjaxValidation' => false,
        'action' => $this->createUrl('saleItem/sendEmail', array(
            'sale_id' => $_GET['sale_id'],
            'customer_id' => $_GET['customer_id'],
            'tran_type' => $_GET['tran_type'],
            'pdf' => $_GET['pdf'],
            'email' => $_GET['email']
        )),
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <div class="row">
        <div class="col-sm-11">
            <?php echo $form->textFieldControlGroup($model, 'mail_from', array('size' => 60, 'maxlength' => 500, 'class' => 'span3',)); ?>
        </div>
        <div class="col-sm-11">
            <?php echo $form->textFieldControlGroup($model, 'mail_to', array('size' => 60, 'maxlength' => 500, 'class' => 'span3',)); ?>
        </div>
        <div class="col-sm-11">
            <?php echo $form->textFieldControlGroup($model, 'mail_subject', array('size' => 60, 'maxlength' => 500, 'class' => 'span3',)); ?>
        </div>
        <div class="col-sm-11">
            <?php echo $form->textFieldControlGroup($model, 'mail_cc', array('size' => 60, 'maxlength' => 500, 'class' => 'span3',)); ?>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-11">
            <?php echo $form->textAreaControlGroup($model, 'mail_body', array('size' => 60, 'maxlength' => 1000, 'class' => 'span3',)); ?>
        </div>
    </div>
    <div class="mail-box-footer">
        <div class="col-sm-10">
            <?php echo $form->checkBoxControlGroup($model, 'attach_receipt', array('checked' => 'checked', 'value' => 1, 'class' => 'pull-left')); ?>
        </div>
        <div class="col-sm-2">
            <?php echo TbHtml::submitButton(Yii::t('app', 'Send'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'class' => 'pull-right btn-send'
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
        $('.btn-send').click(function () {
            $(this).text('Sending...');
            //$(':input[type="submit"]').prop('disabled', true);
        })
    })
</script>
<style type="text/css">
    #errmsg {
        color: #ff0000;
    }
</style>