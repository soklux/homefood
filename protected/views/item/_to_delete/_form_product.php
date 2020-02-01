<div id="report_grid" class="tabbable">

    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'above',
        'id' => 'tabs',
        'tabs' => array(
            array('label' => '<i class="pink ace-icon fa fa-info-circle bigger-120"></i>' . t('Detail ','app'),
                'id' => 'tab_1',
                'content' => $this->renderPartial('partial/_detail',array('model' => $model)),
                'active' => true,
            ),
            /*
            array('label' => '<i class="purple ace-icon fa fa-area-chart bigger-120"></i>' . t('Inventory ','app'),
                'id' => 'tab_2',
                'content' => ' Tab 2',
                'visible' => ckacc('sale.review')
            ),
            array('label' => '<i class="purple ace-icon fa fa-dollar bigger-120"></i>' . t('Purchase ','app'),
                'id' => 'tab_3',
                'content' => ' Tab 2',
                'visible' => ckacc('sale.review')
            ),
            array('label' => '<i class="purple ace-icon fa fa-dot-circle-o bigger-120"></i>' . t('Sale ','app'),
                'id' => 'tab_4',
                'content' => ' Tab 2',
                'visible' => ckacc('sale.review')
            ),
            array('label' => '<i class="purple ace-icon fa fa-bar-chart bigger-120"></i>' . t('Transaction ','app'),
                'id' => 'tab_5',
                'content' => ' Tab 2',
                'visible' => ckacc('sale.review')
            ),
            array('label' => '<i class="purple ace-icon fa fa-info bigger-120"></i>' . t('Reference ','app'),
                'id' => 'tab_6',
                'content' => ' Tab 2',
                'visible' => ckacc('sale.review')
            ),
            array('label' => '<i class="purple ace-icon fa fa-money bigger-120"></i>' . t('Cost ','app'),
                'id' => 'tab_7',
                'content' => ' Tab 2',
                'visible' => ckacc('sale.review')
            ),
            array('label' => '<i class="purple ace-icon fa fa-cloud-upload bigger-120"></i>' . t('Attachment ','app'),
                'id' => 'tab_8',
                'content' => ' Tab 2',
                'visible' => ckacc('sale.review')
            )
            */
        ),
        //'events' => array('shown'=>'js:test')
    ));
    ?>

</div>