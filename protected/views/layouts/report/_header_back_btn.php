<span class="btn btn-white btn-info btn-bold btn-back pull-right" onclick="back()">
    <i class="ace-icon fa fa-arrow-left bigger-120 blue"></i>
    <?= Yii::t('app','Back'); ?>
</span>

<script type="text/javascript">
	function back(){
		window.history.back();
	}
</script>