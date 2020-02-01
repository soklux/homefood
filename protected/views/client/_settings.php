<?= $form->dropDownListControlGroup($model, 'price_tier_id', CustomerGroup::model()->getCustomerGroup(),
    array(
        'class' => 'span3',
        // 'empty' => Yii::t('app', 'Select Default Price Tier'),
    )
); ?>

<?= $form->dropDownListControlGroup($model, 'employee_id', Employee::model()->getEmployee(), array(
        'class' => 'span3',
        'empty' => Yii::t('app', 'Select Employee Reference'),
        'ajax' => array(
            'type' => 'POST',
            'dataType' => 'json',
            'url' => Yii::app()->createUrl('client/copyClientInfo'),
            'success' => "function(data) {
                            if ( data.status === 'success' ) {
                                $('#Client_mobile_no').val(data.mobile_no);
                                $('#Client_first_name').val(data.first_name);
                                $('#Client_last_name').val(data.last_name);
                                $('#Client_address1').val(data.address1);
                                $('#Client_address2').val(data.address2);
                                $('#Client_notes').val(data.notes);
                            }
                        }",
        )
    )
); ?>

<?= $form->dropDownListControlGroup($model, 'payment_term', Common::arrayFactory('payment_term')); ?>

<?= $form->dropDownListControlGroup($model, 'size_biz',Common::arrayFactory('size_biz')); ?>

<?= $form->dropDownListControlGroup($model, 'main_biz',Common::arrayFactory('main_biz')); ?>
