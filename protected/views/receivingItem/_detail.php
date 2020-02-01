<?php
	$this->breadcrumbs = array(
	    Yii::t('app', ucfirst('inventory count')) => array('index?trans_mode=physical_count'),
	    Yii::t('app', 'List'),
	);
?>
<div class="row">
    <div class="col-xs-12 widget-container-col ui-sortable">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'List of ' . ucfirst('Detail')),
            'headerIcon' => sysMenuItemIcon(),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>
            
            <!-- Flash message layouts.partial._flash_message -->
            <?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
			<?php if($model):?>
				<h2>
					<?=$count_title?>
				</h2>
				<hr>
	            <table class="table">
					<thead>
						<?php foreach($model as $key=>$value):?>
							<tr>
								<?php foreach($value as $col=>$row):?>
									<?php if($col!='id' and $col!='count_id'):?>
										<th>
											<?=strtoupper($col)?>
										</th>
									<?php endif;?>
								<?php endforeach;?>
							</tr>
							<?php break;?>
						<?php endforeach;?>
					</thead>
					<tbody>
						<?php 
							$totalExpected=0;
							$totalCounted=0;
							$totalUnit=0;
							$totalCost=0;
						?>
						<?php foreach($model as $key=>$value):?>
							<tr>
								<?php foreach($value as $col=>$row):?>
									<?php if($col!='id' and $col!='count_id'):?>
										<td>
											<?=$row?>
										</td>
									<?php endif;?>
								<?php endforeach;?>
							</tr>
							<?php
								$totalExpected+=$value['expected'];
								$totalCounted+=$value['counted'];
								$totalUnit+=$value['unit'];
								$totalCost+=$value['cost'];
							?>
						<?php endforeach;?>
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
			<?php endif;?>
        <?php $this->endWidget(); ?>

        

    </div>
</div>