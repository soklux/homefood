<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'id' => $grid_id,
    'fixedHeader' => true,
    'type' => TbHtml::GRID_TYPE_HOVER,
    'dataProvider' => $data_provider,
    'template' => "{items}\n{summary}\n{pager}",
    'summaryText' => 'Showing {start}-{end} of {count} entries ' . $page_size . ' rows per page',
    'columns' => $grid_columns,
));
