<?php

class UserColumn extends CModel
{
    public function attributeNames()
    {
        return array(
            'id',
            'sale_id',
            'sale_time',
            'date_report',
            'sub_total',
            'discount_amount',
            'vat_amount',
            'total',
            'cross_profit',
            'profit',
            'margin',
        );
    }

    public static function getUserColumns()
    {
        return array(
            array(
                'name' => 'email',
                'value' => '$data->status=="1" ? $data->email : "<s class=\"red\">  $data->email <span>"',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'user_name',
                'value' => '$data->status=="1" ? $data->user_name : "<s class=\"red\">  $data->user_name <span>"',
                'type' => 'raw',
                'filter' => '',
            ),
            array('name' => 'created_at',
                 'filter' => '',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app','Action'),
                'template' => '<div class="hidden-sm hidden-xs btn-group">{view}{update}{delete}{undeleted}</div>',
                'buttons' => array(
                    'view' => array(
                        'click' => 'updateDialogOpen',
                        'label' => Yii::t('app', 'Stock'),
                        'url' => 'Yii::app()->createUrl("Inventory/admin", array("item_id"=>$data->id))',
                        'options' => array(
                            'data-toggle' => 'tooltip',
                            'data-update-dialog-title' => 'Stock History',
                            'class' => 'btn btn-xs btn-pink',
                            'title' => 'Stock History',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.index") ',
                    ),
                    'update' => array(
                        'click' => 'updateDialogOpen',
                        'label' => Yii::t('app', 'Cost'),
                        'url' => 'Yii::app()->createUrl("Item/CostHistory", array("item_id"=>$data->id))',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'Cost History'),
                            'class' => 'btn btn-xs btn-info',
                            'title' => 'Cost History',
                        ),
                        'visible' => '$data->status=="1"  && (Yii::app()->user->checkAccess("item.create") || Yii::app()->user->checkAccess("item.update"))',
                    ),
                    'delete' => array(
                        'label' => Yii::t('app', 'Delete Item'),
                        'icon' => 'bigger-120 fa fa-trash',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Restore Item'),
                        'url' => 'Yii::app()->createUrl("Item/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                ),
            ),
        );
    }


    public static function getRoleColumns()
    {
        return array(
            array(
                'name' => 'name',
                'header' => 'Role Name',
                'value' => '$data->name',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'description',
                'value' => '$data->description',
                'type' => 'raw',
                'filter' => '',
            ),
        );
    }
}
