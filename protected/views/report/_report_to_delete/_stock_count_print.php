<style>
#sale_return_policy {
    width: 80%;
    margin: 0 auto;
    text-align: center;
}   

/*Receipt styles start*/
#receipt_wrapper {
    font-family: Arial;
    width: 92% !important;
    font-size: 11px !important;
    margin: 0 auto !important;
    padding: 0 !important;
}

    
#receipt_items td {
  //position: relative;
  padding: 3px;
}      
</style>

<?php
if (isset($error_message))
{
    echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $error_message);
    exit();
}
?>
<div class="container" id="receipt_wrapper"> 
    <div class="row">
        <div class="col-xs-10">
            <!-- <div class="panel panel-default"> -->
                <!-- <div class="panel-body"> -->
                <p>
                    <h4><?php echo Yii::t('app','Stock Count Report'); ?></h4>
                </p>
                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
    <!-- / end client details section -->
    
    <div class="row">
        <div class="col-xs-6">
            <p>
                <?php echo Yii::t('app','Name') . " : ". TbHtml::b(ucwords($employee)); ?> <br>
                <?php echo Yii::t('app','Date') . " : ". TbHtml::b(ucwords($trans_date)); ?>
            </p>
        </div>
        
        <div class="col-xs-6 col-xs-offset-0 text-right">
            
            <!-- <div class="panel panel-default"> -->
                    <p>
                        <?php //echo TbHtml::encode(Yii::t('app','Invoice ID') . " : "  . $sale_id); ?> <br>
                        <?php //echo TbHtml::encode(Yii::t('app','Date') . " : ". $transaction_date . ' ' . $transaction_time); ?> <br>
                    </p>
            <!-- </div> -->
        </div>
        
        <table class="table" id="receipt_items">
            <thead>
                <tr>
                    <th style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo Yii::t('app','Name'); ?></th>
                    <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo Yii::t('app','Qty'); ?></th>
                    <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo Yii::t('app','Actual Qty'); ?></th>
                    <th class="center" style='border-top:2px solid #000000; border-bottom:2px solid #000000;'><?php echo Yii::t('app','Next Count Date'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0; ?>
                <?php foreach(array_reverse($items,true) as $id=>$item): ?>
                    <?php
                        $i=$i+1;
                    ?>
                    <tr>                
                        <td><?php echo TbHtml::encode($item['name']); ?></td>
                        <td class="center"><?php echo $item['quantity']; ?></td>
                        <td class="center"><?php echo TbHtml::encode($item['actual_qty']); ?></td>
                        <td class="center"><?php echo TbHtml::encode($item['next_count_date']); ?></td>
                    </tr>
                <?php endforeach; ?> <!--/endforeach--> 
            </tbody>
        </table>  
    </div>
    
    <div class="hr hr8 hr-double hr-dotted"></div>
    <div class="row">
        <div class="col-sm-5 pull-right">
            <div class="pull-right">
                <?php echo CHtml::encode(Yii::t('app','Supervisor')); ?> 
            </div>
        </div>
        <div class="col-sm-7 pull-left"> <?php echo CHtml::encode(Yii::t('app','Cashier')); ?></div>
    </div>
     
</div>

<script>
$(window).bind("load", function() {
    setTimeout(window.location.href='stockCount',5000); 
    window.print();
    return true;
});    
</script>