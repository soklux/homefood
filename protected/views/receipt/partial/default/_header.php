<div class="row">
    <div class="col-xs-5">
        <p>
            <?php if (invIfCompanyLogo()) { ?>
                <?php echo TbHtml::image(Yii::app()->baseUrl . '/images/shop_logo.png','Company\'s logo',array('width'=>'150')); ?> <br>
            <?php } ?>
        </p>
    </div>
    <div class="col-xs-6 col-xs-offset-1 text-right">
        <p>
            <?php if (invIfCompanyName()=='1') { ?>
                <? TbHtml::encode(Yii::app()->settings->get('site', 'companyName')); ?>
            <?php } ?>


            <?php if (invIfCompanyName()=='1') { ?>
                <? TbHtml::encode(Yii::app()->settings->get('site', 'companyNameKH')); ?>
            <?php } ?>

    </div>

    <div align="center">
        <?php if (invIfCompanyAdd1()=='1') { ?>
            <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress')); ?>
        <?php } ?>

        <?php if (invIfCompanyAdd1()=='1') { ?>
            <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress1')); ?>
        <?php } ?>
    </div>
    <div align="center">
        <?php if (invIfCompanyPhone()=='1') { ?>
            <?= TbHtml::encode(Yii::app()->settings->get('site', 'companyPhone')); ?>
        <?php } ?>
    </div>
</div>

<div align="center"> <underline>Invoice</underline> </div>

<div class="row">
    <div class="col-xs-5">
        <p>
            <?= TbHtml::encode('Invoice No: 2018-0000002') ?> <br>
            <?= TbHtml::encode('Date: DD-MON-YYYY') ?> <br>
            <?= TbHtml::encode('Term: COD') ?> <br>
        </p>
    </div>

    <div class="col-xs-5">
        <?= TbHtml::encode('Customer Name: Sok Lux') ?> <br>
        <?= TbHtml::encode('Address: #24D, 69BT, Boeung Tompong') ?> <br>
        <?= TbHtml::encode('Contact Number: 012-797-008') ?> <br>
    </div>
</div>
