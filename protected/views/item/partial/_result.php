<?php $baseUrl = Yii::app()->baseUrl.'/ximages/'.strtolower(get_class($model))?>
<h5 class="blue smaller">
	<!-- <i class="fa fa-tags"></i> -->
	Category: <?=$category?>
</h5>
<?php if(!empty($data)):?>
	<?php if($view=='k'):?>
		<?php $this->renderPartial('partial/_kanban_view',array('data'=>$data,'baseUrl'=>$baseUrl,'category'=>$category));?>
		<?php elseif($view=='g'):?>
		<?php $this->renderPartial('partial/_grid_view',array('data'=>$data,'baseUrl'=>$baseUrl,'category'=>$category));?>
	<?php endif;?>
<?php else:?>
	<h5>No Result</h5>
<?php endif;?>
