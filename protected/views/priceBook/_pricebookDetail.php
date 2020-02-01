<?php
	$this->breadcrumbs = array(
	    Yii::t('app', ucfirst('Price Book')) => array('/priceBook/admin'),
	    Yii::t('app', 'View'),
	);
?>
<div class="row">
    <div class="col-xs-12 widget-container-col ui-sortable">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', ucfirst($_GET['name']).' Price Book'),
            'headerIcon' => sysMenuItemIcon(),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
		    'headerButtons' => array(
		        $_GET['name'] =='General' ? '' : TbHtml::buttonGroup(
		            array(
		                array('label' => Yii::t('app','Edit'),'url' => Yii::app()->createUrl('priceBook/EditPriceBook',array('id'=>$_GET['id'])),'icon'=>'fa fa-pencil-square-o white'),
		            ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL,'style'=>ckacc('pricebook.update') ? '' : 'display:none')
		        ),
		    ),
        )); ?>
            
            <!-- Flash message layouts.partial._flash_message -->
            <?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
			<?php if($data):?>
				
				<?php foreach($data as $key=>$header):?>
					<div class="row">
						<div class="col-sm-6">
							<h5>Price Book Name: <strong><?=$header['price_book_name']?></strong></h5>
						</div>
						<div class="col-sm-6">
							<h5>Valid From: <strong><?=$header['valid_from']?></strong></h5>
						</div>
						<div class="col-sm-6">
							<h5>Outlet Name: <strong><?=$header['outlet_name']?></strong></h5>
						</div>
						<div class="col-sm-6">
							<h5>Valid To: <strong><?=$header['valid_to']?></strong></h5>
						</div>
						<div class="col-sm-6">
							<h5>Customer Group: <strong><?=$header['group_name']?></strong></h5>
						</div>
					</div>
					<hr>
					<?php if(isset($header['item'])):?>
						<div class="row">
							<table class="table">
								<thead>
									<?php foreach($header['item'] as $k=>$item):?>
									<tr>
										<?php foreach($item as $col=>$row):?>
											<?php if($col!='id'):?>
												<th><?=strtoupper($col)?></th>
											<?php endif;?>
										<?php endforeach;?>
									</tr>
									<?php break;?>
									<?php endforeach;?>
								</thead>
								<tbody>
									<?php foreach($header['item'] as $k=>$item):?>
										<tr>
											<?php foreach($item as $col=>$row):?>
												<?php if($col=='name'):?>
													<td><a href="<?=Yii::app()->createUrl('item/updateImage')?>/<?=$item['id']?>"><?=$row?></a></td>	
												<?php else:?>
													<?php if($col!='id'):?>
														<td><?=$row?></td>
													<?php endif;?>
												<?php endif?>
											<?php endforeach;?>
										</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div>
					<?php endif;?>
				<?php endforeach;?>
			<?php endif;?>
        <?php $this->endWidget(); ?>

        

    </div>
</div>