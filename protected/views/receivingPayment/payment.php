<?php
$this->breadcrumbs=array(
	Yii::t('app','Customer')=>array('client/admin'),
	Yii::t('app','Payment'),
);

?>

<div id="payment_container">

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','Payment') . '   ' .  $client_name,
              'headerIcon' => 'ace-icon fa fa-credit-card',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_payment', array('data'=>$data), true),
 )); ?>  

<?php $this->endWidget(); ?>

</div>

