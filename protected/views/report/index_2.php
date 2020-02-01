<?php
/*
|-----------------------------------------------------
| Report Template II
|-----------------------------------------------------
|
| Two block header search box & date range
| Content as grid
|
*/
?>

<?php $this->renderPartial('partial/_header_2', array(
    'report' => $report,
    'hint_text' => isset($hint_text) ? $hint_text : Yii::t('app','Search'),
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

<?php $this->renderPartial('partial/_js',array(
));?>
