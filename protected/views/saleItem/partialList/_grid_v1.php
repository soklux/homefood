<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' =>Yii::t('app',$box_title),
    'headerIcon' => $sale_header_icon,
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));?>


    <?= TbHtml::linkButton(Yii::t('app', 'Create ' . $box_title), array(
        'color' => $color_style,
        'size' => TbHtml::BUTTON_SIZE_SMALL,
        'icon' => 'ace-icon fa fa-plus white',
        'url' => $this->createUrl('saleItem/index',array('tran_type'=> $sale_status)),
    )); ?>

    <br><br>

    <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'id' => 'sale-order-grid',
        //'fixedHeader' => true,
        'responsiveTable' => true,
        'type' => TbHtml::GRID_TYPE_HOVER,
        'dataProvider' => $model->ListSuspendSale($sale_status),
        'summaryText' => '',
        'columns' => $grid_columns
    )); ?>

<?php $this->endWidget(); ?>

