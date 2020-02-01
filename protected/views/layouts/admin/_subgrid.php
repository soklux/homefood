<?php
	Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
	$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	    'type' => 'striped bordered',
	    'dataProvider' =>  $data_provider,
	    'template' => "{items}",
	    'columns' => array_merge(array(
	        array(
	        'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
	        'name' => 'subGrid',
	        'url' => $url,
	        'value' => $value,
	        'afterAjaxUpdate' => 'js:function(tr,rowid,data){
	            //bootbox.alert("I have afterAjax events too!<br/>This will only happen once for row with id: "+rowid);
	        }'
	        )
	    ), $grid_columns),
	)); 
?>
