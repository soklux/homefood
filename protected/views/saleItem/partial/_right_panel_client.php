<div class="row">
    <div class="sidebar-nav" id="client_cart">
        <?php
        if ($customer!== null) {
            $this->widget('yiiwheels.widgets.box.WhBox', array(
                'title' => Yii::t('app', 'Customer Information'),
                'headerIcon' => 'ace-icon fa fa-info-circle ',
                'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                'content' => $this->renderPartial('partial/_client_selected', array(
                    'model' => $model,
                    'cust_fullname' => $cust_fullname,
                    'group_name'=>$group_name,
                    'customer_id' => $customer_id,
                    'acc_balance' => $acc_balance,
                    'sale_mode' => $sale_mode,
                    'cust_term' => $cust_term,
                ), true),
            ));
        } else {
            $this->widget('yiiwheels.widgets.box.WhBox', array(
                'title' => Yii::t('app', 'Select Customer (Optional)'),
                'headerIcon' => 'ace-icon fa fa-users',
                'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
                'content' => $this->renderPartial('partial/_client', array('model' => $model), true),
            ));
        }
        ?>
    </div>
</div>