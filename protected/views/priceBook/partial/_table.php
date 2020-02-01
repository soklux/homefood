<div class="row">
    <div class="col-sm-12 table-responsive" id="lasted-count">
        <?php if($items):?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Cost</th>
                        <th>Markup<small>(%)</small></th>
                        <th>Discount<small>(%)</small></th>
                        <th>Retail Price<br><small>Exclude Tax</small></th>
                        <th>Min Quantity</th>
                        <th>Max Quantity</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td width="130">
                            <div class="col-sm-12">
                                <input type="text" onchange="updateOnChange('','markupall','')" onkeyup="updateOnEnter('','markupall','')" class="txt-markupall form-control textbox" value="0">
                            </div>
                        </td>
                        <td width="130">
                            <div class="col-sm-12">
                                <input type="text" onchange="updateOnChange('','discountall','')" onkeyup="updateOnEnter('','discountall','')" class="txt-discountall form-control textbox" value="0">
                            </div>
                        </td>
                    </tr>
                    <?php foreach($items as $key=>$value):?>
                        <tr>
                            <td width="30"><?=$value['itemId']?></td>
                            <td><?=$value['name']?></td>
                            <td><?=$value['cost']?></td>
                            <td width="130">
                                <div class="col-sm-12">
                                    <input type="text" onchange="updateOnChange(<?=$value['itemId']?>,'markup',<?=$key?>)" onkeyup="updateOnEnter(<?=$value['itemId']?>,'markup',<?=$key?>)" class="txt-markup<?=$key?> textbox form-control" value="<?=$value['markup']?>">
                                </div>
                            </td>
                            <td width="130">
                                <div class="col-sm-12">
                                    <input type="text" onchange="updateOnChange(<?=$value['itemId']?>,'discount',<?=$key?>)" onkeyup="updateOnEnter(<?=$value['itemId']?>,'discount',<?=$key?>)" class="txt-discount<?=$key?> textbox form-control" value="<?=$value['discount']?>">
                                </div>
                            </td>
                            <td width="130">
                            	<?php
                            	if(($value['discount']<100 and $value['retail_price']>0) or ($value['discount']==100 and $value['retail_price']==0)){
                            		$value['retail_price']=$value['retail_price'];
                            	}else{
                            		$value['retail_price']=$value['cost'];
                            	}
                            		
                            	 ?>
                                <div class="col-sm-12">
                                    <input type="text" onchange="updateOnChange(<?=$value['itemId']?>,'retail_price',<?=$key?>)" onkeyup="updateOnEnter(<?=$value['itemId']?>,'retail_price',<?=$key?>)" class="txt-retail-price<?=$key?> textbox form-control" value="<?=$value['retail_price']?>">
                                </div>
                            </td>
                            <td width="130">
                                <div class="col-sm-12">
                                    <input type="text" onchange="updateOnChange(<?=$value['itemId']?>,'min_qty',<?=$key?>)" onkeyup="updateOnEnter(<?=$value['itemId']?>,'min_qty',<?=$key?>)" class="txt-min-qty<?=$key?> textbox form-control" value="<?=$value['min_qty']<9999 ? $value['min_qty'] : ''?>">
                                </div>
                            </td>
                            <td width="130">
                                <div class="col-sm-12">
                                    <input type="text" onchange="updateOnChange(<?=$value['itemId']?>,'max_qty',<?=$key?>)" onkeyup="updateOnEnter(<?=$value['itemId']?>,'max_qty',<?=$key?>)" class="txt-max-qty<?=$key?> textbox form-control" value="<?=$value['max_qty']<9999 ? $value['max_qty'] : ''?>">
                                </div>
                            </td>
                            <td width="80" align="center">
                                <a class="delete-item btn btn-danger btn-xs" onClick="priceBook(2,<?=$key?>)">
                                    <span class="glyphicon glyphicon glyphicon-trash "></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        <?php endif;?>
    </div>
</div>
<?php $this->renderPartial('partial/_js'); ?>