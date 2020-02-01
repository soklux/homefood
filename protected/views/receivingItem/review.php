<?php
$this->breadcrumbs=array(
    isset($_GET['tran_type']) && $_GET['tran_type']==1 ? 'Receiving Item' : 'Return Item' ,
    'List',
);
?>

<?php $this->renderPartial('//layouts//report/' . $header_view, array(
    'report' => $report,
    'advance_search' => $advance_search,
    'header_tab' => $header_tab,
    'status' => $tran_type,
    'user_id' => $user_id,
    'title' => $title,
    'url' => isset($url) ? $url : Yii::app()->createUrl('receivingItem/index',array('trans_mode'=>$tran_type==1 ? 'receive' : 'return'))
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
