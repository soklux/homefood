<?php

$this->renderPartial('//layouts/report/' . $grid_view ,array(
    'report' => $report,
    'data_provider' => $data_provider,
    'grid_columns' => $grid_columns,
    'grid_id' => $grid_id,
    'title' => $title));
