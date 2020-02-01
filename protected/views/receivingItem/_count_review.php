<?php
	$this->breadcrumbs = array(
	    Yii::t('app', ucfirst('inventory count')) => array('inventoryCountCreate'),
	    Yii::t('app', 'Review'),
	);
?>
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Count Inventory'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'headerButtons' => array(
        // TbHtml::buttonGroup(
        //     array(
        //         array('label' => Yii::t('app','Save'),'url' => Yii::app()->createUrl('receivingItem/saveCount'),'icon'=>'fa fa-floppy-o white'),
        //     ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        // ),
    ),
)); ?>
	<h2>
		<?=$header['count_name']?>
	</h2>
	<hr>
	<table class="table">
		<thead>
			<tr>
				<th>Item Name</th>
				<th>Expected</th>
				<th>Counted</th>
				<th title="Unit=Expected-Counted">Unit</th>
				<th>Cost</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$totalExpected=0;
				$totalCounted=0;
				$totalUnit=0;
				$totalCost=0;
			?>
			<?php if(!empty($items)):?>
				<?php foreach($items as $key=>$value):?>
					<tr>
						<td>
							<?=$value['name']?>
						</td>
						<td>
							<?=$value['current_quantity']?>
						</td>
						<td>
							<?=$value['quantity']?>
						</td>
						<td>
							<?php
								$unit=0;
								if($value['current_quantity']<0){
									$unit=-1*($value['quantity'])-$value['current_quantity'];
									$unit=-1*$unit;
								}else{
									$unit=$value['quantity']-$value['current_quantity'];
								}
								echo $unit;
							?>
						</td>
						<td>
							<?php $cost=$unit*$value['cost_price']?>
							<?=$cost?>
						</td>
					</tr>
					<?php
						$totalExpected+=$value['current_quantity'];
						$totalCounted+=$value['quantity'];
						$totalUnit+=$unit;
						$totalCost+=($unit*$value['cost_price']);
					?>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
		<tfoot>
			<tr>
				<th>Total:</th>
				<th><?=$totalExpected?></th>
				<th><?=$totalCounted?></th>
				<th><?=$totalUnit?></th>
				<th><?=$totalCost?></th>
			</tr>
		</tfoot>
	</table>
	
<?php $this->endWidget(); ?>
<?php $this->renderPartial('partial/_footer',array('btn_text'=>'Save','url' => 'receivingItem/saveCount'))?>
