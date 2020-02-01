<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'method'=>'get',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>
        <?php $this->widget('bootstrap.widgets.TbNav', array(
            'type' => TbHtml::NAV_TYPE_PILLS,
            'htmlOptions'=>array('class'=>'btn-rptview-opt'),
            'items' => array(
                array('label'=>Yii::t('app','Today'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'today')),'active'=>Yii::app()->reportCart->getSaleInvPeriod()=='today' ? true : false),
                array('label'=>Yii::t('app','Yesterday'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'yesterday')),'active'=>Yii::app()->reportCart->getSaleInvPeriod()=='yesterday' ? true : false), 
                array('label'=>Yii::t('app','This Month'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'thismonth')),'active'=>Yii::app()->reportCart->getSaleInvPeriod()=='thismonth' ? true : false),
                array('label'=>Yii::t('app','Last Month'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'lastmonth')),'active'=>Yii::app()->reportCart->getSaleInvPeriod()=='lastmonth' ? true : false),
                array('label'=>Yii::t('app','Choose Period..'), 'url'=>Yii::app()->urlManager->createUrl('report/SaleInvoice',array('period'=>'choose')),'active'=>Yii::app()->reportCart->getSaleInvPeriod()=='choose' ? true : false),
            ),
        )); ?>

        <br/>

        
        <?php if ($date_view!=='choose') { ?> 
        
            <!--<label class="text-info" for="sale_id"><?php /*echo Yii::t('app','Invoice ID'); */?></label>-->

            <?php //echo $form->textFieldControlGroup($report,'sale_id',array('class'=>'input-medium','maxlength'=>100,'id'=>'sale_id_id','placeholder'=>'Invoice ID')); ?>

            <?php echo CHtml::activeTelField($report,'sale_id', array('class' => 'col-xs-10 col-sm-4','placeholder'=>'Customer Name')); ?>
              
        <?php } ?>
        
        <?php if ($date_view==='choose') { ?>   
            
            <label class="text-info" for="from_date"><?php echo Yii::t('app','Start Date'); ?></label>
            <div class="input-group">
                <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                'attribute' => 'from_date',
                'model' => $report,
                'pluginOptions' => array(
                        'format' => 'dd-mm-yyyy',
                    )
                ));
                ?>
                <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
            </div>   

            <label class="text-info" for="to_date"><?php echo Yii::t('app','End Date'); ?></label>
            <div class="input-group">
                <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                'attribute' => 'to_date',
                'model' => $report,
                'pluginOptions' => array(
                        'format' => 'dd-mm-yyyy'
                    )
                ));
                ?>
                <span class="input-group-addon"><i class="ace-icon fa fa-calendar"></i></span>
            </div>
        
            <!-- <label class="text-info" for="from_date"><?php //echo Yii::t('app','Start Date'); ?></label> -->
            <?php //echo $form->textField($report,'from_date',array('class'=>'input-medium','maxlength'=>100,'id'=>'from_date_id','append'=>'<i class="ace-icon fa fa-calendar"></i>')); ?>
            <?php /* $this->widget('ext.calendar.Calendar',
                                array(
                                'inputField'=>'from_date_id',
                                'trigger'=>'from_date_id',    
                                'dateFormat'=>'%d-%m-%Y',    
                            ));
                * 
                */
            ?>
          
        <!-- <label class="text-info" for="to_date"><?php //echo Yii::t('app','End Date'); ?></label> -->
        <?php //echo $form->textField($report,'to_date',array('class'=>'input-medium','maxlength'=>100,'id'=>'to_date_id','append'=>'<i class="ace-icon fa fa-calendar"></i>')); ?>
        <?php /* $this->widget('ext.calendar.Calendar',
                            array(
                            'inputField'=>'to_date_id',
                            'trigger'=>'to_date_id',    
                            'dateFormat'=>'%d-%m-%Y',    
                        ));
            * 
            */
        ?>
        
        <?php } ?>
        
        <?php echo TbHtml::linkButton(Yii::t('app','Go'),array(
            //'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'size'=>TbHtml::BUTTON_SIZE_SMALL,
            'title' => Yii::t( 'app', 'Go' ),
            'id'=>'submitSk' . uniqid(),
            'ajax'=>array(
                'type'=>'get',
                //'dataType'=>'json',
                'update' => '#report_main',  
                'beforeSend' => 'function() { $(".waiting").show(); }',
                'complete' => 'function() { $(".waiting").hide(); }',
                'url'=>Yii::app()->createUrl('Report/SaleInvoice/'),
                'success'=>'function (data) {
                            //$("#report_main").empty();
                            $("#report_main").html(data);
                       }'
            ),
        )); ?>
            
              
<?php $this->endWidget(); ?>

<?php /*
    Yii::app()->clientScript->registerScript( 'reportViewOption', "
        jQuery( function($){
            $('.btn-rptview-opt li a').on('click', function(e) {
                e.preventDefault();
                var current_link=$(this);
                var url=current_link.attr('href');
                current_link.parent().parent().find('.active').removeClass('active');
                current_link.parent().addClass('active').css('font-weight', 'bold');
                $.ajax({url: url,
                        //dataType : 'json',
                        type : 'post',
                        update :  '#report_container',  
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            $('#report_container').empty();
                            $('#report_container').append(data);
                        }
                    });
                });
        });
      ");
    * 
    */
          
 ?>

 <?php  /*
    Yii::app()->clientScript->registerScript( 'cancelInvoice', "
        jQuery( function($){
            $('#sale_invoice').on('click','a.btnCancelInvoice', function(e) {
               e.preventDefault(); 
               var remark = prompt('Why do you want to cancel this invoice?');
               if (remark==='') {
                    alert('Invoice is not canceled because you did not specify a reason.');
               }
               else if(remark) {
                 var url=$(this).attr('href');
                 $.ajax({url: url,
                        dataType : 'json',
                        type : 'post',
                        data : {remark : remark},
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    $.fn.yiiGridView.update('sale-grid');
                                    //$('#sale_invoice').html(data.div);
                                }
                                else 
                                {
                                   console.log(data.message);
                                }
                          }
                    });
               }
             })
        });
      ");
    * 
    */
 ?>

 <?php  /*
    Yii::app()->clientScript->registerScript( 'periodView', "
        jQuery( function($){
            $('#sale_invoice_main').on('click','a.btn-go-choose', function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                alert(url);
                $.ajax({url: url,
                        dataType : 'json',
                        type : 'post',
                        beforeSend: function() { $('.waiting').show(); },
                        complete: function() { $('.waiting').hide(); },
                        success : function(data) {
                            if (data.status==='success')
                            {
                                $('#sale_invoice').html(data.div);
                            }
                            else 
                            {
                               console.log(data.message);
                            }
                          }
                    });
                });
        });
      ");
    * 
    */
 ?>        
 
 <script type="text/javascript" >
 jQuery( function($){
    $('.btn-rptview-opt li a').on('click', function(e) {
        e.preventDefault();
        var current_link=$(this);
        var url=current_link.attr('href');
        current_link.parent().parent().find('.active').removeClass('active');
        current_link.parent().addClass('active').css('font-weight', 'bold');
        $.ajax({url: url,
                //dataType : 'json',
                type : 'post',
                update :  '#report_main',  
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    $('#report_main').empty();
                    $('#report_main').html(data);
                }
            });
    });
    
    $('#report_body').on('click','a.btnCancelInvoice', function(e) {
            e.preventDefault(); 
            var remark = prompt('Why do you want to cancel this invoice?');
            if (remark==='') {
                 alert('Invoice is not canceled because you did not specify a reason.');
            }
            else if(remark) {
              var url=$(this).attr('href');
              $.ajax({url: url,
                     dataType : 'json',
                     type : 'post',
                     data : {remark : remark},
                     beforeSend: function() { $('.waiting').show(); },
                     complete: function() { $('.waiting').hide(); },
                     success : function(data) {
                            if (data.status==='success')
                            {
                                //$.fn.yiiGridView.update('sale-grid');
                                //$('#sale_invoice').html(data.div);
                                location.reload(true);
                            }
                            else 
                            {
                               console.log(data.message);
                            }
                       }
                 });
            }
    });
    
});
</script>
                 