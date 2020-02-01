<?php
/*
|-----------------------------------------------------
| Report Template III
|-----------------------------------------------------
|
| First Header as tab categories
| Content as grid
|
*/
?>

<?php $this->renderPartial('partial/_header_3', array(
    'report' => $report,
    'header_tab' => $header_tab,
)); ?>

<br />

<!-- Flash message layouts.partial._flash_message -->
<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<div id="report_grid">

    <?php $this->renderPartial('partial/_grid', array(
        'report' => $report,
        'data_provider' => $data_provider ,
        'grid_columns' => $grid_columns,
        'grid_id' => $grid_id,
        'title' => $title,
    )); ?>

</div>

<?php $this->renderPartial('partial/_js_3',array(
));?>
