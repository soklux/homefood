<div class="row">
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

<div class="row row-bordered">

    <div class="col-xs-5">
        <p>
            <?= Yii::t('app','លេខអត្តសញ្ញាណកម្ម(VAT TIN)') . " : ". TbHtml::encode(Yii::app()->settings->get('site', 'vatIn')); ?> <br>
            <?= Yii::t('app','អាសយដ្ឋាន') . " : ". TbHtml::encode(Yii::app()->settings->get('site', 'companyAddressNative')); ?> <br>
            <?= Yii::t('app','Address') . " : ". TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress')); ?> <br>
            <?= Yii::t('app','City/District/Khan') . " : "; ?> <br>
            <?= 'អ៊ីម៉ែល' . " : ". Yii::app()->settings->get('site', 'email'); ?> <br>
        </p>
    </div>

    <div class="col-xs-3">
        <p>
            <?= '' ?> <br>
            <?= 'ផ្លូវ' . " : ". Yii::app()->settings->get('site', 'companyAddressHouseNative'); ?> <br>
            <?= Yii::t('app','Street') . " : " . '261' ?> <br>
            <?= Yii::t('app','Province/City') . " : ". 'Phnom Penh'; ?> <br>
        </p>
    </div>

    <div class="col-xs-3 col-xs-offset-1 text-right">
        <p>
            <?= 'វិកយបត្រអាករ' ?> <br>
            <?= 'ឃុំ / សង្កាត់' . " : " . 'បឹងសាឡាង'; ?> <br>
            <?= Yii::t('app','Commune/Sangkat') . " : " . 'Boengsalang'; ?> <br>
            <?= Yii::t('app','Tel') . " : ". TbHtml::encode(Yii::app()->settings->get('site', 'companyPhone')); ?> <br>
        </p>
    </div>

</div>

<div class="container text-center">
    <div class="col-lg-4 col-lg-offset-4">
        <h4><u class="receipt-title-kh-font">វិកយបត្រអាករ</u></h4>
    </div>
    <div class="col-lg-4 col-lg-offset-4">
        <h4><u>TAX INVOICE</u></h4>
    </div>

</div>
