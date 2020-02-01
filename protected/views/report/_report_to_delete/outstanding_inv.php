<div id="report_container" class="row">
    <div class="col-xs-12 widget-container-col ui-sortable" id="report_main">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app','Outstanding Invoice'),
            'headerIcon' => 'ace-icon fa fa-signal',
            'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
        ));?>

        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'outstanding-invoice-form',
            'method' => 'get',
            'enableAjaxValidation' => false,
            'layout' => TbHtml::FORM_LAYOUT_INLINE,
        )); ?>

            <?php //echo $form->textField($report,'search_id',array('class'=>'input-xxlarge','maxlength'=>50,'id'=>'search_id_id','placeholder'=>'Customer Name')); ?>

            <?php echo CHtml::activeTelField($report,'search_id', array('class' => 'col-xs-10 col-sm-4','placeholder'=>'Customer Name')); ?>


            <?php echo TbHtml::button(Yii::t('app','Go'),array(
                    //'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                    'size'=>TbHtml::BUTTON_SIZE_SM,
                    'title' => Yii::t( 'app', 'Go' ),
                    'ajax'=>array(
                        'type'=>'get',
                        'dataType'=>'json',
                        'beforeSend' => 'function() { $(".waiting").show(); }',
                        'complete' => 'function() { $(".waiting").hide(); }',
                        'url'=>Yii::app()->createUrl('Report/outstandingInvoice/'),
                        'success'=>'function (data) {
                                if (data.status==="success")
                                {
                                   $("#outstanding_invoice").html(data.div);
                                }
                                else
                                {
                                   alert("Ooh snap, change a few things and try again!");
                                }
                         }'
                    )
              )); ?>
        <?php $this->endWidget(); ?>

        <br>
    
        <div id="outstanding_invoice">

            <?php $this->widget('EExcelView', array(
                'id' => 'outstanding-invoice-grid',
                'fixedHeader' => true,
                'responsiveTable' => true,
                'type' => TbHtml::GRID_TYPE_BORDERED,
                'dataProvider' => $report->outstandingInvoice(),
                'summaryText' => '',
                'template' => "{summary}\n{items}\n{exportbuttons}\n{pager}",
                'columns' => array(
                    array(
                        'name' => 'client_name',
                        'header' => Yii::t('app', 'Customer Name'),
                        'value' => '$data["client_name"]',
                    ),
                    array(
                        'name' => 'invoices',
                        'header' => Yii::t('app', 'Num of Invoices'),
                        'value' => '$data["invoices"]',
                        //'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'headerHtmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'name' => 'balance',
                        'header' => Yii::t('app', 'Outstanding Balance'),
                        'value' => 'number_format($data["balance"],Common::getDecimalPlace(), ".", ",")',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'headerHtmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'name' => 'last_payment',
                        'header' => Yii::t('app', 'Last Payment'),
                        'value' => '$data["last_payment"]',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'headerHtmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'name' => 'days',
                        'header' => Yii::t('app', 'Last Payment # Days'),
                        'value' => '$data["days"]',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                        'headerHtmlOptions' => array('style' => 'text-align: right;'),
                    ),
                ),
            )); ?>

        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>

<div class="waiting"><!-- Place at bottom of page --></div>    