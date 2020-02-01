<!-- Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('db-brand').value=0" aria-label="Close">
          &times;
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Create Brand</h5>
      </div>
      <div class="modal-body">
        <?php echo CHtml::label('Name', 1, array('class' => 'control-label')); ?>
        <?php echo CHtml::TextField('Brand','',array('class'=>'form-control txt-box','id'=>'Brand_Name'));?>
        <span id="error" class="errorMsg"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('db-brand').value=0" data-dismiss="modal">Close</button>
        <button type="button" id='btn-brand' class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<?php $this->renderPartial('partial/_js',array(
  'btnSave'=>'btn-brand',
  'name'=>'Brand_Name',
  'url'=>Yii::app()->createUrl('Brand/SaveBrand'),
  'modal'=>'brandModal',
  'list'=>'db-brand'
));?>