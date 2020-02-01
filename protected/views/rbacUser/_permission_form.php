<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_items"><?php echo Yii::t('app','Item'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'items',Authitem::model()->getAuthItemItem(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_items"><?php echo Yii::t('app','Category'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'categories',Authitem::model()->getAuthItem('category'), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_sales"><?php echo Yii::t('app','Sale'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'sales',Authitem::model()->getAuthItem('sale'), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_payments"><?php echo Yii::t('app','Payment'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'payments',Authitem::model()->getAuthItem(''), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<!--<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_invoices"><?php /*echo Yii::t('app','Sale Invoices'); */?></label>
    <div class="col-sm-9">
        <?php /*echo CHtml::activeCheckboxList($user, 'invoices',Authitem::model()->getAuthItemInvoice(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); */?>
    </div>
</div>
-->

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_employees"><?php echo Yii::t('app','Employee'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'employees',Authitem::model()->getAuthItemEmployee(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_customers"><?php echo Yii::t('app','Customer'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'customers',Authitem::model()->getAuthItem('customer'), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_payments"><?php echo Yii::t('app','Supplier'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'suppliers',Authitem::model()->getAuthItemSupplier(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_receivings"><?php echo Yii::t('app','Inventory'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'receivings',Authitem::model()->getAuthItem('stock'), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_receivings"><?php echo Yii::t('app','Inventory'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'receivings',Authitem::model()->getAuthItem('stock'), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_store"><?php echo Yii::t('app','Store'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'store',Authitem::model()->getAuthItemStore(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_reports"><?php echo Yii::t('app','Report'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'reports',Authitem::model()->getAuthItemReport(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label" for="RbacUser_reports"><?php echo Yii::t('app','Profit Daily Sum'); ?></label>
    <div class="col-sm-9">
        <?php echo CHtml::activeCheckboxList($user, 'rptprofits',Authitem::model()->getAuthItemReportProfit(), array('separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','checkAll' => Yii::t('app','Select All'))); ?>
    </div>
</div>