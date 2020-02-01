<div class="row ">

    <div class="col-xs-5">
        <p>
            <?= Yii::t('app','Customer') . " : ". TbHtml::encode(ucwords($cust_fullname)); ?> <br>
            <?= Yii::t('app','Address') . " : ". TbHtml::encode(ucwords($cust_address1)); ?> <br>
            <?= TbHtml::encode(ucwords($cust_address2)); ?> <br>
            <?= Yii::t('app','Tel') . " : ". TbHtml::encode(ucwords($cust_mobile_no)); ?> <br>

            <?/*= Yii::t('app','Fax') . " : " . $cust_fax; */?><!-- <br>
            <?/*= Yii::t('app','Contact Person') . " : " . ucwords($cust_contact_fullname); */?> <br>-->
        </p>
    </div>
    <div class="col-xs-6 col-xs-offset-1 text-right">
            <?= Yii::t('app','INVOICE No') . " : "  . $invoice_no_prefix . $sale_id; ?> <br>
            <?= TbHtml::encode(Yii::t('app','DATE') . " : ". $transaction_date); ?> <br>
            <?= TbHtml::encode(Yii::t('app','TERM') . " : ". $cust_notes); ?> <br>

            <?php if (invIfSaleRep()) {  ?>

                <?= Yii::t('app','SALE REP') . " : ". $salerep_fullname; ?> <br>
                <?= Yii::t('app','Tel') . " : ".  $salerep_tel; ?> <br>

            <?php } ?>
    </div>

</div>