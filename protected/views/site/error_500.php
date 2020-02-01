<?php
/*$this->breadcrumbs=array(
    'Go Back'=> Yii::app()->request->urlReferrer,
);*/
?>

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- #section:pages/error -->
        <div class="error-container">
            <div class="well">
                <h1 class="grey lighter smaller">
                    <span class="blue bigger-125">
                            <i class="ace-icon fa fa-random"></i>
                            <?php echo $err_no; ?>
                    </span>
                    <?php echo $header; ?>
                </h1>

                <hr />

                <h3 class="lighter smaller">
                        <?php echo $subject; ?>
                        <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
                </h3>

                <div class="space"></div>

                <div>
                    <h4 class="lighter smaller">Try one of the following:</h4>

                    <ul class="list-unstyled spaced inline bigger-110 margin-15">

                            <?php foreach ($bodies as $id => $body): ?>

                           <li>
                                  <i class="ace-icon fa fa-hand-o-right blue"></i>
                                  <?php echo $body; ?>
                           </li>

                           <?php endforeach; ?>
                    </ul>
                </div>

                <hr />
                <div class="space"></div>

                <div class="center">
                        <a href="javascript:history.back()" class="btn btn-grey">
                            <i class="ace-icon fa fa-arrow-left"></i>
                            Go Back
                        </a>

                        <a href="<?php echo Yii::app()->createUrl('dashboard/view'); ?>" class="btn btn-primary">
                            <i class="ace-icon fa fa-tachometer"></i>
                            Dashboard
                        </a>
                </div>


            </div>
        </div>

        <!-- /section:pages/error -->

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->