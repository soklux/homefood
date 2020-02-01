<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' =>Yii::t('app','Change Password'),
              'headerIcon' => 'ace-icon fa fa-key',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_form', array('model'=>$model), true),
 )); ?>  

<?php $this->endWidget(); ?>
