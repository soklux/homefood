<div class="row">
	<?php foreach($data as $key=>$row):?>
	<div class="col-xs-12">
		<div class="media search-media">
			<div class="media-left">
				<a href="<?=Yii::app()->createUrl('Item/ItemSearch?result='.$row['id'])?>">
					<img class="media-object" src="<?=$row['image'] ? $baseUrl.'/'.$row['id'].'/'.$row['image'] : Yii::app()->baseUrl.'/images/noimage.gif'?>" width="120px" />
				</a>
			</div>

			<div class="media-body">
				<div>
					<h5 class="media-heading">
						<a href="<?=Yii::app()->createUrl('Item/ItemSearch?result='.$row['id'])?>" class="blue"><?=$row['name']?></a>
					</h5>
				</div>
				<p><?=substr(strip_tags($row['description']),0,100).'...'?></p>
				<div class="search-actions text-center">
					<span class="text-info">$</span>

					<span class="blue bolder bigger-150"><?=$row['unit_price']?></span>
					<a href="<?=Yii::app()->createUrl('Item/ItemSearch?result='.$row['id'])?>" class="search-btn-action btn btn-sm btn-block btn-info">Detail</a>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach?>
</div>