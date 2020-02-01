<div class="row row-bordered">
    <div class="col-xs-5">
        <p>
            <?php if (invIfCompanyLogo()) { ?>
                <?= TbHtml::image(Yii::app()->baseUrl . '/images/' . 'thefirst_logo.jpg', companyNameFirstUpper() . '\'s logo',array('width'=>'150')); ?> <br>
            <?php } ?>
        </p>
    </div>
    <div class="col-xs-6 col-xs-offset-1 text-right">
        <p>
            <?php if (invIfCompanyName()) { ?>
                <strong>
                    <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyNameNative')) ?>
                </strong>  <br>
            <?php } ?>

            <?php if (invIfCompanyName()) { ?>
                <strong>
                    <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyName')); ?>
                </strong>  <br>
            <?php } ?>
        </p>
    </div>
</div>

<div class="container text-center">
    <div class="col-lg-4 col-lg-offset-4">
        <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress')); ?>

        <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress1')); ?>
    </div>
    <br>
    <div class="col-lg-4 col-lg-offset-4">
        Te:l <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyPhone')); ?>
    </div>
    <br>
    <div class="col-lg-4 col-lg-offset-4">
        <h4><u>INVOICE</u></h4>
    </div>

</div>
