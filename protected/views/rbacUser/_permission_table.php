<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'id' => $grid_id,
    'fixedHeader' => true,
    'type' => TbHtml::GRID_TYPE_HOVER,
    'dataProvider' => $data_provider,
    'columns' => $grid_columns,
));

