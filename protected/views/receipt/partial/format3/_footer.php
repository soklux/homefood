<div id="footer">
    <div class="space-6"></div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3"><?= t('Prepared By','app') ?> </div>
            <div class="col-xs-3"><?= t('Authorized By','app') ?></div>
            <!--<div class="col-xs-3">Account Process </div>-->
            <div class="col-xs-3"><?= t('Delivered By','app') ?></div>
            <div class="col-xs-3 align-right"><?= t('Received By','app') ?> </div>
        </div>
        <div class="row">
            <div class="col-xs-10"></div>
            <div class="col-xs-2 align-right"><?= TbHtml::encode(ucwords($cust_fullname)); ?></div>
        </div>
    </div>
</div>
