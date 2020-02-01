<!-- Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('db-supplier').value=0" aria-label="Close">
          &times;
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Create Supplier</h5>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <?php echo CHtml::label('Company Name', 1, array('class' => 'control-label')); ?>
              <?php echo CHtml::TextField('Supplier','',array('class'=>'form-control','id'=>'company_name'));?>
              <span id="error" class="errorMsg"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <?php echo CHtml::label('First Name', 1, array('class' => 'control-label')); ?>
              <?php echo CHtml::TextField('Supplier','',array('class'=>'form-control txt-box','id'=>'first_name'));?>
              <span id="error" class="error_first_name"></span>
            </div>
            <div class="col-sm-6">
              <?php echo CHtml::label('Last Name', 1, array('class' => 'control-label')); ?>
              <?php echo CHtml::TextField('Supplier','',array('class'=>'form-control  txt-box','id'=>'last_name'));?>
              <span id="error" class="error_last_name"></span>
            </div>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('db-supplier').value=0" data-dismiss="modal">Close</button>
        <button type="button" id="btn-supplier" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<?php $this->renderPartial('partial/_js',array(
  'btnSave'=>'btn-supplier',
  'name'=>'company_name',
  'first_name'=>'first_name',
  'last_name'=>'last_name',
  'url'=>Yii::app()->createUrl('Supplier/SaveSupplier'),
  'modal'=>'supplierModal',
  'list'=>'db-supplier'
));?>
