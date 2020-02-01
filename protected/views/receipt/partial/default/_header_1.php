<div class="row">
    
	<div class="col-xs-5">
		<p>
			<?php echo Yii::t('app','Customer') . " : ". TbHtml::encode(ucwords($cust_fullname)); ?> <br>
			<?php echo Yii::t('app','Address') . " : ". TbHtml::encode(ucwords($cust_address1)); ?> <br>
			<?php echo TbHtml::encode(ucwords($cust_address2)); ?> <br>
			<?php echo Yii::t('app','Tel') . " : ". TbHtml::encode(ucwords($cust_mobile_no)); ?> <br>
			<?php echo Yii::t('app','Fax') . " : " . $cust_fax; ?> <br>
			<?php echo Yii::t('app','Contact Person') . " : " . ucwords($cust_contact_fullname); ?> <br>
		</p>
	</div>
	<div class="col-xs-6 col-xs-offset-1 text-right">
		<p>
			<?php echo Yii::t('app','INVOICE No') . " : "  . $invoice_no_prefix . $sale_id; ?> <br>
			<?php echo TbHtml::encode(Yii::t('app','DATE') . " : ". $transaction_date); ?> <br>
			<?php echo TbHtml::encode(Yii::t('app','TERM') . " : ". $cust_notes); ?> <br>
			<?php /*echo TbHtml::encode(Yii::t('app','DUE DATE') . " : ". $transaction_date); */?><!-- <br>-->

            <?php if (invIfSaleRep()) {  ?>

                <?php echo Yii::t('app','SALE REP') . " : ". $salerep_fullname; ?> <br>
                <?php echo Yii::t('app','Tel') . " : ".  $salerep_tel; ?> <br>

            <?php } ?>

		</p>
	</div>

    <div class="col-md-2 col-md-offset-5"> <h3>INVOICE</h3></div>

</div>