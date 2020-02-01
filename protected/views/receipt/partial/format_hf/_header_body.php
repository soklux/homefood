<div class="row ">

    <div class="col-xs-5 box-left">
        <p>
            <?= Yii::t('app','Customer Name') . " : ". TbHtml::encode(ucwords($cust_fullname)); ?> <br>
            <?= Yii::t('app','Address') . " : ". TbHtml::encode(ucwords($cust_address1 . ' ' . $cust_address2)); ?> <br>
            <?= Yii::t('app','Telephone Number') . " : ". TbHtml::encode(ucwords($cust_mobile_no)); ?> <br>
        </p>
    </div>
    <div class="col-xs-6 col-xs-offset-1 text-right kh-font box-right">
            <?= TbHtml::encode(Yii::t('app','DATE') . " : ". $transaction_date); ?> <br>
            <?= TbHtml::encode(Yii::t('app','Payment Day') . " : " . $transaction_date  ); ?> <br>
            <?= TbHtml::encode('រយៈពេលជំពាក់' . " : " . $payment_term  ); ?> <br>
    </div>

</div>