<?php
$this->breadcrumbs=array(
    'Physical Count'  => Yii::app()->createUrl('/receivingItem/index',array('trans_mode'=>'physical_count')),
    'Count',
);
?>
<div id="register_container">
<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
<div class="col-xs-12 col-sm-9 widget-container-col">

    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
        'title' => Yii::t('app','Item Count'),
        'headerIcon' => sysMenuItemIcon(),
        'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
        'headerButtons' => array(
            // TbHtml::buttonGroup(
            //     array(
            //         array('label' => Yii::t('app','Review'),'url' => Yii::app()->createUrl('receivingItem/countReview'),'icon'=>'fa fa-check-square  white','id'=>'btn-review'),
            //     ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
            // ),
        ),
        'content' => $this->renderPartial('partial/_count',array(
            'model'=>$model,
            'receiveItem'=>$receiveItem,
            'grid_id' => $grid_id,
            'items' => $items,
        ),true)
    )); ?>

    <?php $this->endWidget(); ?>
    <?php $this->renderPartial('partial/_count_grid',array('items' => $items))?>
</div>

<div class="col-xs-12 col-sm-3 widget-container-col">

    <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
        'title' => Yii::t('app','General'),
        'headerIcon' => sysMenuItemIcon(),
        'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
        'headerButtons' => array(
            // TbHtml::buttonGroup(
            //     array(
            //         array('label' => Yii::t('app','Review'),'url' => Yii::app()->createUrl('receivingItem/countReview'),'icon'=>'fa fa-check-square  white','id'=>'btn-review'),
            //     ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
            // ),
        ),
        'content' => $this->renderPartial('partial/_general',array(
            'model'=>$model,
            'receiveItem'=>$receiveItem,
            'grid_id' => $grid_id,
            'items' => $items,
        ),true)
    )); ?>

    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial('partial/_footer',array('btn_text'=>'Rreview','url' => 'receivingItem/countReview'))?>
</div>
<?php $this->renderPartial('partial/_js'); ?>


<style type="text/css">
    .margin-3{
        margin:0px 3px 0px 3px;
    }
    .border-bottom-1{
        border-bottom: solid 1px #f5f5f5;
    }
</style>

<script type="text/javascript">
    
    $(document).ready(function()
    {
        $('.input-mask-date').mask('99:99:99');
        $('.btn-count').prop('disabled',true);
        $('.txt-pro-name').keyup(function(e){
            $('.btn-count').prop('disabled',true);
        });

        // $('#btn-review').attr('disabled',true); 
        $('#InventoryCount_count_name').keypress(function(){
            var countDate=$('#InventoryCount_count_date').val();
            var countTime=$('#InventoryCount_count_time').val();
            var countName=$('#InventoryCount_count_name').val();
            if(countDate=='' || countTime=='' || countName==''){
                $('#btn-review').attr('disabled',true);    
                  
            }else{
                $('#btn-review').removeAttr('disabled');    
            }
        })
        
        
        var itemId=$('.txt-pro-id').val();
        $('.txt-count'+itemId).keypress(function(e){
            if(e.which == 13) {
                inventoryCount(1,"");
                $('.txt-pro-name').focus();
            }
        })
    });

    function inventoryCount(opt,idx){
        var url='addCount';
        var countDate=$('#InventoryCount_created_date').val();
        var countTime=$('#InventoryCount_count_time').val();
        var countName=$('#InventoryCount_count_name').val();
        var itemId=$('.txt-pro-id').val();
        var proName=$('.txt-pro-name').val();
        var countNum=$('.txt-count').val();
        if(opt==1 && (proName =='' || countNum=='')){
            return false;
        }else{
            $.ajax({url:url,
                type : 'post',
                data:{opt:opt,countDate:countDate,countTime:countTime,countName:countName,idx,itemId:itemId,name:proName,countNum:countNum},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                    $('.txt-pro-name').focus();
                    if(countDate!=='' && countTime!=='' && countName!==''){
                        $('#btn-review').removeAttr('disabled');   
                    }
                }
            });    
        }
        
    }
    function updateCount(itemId){
        var opt=3;
        var url='addCount';
        var newCount=$('.txt-counted'+itemId).val();
        var x = event.which || event.keyCode
        if(x == 13){
            $.ajax({url:url,
                type : 'post',
                data:{opt:opt,itemId:itemId,newCount:newCount},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                }
            });    
        }
        
    }
</script>