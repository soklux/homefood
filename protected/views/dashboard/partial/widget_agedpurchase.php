<div class="row">
    <div class="col-xs-5 widget-container-col">
        <div class="widget-box widget-color-blue2">
			<div class="widget-header">
				<h5 class="widget-title bigger lighter">
					<i class="ace-icon fa fa-trophy"></i>
					<?php echo Yii::t('app','Aged Customer Purchase') ?>
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<!-- #section:plugins/charts.flotchart -->
					<div id="piechart-placeholder"></div>

					<!-- /section:plugins/charts.flotchart -->
					<div class="hr hr8 hr-double"></div>

					<?php foreach ($report->dbAgedPurchase() as $value) {    ?>

					<div class="clearfix">
						<div class="grid3">
							<span class="grey">
								<i class="ace-icon fa fa-users fa-2x blue"></i>
								<?= $value["aged_purchase"] ?>
							</span>
							<h4 class="bigger pull-right">
								<a href="<?= Yii::app()->createUrl('report/agedcustomerpurchase', array('filter' => $value["ord"])); ?>"> 
									<?= $value['nclient'] ?>        
								</a>
							</h4>
						</div>      
					</div>
					<?php } ?>  
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    <?php
    $colors = ["#68BC31", "#2091CF", "#AF4E96", "#DA5430", "#FEE074"];
    $i = 0;
    ?>
    var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
              var data = [

                <?php foreach ($report->dbAgedPurchase() as $value) {    ?> 
                    {label: "<?= $value["aged_purchase"] ?>", data: <?= $value['nclient'] ?>, color: "<?php echo $colors[$i] ?>"},
                <?php $i++;} ?>
              ]
              
      function drawPieChart(placeholder, data, position) {
          $.plot(placeholder, data, {
            series: {
                pie: {
                    show: true,
                    tilt:0.8,
                    highlight: {
                        opacity: 0.25
                    },
                    stroke: {
                        color: '#fff',
                        width: 2
                    },
                    startAngle: 2
                }
            },
            legend: {
                show: true,
                position: position || "ne", 
                labelBoxBorderColor: null,
                margin:[-30,15]
            }
            ,
            grid: {
                hoverable: true,
                clickable: true
            }
         })
     }
    
    drawPieChart(placeholder, data);


    placeholder.data('chart', data);
    placeholder.data('draw', drawPieChart);

    //pie chart tooltip example
    var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
    var previousPoint = null;

    placeholder.on('plothover', function (event, pos, item) {
        if(item) {
            if (previousPoint != item.seriesIndex) {
                previousPoint = item.seriesIndex;
                var tip = item.series['label'] + " : " + item.series['percent']+'%';
                $tooltip.show().children(0).text(tip);
            }
            $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
        } else {
            $tooltip.hide();
            previousPoint = null;
        }
        
    });

</script>