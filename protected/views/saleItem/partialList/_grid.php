<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'placement' => 'above',
    'id' => 'tabs',
    'tabs' => array(
        array('label' => '<i class="pink ace-icon fa fa-home bigger-120"></i>' . t('All ','app'),
            'id' => 'tab_1',
            'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                'report' => $report,
                'data_provider' => $data_provider,
                'grid_columns' => $grid_columns,
                'grid_id' => $grid_id,
                'title' => $title),true),
            'active' => true
        ),
        array('label' => '<i class="purple ace-icon fa fa-pencil bigger-120"></i>' . t('Waiting for Approval ','app') . '<span class="badge badge-danger">' . $sale_submit_n . '</span>',
            'id' => 'tab_2',
            'content' => $this->renderPartial('//layouts/report/' . $grid_view ,array(
                'report' => $report,
                'data_provider' => $data_provider2,
                'grid_columns' => $grid_columns,
                'grid_id' => $grid_id2,
                'title' => $title),true,false),
        ),
        array('label' => '<i class="green ace-icon fa fa-smile-o bigger-120"></i>' . t( 'Review & Complete ','app') . '<span class="badge badge-info">' . $sale_approve_n .'</span>',
            'id' => 'tab_3',
            'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                'report' => $report,
                'data_provider' => $data_provider3,
                'grid_columns' => $grid_columns,
                'grid_id' => $grid_id3,
                'title' => $title),true),
        ),
        array('label' => '<i class="green ace-icon fa fa-truck bigger-120"></i>'  . t('Ready to Deliver ','app') . '<span class="badge badge-info">' . $sale_complete_n .'</span>',
            'id' => 'tab_4',
            'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                'report' => $report,
                'data_provider' => $data_provider1,
                'grid_columns' => $grid_columns,
                'grid_id' => $grid_id1,
                'title' => $title),true),
        ),
    ),
    //'events' => array('shown'=>'js:test')
));
