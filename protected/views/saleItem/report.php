<?php
$this->breadcrumbs = array(
    Yii::t('app', 'View Sale Order') => array('saleItem/list'),
    Yii::t('app', 'List'),
);
?>


<?php /*$this->renderPartial('//layouts/report/' . $header_view, array(
    'report' => $report,
    'advance_search' => $advance_search,
    'header_tab' => $header_tab, // Using for tab style
)); */?>

<?php $this->renderPartial('partialList/_header') ?>

<br /> <br />

<!-- Flash message layouts.partial._flash_message -->
<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<div id="report_grid" class="tabbable">

    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'above',
        'id' => 'tabs',
        'tabs' => array(
            array('label' => t('Waiting for Review ','app') . '<span class="badge badge-danger">' . $sale_submit_n . '</span>',
                'id' => 'tab_2',
                'icon' => 'fa fa-pencil bigger-120 purple',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view ,array(
                        'report' => $report,
                        'data_provider' => $data_provider2,
                        'grid_columns' => $grid_columns,
                        'grid_id' => $grid_id2,
                        'title' => $title),true,false),
                'active' => true,
                'visible' => ckacc('sale.review')   || ckacc('sale.create') || ckacc('sale.update')
            ),
            array('label' => t( 'Approval ','app') . '<span class="badge badge-info">' . $sale_approve_n .'</span>',
                'id' => 'tab_3',
                'icon' => 'fa fa-smile-o bigger-120 green',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                        'report' => $report,
                        'data_provider' => $data_provider3,
                        'grid_columns' => $grid_columns,
                        'grid_id' => $grid_id3,
                        'title' => $title),true),
                'visible' => ckacc('sale.approve')
            ),
            array('label' => t('Ready to Deliver ','app') . '<span class="badge badge-info">' . $sale_complete_n .'</span>',
                'id' => 'tab_4',
                'icon' => 'fa fa-truck bigger-120 green',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                        'report' => $report,
                        'data_provider' => $data_provider1,
                        'grid_columns' => $grid_columns,
                        'grid_id' => $grid_id1,
                        'title' => $title),true),
                'visible' => ckacc('report.stock')
            ),
            array('label' =>  t('All ','app'),
                'id' => 'tab_1',
                'icon' => 'fa fa-home pink bigger-120',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                    'report' => $report,
                    'data_provider' => $data_provider,
                    'grid_columns' => $grid_columns,
                    'grid_id' => $grid_id,
                    'title' => $title),true),
                'visible' => ckacc('admin') || ckacc('accountant')
            ),
        ),
        //'events' => array('shown'=>'js:test')
    ));
    ?>

</div>

<?php $this->renderPartial('partialList/_js',array()); ?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
