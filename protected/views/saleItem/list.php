<?php
$this->breadcrumbs=array(
    'Sales Order'=>array('index'),
    'Sale Order',
);
?>

<?php $this->renderPartial('partial/' . $header_view, array(
    'report' => $report,
    'advance_search' => $advance_search,
    'header_tab' => $header_tab, // Using for tab style
)); ?>

<div id="sale_order_id">

    <?php $this->renderPartial('//layouts/alert/_flash'); ?>

    <?php $this->renderPartial('partialList/_grid',array(
        'model' => $model,
        'sale_status' => $sale_status,
        'box_title' => $box_title,
        'grid_columns' => $grid_columns,
        'color_style' => $color_style,
        'sale_header_icon' => $sale_header_icon,
    )); ?>

</div>

<?php $this->renderPartial('partialList/_js'); ?>
