<?php
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	'Sale Order',
);
?>

<div id="sale_order_id">

    <?php $this->renderPartial('//layouts/alert/_flash'); ?>

    <?php $this->renderPartial('partialList/_grid',array(
            'model' => $model,
            'sale_status' => $sale_status
    )); ?>

</div>


<?php $this->renderPartial('partialList/_js'); ?>
