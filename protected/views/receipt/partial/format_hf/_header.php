<div class="row row-bordered" style="width: 100% !important;">

    <div class="col-xs-5 box-left">
        <p class="kh-font">
            <?= 'ឈ្មោះអ្នកលក់ ' .  " ៖ ". TbHtml::encode($salerep_fullname); ?> <br>
        </p>
    </div>

    <div class="col-xs-6 col-xs-offset-1 text-right box-right">
        <p>
            <?= Yii::t('app','Telephone Number') . " : ". TbHtml::encode(Yii::app()->settings->get('site', 'companyPhone')); ?> <br>
        </p>
    </div>

</div>

<div class="container text-center border-gray">
    <div class="col-lg-4 col-lg-offset-4">
        <h2 style="width:100%;text-align: center;"><span class="kh-font"><?=$receipt_header_title_kh?></span> <br>
            <?=$receipt_header_title_en?></h2>
    </div>
</div>
