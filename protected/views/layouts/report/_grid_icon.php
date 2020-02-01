<div class="table-header">
    <i class="<?= $title_icon ?>"></i>
    <?= $title ?>
</div>

<?php $this->widget('EExcelView', array(
    'id' => $grid_id,
    'fixedHeader' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $data_provider,
    'template' => "{items}\n{exportbuttons}\n",
    'columns' => $grid_columns,
));