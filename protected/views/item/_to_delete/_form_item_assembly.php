<?php
$this->breadcrumbs=array(
    sysMenuAssembliesView() =>array('assemblies'),
    'Create',
);
?>
<div class="container">
	<!-- <div class="col-sm-12">
		<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'assembly-form',
			'enableAjaxValidation'=>false,
		)); ?>
			<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
		<div class="col-xs-12 col-sm-10 widget-container-col">
			<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
			        'title'         =>  Yii::t('app','Search Product'),
			        'headerIcon'    => 'ace-icon fa fa-chain',
			        'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small')
			));?>	
			
	        <div class="col-sm-12">
	        	<div class="form-group">
				    <?php
				        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				            'model'=>$model,
				            'attribute'=>'[product]item_id',
				            'source'=>$this->createUrl('request/suggestItem'),
				            'htmlOptions'=>array(
				                'size'=>'35'
				            ),
				            'options'=>array(
				                'showAnim'=>'fold',
				                'minLength'=>'1',
				                'delay' => 10,
				                'autoFocus'=> false,
				                'select'=>'js:function(event, ui) {}'
				            ),
				        ));
		            ?>
	        	</div>
	        </div>
			<?php $this->endWidget()?>
		</div>
		<div class="col-xs-12 col-sm-12">
		    <div id="assembly-item">
				<?php $id=0; foreach($assembly_item as $k=>$item):?>
					<div class="item-<?php echo $item['id'] ?>">
					<div class="row">
						<hr style="width:90%; margin-left:0px;">
					    <div class="col-sm-5">
			                <div class="form-group">
			                	<?php echo CHtml::label('Assembly Name', $k, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::TextField('assembly_item[item'.$item["id"].'][assembly_name]', $item["to_quantity"] !== null ? round($item["to_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item["price"], array('class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
			                </div>
			            </div>
			            <div class="col-sm-2">
			                <div class="form-group">
			                	<?php echo CHtml::label('Quantity', $k, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::NumberField('price_quantity[price_qty'.$item["id"].'][to_quantity]', $item["to_quantity"] !== null ? round($item["to_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item["to_quantity"], array('class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
			                </div>
			            </div>
			            <div class="col-sm-2">
			                <div class="form-group">
			                	<?php echo CHtml::label('Unit Price', $k, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::NumberField('price_quantity[price_qty'.$item["id"].'][unit_price]', $item["unit_price"] !== null ? round($item["unit_price"], Yii::app()->shoppingCart->getDecimalPlace()) : $item["price"], array('step'=>'0.01','class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
			                </div>
			            </div>
			            <div class="col-sm-2"><input type="button" value="X" class="btn btn-danger" onClick="removeAssembly('<?php echo $item["id"]?>')" style="margin-top: 23px;"></div>
			        </div>
			        </div>
				<?php $id=$item["id"]; endforeach;?>
			</div>
			<div class="form-group col-sm-10">
				<?php echo CHtml::Button('Add Assembly',array('class'=>'btn btn-primary pull-right','onClick'=>'addAssembly('.$id.')'))?>
				<?= TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
				    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,'class'=>'btn btn-primary pull-right'
				    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
				));?>
		        
		    </div>
		</div>
    <?php $this->endWidget()?>
	</div> -->
	<div class="col-sm-5">
	    <h4 class="header blue">
	        <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Assembly Information') ?>
	    </h4>
	    <div class="row">
		    <div class="col-sm-12">
                <div class="form-group">
                	<?php echo CHtml::label('Assembly Name', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                	<?php echo CHtml::label('Quantity', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::NumberField('AssemblyItem','',array('class'=>'form-control')); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                	<?php echo CHtml::label('Unit Price', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::NumberField('AssemblyItem','',array('class'=>'form-control','step'=>'0.01')); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                	<?php echo CHtml::label('Mark', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                	<?php echo CHtml::label('Country', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
                </div>
            </div>
	    </div>
	</div>
	<div class="col-sm-6">
	    <h4 class="header blue">
	        <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Part Of Product Information') ?>
	    </h4>
	    <div class="row">
	    	<div id="assembly-item">
	    		<?php if(empty($assembly_item)):?>
	    			<div class="row">
						<div class="col-sm-6">
			                <div class="form-group">
			                	<?php echo CHtml::label('Product Name', 1, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
			                </div>
			            </div>
			            <div class="col-sm-6">
			                <div class="form-group">
			                	<?php echo CHtml::label('Category', 1, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
			                </div>
			            </div>
			            <div class="col-sm-6">
			                <div class="form-group">
			                	<?php echo CHtml::label('Brand', 1, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
			                </div>
			            </div>
			            <div class="col-sm-6">
			                <div class="form-group">
			                	<?php echo CHtml::label('Series', 1, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
			                </div>
			            </div>
					</div>
	    		<?php else:?>
		    		<?php $id=0; foreach($assembly_item as $k=>$item):?>
						<div class="item-<?php echo $item['id'] ?>">
							<div class="row">
								<div class="col-sm-6">
					                <div class="form-group">
					                	<?php echo CHtml::label('Product Name', 1, array('class' => 'control-label')); ?>
					                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
					                </div>
					            </div>
					            <div class="col-sm-6">
					                <div class="form-group">
					                	<?php echo CHtml::label('Category', 1, array('class' => 'control-label')); ?>
					                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
					                </div>
					            </div>
					            <div class="col-sm-6">
					                <div class="form-group">
					                	<?php echo CHtml::label('Brand', 1, array('class' => 'control-label')); ?>
					                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
					                </div>
					            </div>
					            <div class="col-sm-6">
					                <div class="form-group">
					                	<?php echo CHtml::label('Series', 1, array('class' => 'control-label')); ?>
					                    <?php echo CHtml::TextField('AssemblyItem','',array('class'=>'form-control')); ?>
					                </div>
					            </div>
							</div>
						</div>
					<?php $id=$item['id']; endforeach;?>
				<?php endif;?>
	    	</div>
	    	<div class="form-group col-sm-12">
				<?php echo CHtml::Button('Add',array('class'=>'btn btn-primary pull-right','onClick'=>'addAssembly('.$id.')'))?>
		    </div>
	    </div>
	</div>
</div>

<?php $this->renderPartial('partialList/_js'); ?>
