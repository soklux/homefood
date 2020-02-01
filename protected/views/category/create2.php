<?php
$this->breadcrumbs=array(
	'Categories'=>array('category/list'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Category','url'=>array('index')),
	array('label'=>'Manage Category','url'=>array('category/list')),
);
?>

<h1>Create Category</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

        <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php echo $form->errorSummary($model); ?>
	<div class="container">
		<div class="col-sm-11 col-md-11">
	        <div class="form-group">
	            <?php echo CHtml::label('Category Name', 1, array('class' => 'control-label')); ?>
	            <?php echo CHtml::TextField('Category',$model['name']!==null ? $model['name'] : '',array('class'=>'form-control','id'=>'Category_Name')); ?>
	            <span id="error" class="errorMsg100000"></span>
	        </div>
	    </div>
	    <div class="col-sm-11 col-md-11">
	        <div class="form-group">
	            <?php echo CHtml::label('Parent', 1, array('class' => 'control-label')); ?>
	            <select class="form-control" id="db-category" onchange="showDialog(event.target.value)">
	            	<option value="">--Choose Parent--</option>
	            	<?php foreach($parent as $key=>$value):?>

	            		<option value="<?=$value['id']?>" <?php echo $model['parent_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
	            	<?php endforeach;?>
	            	<optgroup >
	            		<option value="addnew">
	            			Create New
	            		</option>
	            	</optgroup >
	            </select>
	        </div>
	    </div>
	</div>
	<div class="form-actions">
            <?php echo CHtml::Button($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app',$cateId>0 ? 'Update':'Save'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'onclick'=>@$cateId>0 ? 'saveCategory("","'.@$cateId.'")': 'saveCategory("")',
                'class'=>'btn btn-primary'
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
	</div>
<div id="modal-container"></div>
<?php $this->endWidget(); ?>
<?php $arr = Category::model()->buildTree($parent);?>
<?php $this->renderPartial('partial/_action',array('parent'=>$parent)) ?>