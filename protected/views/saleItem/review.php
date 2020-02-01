<?php
$this->breadcrumbs=array(
    isset($_GET['title']) ? $_GET['title'] : 'Sale Order' ,
    'List',
);
?>

<?php $this->renderPartial('//layouts//report/' . $header_view, array(
    'report' => $report,
    'advance_search' => $advance_search,
    'header_tab' => $header_tab,
    'status' => $status,
    'user_id' => $user_id,
    'title' => $title,
)); ?>

<br />

<div id="report_grid">
    
<?php

$this->renderPartial('//layouts/report/' . $grid_view ,array(
    'report' => $report,
    'data_provider' => $data_provider,
    'grid_columns' => $grid_columns,
    'grid_id' => $grid_id,
    'title' => $title));

?>

</div>

<?php $this->renderPartial('partialList/_js_v1',array()); ?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
