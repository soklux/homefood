<?= $form->dropDownListControlGroup($user,'role_name', Authitem::model()->getRoleName(),array(
        'id'=>'role_id',
        //'options'=>array(Yii::app()->shoppingCart->getPriceTier()=>array('selected'=>true)),
        'class' => 'col-xs-10 col-sm-8','empty'=>'None',
        'labelOptions' => array('label'=>Yii::t('app','Select Role')),
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('RbacUser/Permission'),
            'success' => 'function(data) { 
                $("#permission_view").html(data);
            }',
        )
    )
);
?>

<div id="permission_view">
    <?php $this->renderPartial('//rbacUser/_permission_table',array(
        'grid_id' => $grid_id,
        'data_provider' => $data_provider,
        'grid_columns' => $grid_columns,
    )) ?>
</div>




