<div id="report_header">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'report-form',
        'method' => 'get',
        'action' => Yii::app()->createUrl($this->route,array(
            'tran_type' => $status,
            'user_id' => $user_id,
            'title' => $title,
        )),
        'enableAjaxValidation' => false,
        'layout' => TbHtml::FORM_LAYOUT_INLINE,
    )); ?>

    <?php if ($advance_search!==null) { ?>
        <?php $this->renderPartial('//layouts/report/_advance_search', array(
            'report' => $report,
        )); ?>
    <?php } ?>

    <?php $this->renderPartial('//layouts/report/_header_date_range', array(
        'report' => $report,
    )); ?>

    <?php $this->renderPartial('//layouts/report/_header_view_btn', array(
    )); ?>
    
    <?php $this->endWidget(); ?>

</div>