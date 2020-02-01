<?php if (isset($title)) { ?>
    <div class="table-header">
        <?= $title ?>
    </div>
<?php } ?>

<?php $this->widget('EExcelView', array(
    'id' => $grid_id,
    'fixedHeader' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $data_provider,
    'template' => "{items}\n{exportbuttons}\n",
    'columns' => $grid_columns,
));
