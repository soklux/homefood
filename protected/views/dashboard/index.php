<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Dashboard'),
);
?>

<?php
$date = array();
$sub_total = array();
$total = array();
$purchase_aged = array();
$nclient = array();


foreach ($report->saleDailyChart() as $record) {
    $date[] = $record["date"];
    $sub_total[] = $record["sub_total"];
    $total[] = $record["total"];
}


?>


<div class="col-xs-12">
    <div class="row">

        <!--PAGE CONTENT BEGINS-->
        <div class="col-xs-12">

            <?php $this->renderPartial('partial/widget_db', array(
                'report' => $report,
            )); ?>

            <?php $this->renderPartial('partial/widget_agedpurchase', array(
                'report' => $report,
            )); ?>

            <div class="space-8"></div>


            <?php $this->renderPartial('partial/widget_chart', array(
                'date' => $date,
                'sub_total' => $sub_total,
                'total' => $total,
            )); ?>

            <div class="space-8"></div>

            <?php $this->renderPartial('partial/widget_topten', array(
                'report' => $report,
            )); ?>

        </div>
        <!--/row-->
    </div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>