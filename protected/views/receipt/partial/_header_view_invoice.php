<?php 

$icon = $status==param('sale_submit_status') ? 'fa-check-square-o' : ($status==param('sale_validate_status') ? 'fa-paper-plane-o' : ($status==param('sale_complete_status') ? 'fa-paper-plane-o' :''));

$sale_status = $status==param('sale_submit_status') ? param('sale_validate_status') : ($status==param('sale_validate_status') ? param('sale_complete_status') : $status==param('sale_complete_status'));

$title=$status==param('sale_submit_status') ? 'Order To Validate' : ($status==param('sale_validate_status') ? 'Order To Invoice' : ($status==param('sale_complete_status') ? 'Order To Deliver' : 'Sale Order'));

?>
<nav class="navbar navbar-fixed-top">
	<a class="btn btn-primary" onclick="window.history.back()">
		<i class="ace-icon fa fa-arrow-left bigger-120 white"></i>Back
	</a>
    <?php if(!isset($_GET['report'])):?>
    <a class="btn btn-primary" href="<?=Yii::app()->createUrl($status == param("sale_validate_status") ? 'report/saleOrderHistory' : 'saleItem/list',array('user_id'=>getEmployeeId(),'tran_type'=>$status,'title'=>$title))?>">
        <i class="ace-icon fa fa-list bigger-120 white"></i>View List
    </a>
    <?php endif?>
    <a class="btn btn-primary" href="<?=Yii::app()->createUrl('saleItem/create',array('tran_type'=> param('sale_submit_status')))?>">
        <i class="ace-icon fa fa-plus bigger-120 white"></i>Add New
    </a>
	<a class="btn btn-primary pull-right" onclick="window.print()">
		<i class="ace-icon fa fa-print bigger-120 white"></i>Print
	</a>
    <?php if($status==param('sale_submit_status') && ckacc("sale.validate")):?>
        <a href="<?=Yii::app()->createUrl('saleItem/SaleUpdateStatus',array('sale_id'=>$sale_id,'tran_type'=>param('sale_validate_status')))?>" class="btn btn-primary pull-right btn-order btn-order-approve">
            <i class="ace-icon fa <?=$icon?> bigger-120 white"></i>
            Validate
        </a>
    <?php endif;?>
    <?php if($status==param('sale_validate_status') && ckacc("sale.approve")):?>
        <a href="<?=Yii::app()->createUrl('saleItem/SaleUpdateStatus',array('sale_id'=>$sale_id,'tran_type'=>param('sale_complete_status')))?>" class="btn btn-primary pull-right btn-order btn-order-approve">
            <i class="ace-icon fa <?=$icon?> bigger-120 white"></i>
            Approve
        </a>
    <?php endif;?>

	
    <?php if(Yii::app()->user->checkAccess("invoice.update")):?>
        <a href="<?=Yii::app()->createUrl('saleItem/EditSale',array('sale_id'=>$sale_id,'customer_id'=>$customer_id,'paid_amount'=>$paid_amount,'tran_type'=>$status))?>" class="btn btn-primary pull-right">
            <i class="ace-icon fa fa-edit bigger-120 white"></i>Edit
        </a>
    <?php endif;?>

    <a href="<?=Yii::app()->createUrl('saleItem/exportPdf',array('sale_id'=>$sale_id,'customer_id'=>$customer_id,'tran_type'=>$status,'pdf'=>1))?>" class="btn btn-primary pull-right">
        <i class="ace-icon fa fa-file-pdf-o bigger-120 white"></i>PDF
    </a>

    <?php echo TbHtml::linkButton(Yii::t('app', 'Send Mail'), array(
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        'size' => TbHtml::BUTTON_SIZE_SMALL,
        'icon' => 'ace-icon fa fa-envelope-o bigger-120 white',
        'url' => Yii::app()->createUrl('saleItem/SendEmail', array(
            'sale_id' => $sale_id,
            'customer_id' => $customer_id,
            'tran_type' => $status,
            'pdf' => 0,
            'email' => 1)
        ),
        'class' => 'update-dialog-open-link btn btn-primary pull-right',
        'data-update-dialog-title' => 'Send Email',
        'data-refresh-grid-id' => 'email-grid',
    )); ?>

    
</nav>

<div style="margin-top: 60px !important;"></div>

<script type="text/javascript">
    $('.update-dialog-open-link').removeClass('btn-sm');
	jQuery(function ($) {
        $('div#receipt_wrapper').on('click', 'a.btn-order', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to Update this order?')) {
                return false;
            }
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                beforeSend: function () {
                    $('.waiting').show();
                },
                complete: function () {
                    window.history.back()
                },
                success: function (data) {
                    return false;
                }
            });
        });

    });

</script>
<?php $this->widget('ext.modaldlg.EModalDlg'); ?>