
<?php 
$num=12;
for($i=0;$i<$num;$i++):?>
<?php
	/* if multiple barcodes make sure itemId is unique*/
	$optionsArray = array(
		'itemId'=> 'id_'.$i, /*id for div or canvas */
		'barocde'=> $model[0]['item_number'], /* value for EAN 13 be careful to set right values for each barcode type */
		'type'=>'code39',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
		'settings'=>array(
		   'output'=>'css' /*css, bmp, canvas note- bmp and canvas incompatible wtih IE*/,
		   /*if the output setting canvas*/
		   'posX' => 0,
		   'posY' => 0,
		   /* */
		   'bgColor'=>'#ffffff', /*background color*/
		   'color' => '#333', /*"1" Bars color*/
		   'barWidth' => 1,
		   'barHeight' => 40,   
		   /*-----------below settings only for datamatrix--------------------*/
		   'moduleSize' => 1,
		   'addQuietZone' => 0, /*Quiet Zone Modules */
		 ),
		'rectangular'=> true /* true or false*/
	);
?>
<div class="col-xs-6 col-sm-2 col-md-2" style="border: solid 1px #333;">
	<small><?=substr($model[0]['name'],0,20)?>...</small><br>
	<small>Price: <?=$model[0]['unit_price']?></small><br>
		<?=Item::getItemBarcode($optionsArray)?>
</div>
<?php endfor;?>

