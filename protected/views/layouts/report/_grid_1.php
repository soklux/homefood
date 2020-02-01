<div class="table-header">
    <?= $title ?>
</div>

<?php $this->widget('EExcelView', array(
    'id' => 'my_id',
    'fixedHeader' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $data_provider,
    'template' => "{items}\n{exportbuttons}\n",
    'columns' => $grid_columns,
));