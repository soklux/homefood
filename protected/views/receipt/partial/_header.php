<div class="row">
    <div class="col-xs-5">
        <p>
            <?php if (Yii::app()->settings->get('receipt', 'printcompanyLogo')=='1') { ?>
                <?php echo TbHtml::image(Yii::app()->baseUrl . '/images/shop_logo.png','Company\'s logo',array('width'=>'150')); ?> <br>
            <?php } ?>
        </p>
    </div>
    <div class="col-xs-6 col-xs-offset-1 text-right">
        <p>
            <?php if (Yii::app()->settings->get('receipt', 'printcompanyName')=='1') { ?>
                <strong>
                    <?php echo TbHtml::encode(Yii::app()->settings->get('site', 'companyName')); ?>
                </strong>  <br>
            <?php } ?>

            <?php if (Yii::app()->settings->get('receipt', 'printcompanyPhone')=='1') { ?>
                <?php echo TbHtml::encode(Yii::app()->settings->get('site', 'companyPhone')); ?><br>
            <?php } ?>
            <?php if (Yii::app()->settings->get('receipt', 'printcompanyAddress')=='1') { ?>
                <?php echo TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress')); ?><br>
            <?php } ?>
            <?php if (Yii::app()->settings->get('receipt', 'printcompanyAddress1')=='1') { ?>
                <?php echo TbHtml::encode(Yii::app()->settings->get('site', 'companyAddress1')); ?><br>
            <?php } ?>
            <?php if (Yii::app()->settings->get('receipt', 'printtransactionTime')=='1') { ?>
                <?php echo TbHtml::encode($transaction_time); ?><br>
            <?php } ?>
        </p>
    </div>
</div>