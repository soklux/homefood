<?php
    $this->pageTitle = Yii::app()->name;
    $baseUrl = Yii::app()->theme->baseUrl;
?>
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
            <!-- #section:basics/sidebar.mobile.toggle -->
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
            </button>

            <!-- /section:basics/sidebar.mobile.toggle -->
            <div class="navbar-header pull-left">
                    <!-- #section:basics/navbar.layout.brand -->
                    <!--<img src="<?/*=$baseUrl.'/images/logo/piidor_logo.png'*/?>" height="45px">-->
                     <a href="#" class="navbar-brand">
                        <small>
                            <!--<img src="/images/peedor_logo.png" width="20px">-->
                            <i class="fa fa-free-code-camp red bolder"></i>
                            <?= bizNameFirstUpper() . ' System' ?>
                        </small>
                    </a>
                    <!-- /section:basics/navbar.layout.brand -->

            </div>

            <!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation" id="notification-drop-down">
                    <ul class="nav ace-nav">
                        <li class="white">
                            <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>">
                                <i class="ace-icon fa fa-power-off"></i>
                                <?= Yii::t('app','Logout'); ?>
                            </a>
                        </li>

                        <li class="green">
                            <a href="#"><?php echo Yii::app()->settings->get('site', 'companyName'); ?>
                                <!--<i class="ace-icon fa fa-bell icon-animated-bell"></i>-->
                                <span class="label label-xlg label-important"><?php echo "Main Outlet"; //Yii::app()->getsetSession->getLocationName(); ?></span>
                            </a>
                        </li>
                        <!---this area prepare for notification alert--->
                        <?php //$count=ClickNotificationClient::model()->count(); ?>
                        <li class="purple dropdown-modal">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                <span class="badge badge-important notification-event-count"></span>
                            </a>
                            <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-exclamation-triangle"></i>Notifications
                                </li>

                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                        <li>
                                            <a href="#" class="approved-event-click">
                                                <div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
														New Order Approved
													</span>
                                                    <span class="pull-right badge badge-success approved-event-count"></span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href='#' class="rejected-event-click">
                                                <div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
														New Order Rejected
													</span>
                                                    <span class="pull-right badge badge-info rejected-event-count"></span>
                                                </div>
                                            </a>
                                        </li>

                                        <!--<li>
                                            <a href="#">
                                                <i class="btn btn-xs btn-primary fa fa-user"></i>
                                                Bob just signed up as an editor ...
                                            </a>
                                        </li>-->

                                        <!--<li>
                                            <a href="#">
                                                <div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
														Followers
													</span>
                                                    <span class="pull-right badge badge-info">+11</span>
                                                </div>
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="#">
                                        <!--See all notifications
                                        <i class="ace-icon fa fa-arrow-right"></i>-->
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="light-blue">
                            <a>
                                <i class="glyphicon glyphicon-time"></i>
                                <?= date("H:i j M Y"); ?>
                            </a>
                        </li>
                       
                        <li class="light-blue">
                                <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                    <!-- <img class="nav-user-photo" alt="Jasos Photo" src="<?php //echo Yii::app()->theme->baseUrl . '/avatars/user.jpg'; ?>" /> -->
                                    <span class="user-info">
                                            <small> <?= Yii::t('app','Welcome'); ?>,</small>
                                            <?php echo CHtml::encode(ucwords(Yii::app()->user->name)); ?>
                                    </span>
                                    <i class="ace-icon fa fa-caret-down"></i>
                                </a>

                                <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                    <!--
                                    <li>
                                        <a href="<?php //echo Yii::app()->urlManager->createUrl('Employee/View', array('id' => Yii::app()->session['employeeid'])); ?>">
                                                <i class="ace-icon fa fa-user"></i>
                                                Profile
                                        </a>
                                    </li>
                                    -->
                                    <li>
                                        <a href="<?php echo Yii::app()->urlManager->createUrl('RbacUser/Update', array('id' => Yii::app()->user->id)); ?>">
                                                <i class="ace-icon fa fa-key"></i>
                                                <?= Yii::t('app','Change Password'); ?>
                                        </a>
                                    </li>
                                </ul>
                        </li>

                            <!-- /section:basics/navbar.user_menu -->
                    </ul>
            </div>

            <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        function checkNotification()
        {
            var url='<?= Yii::app()->createUrl("ClickNotificationLog/CheckNotification"); ?>';
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                success : function(response) {
                    $('.notification-event-count').html(response.count_total);
                    $('.rejected-event-count').html(response.count_rejected);
                    $('.approved-event-count').html(response.count_approved);
                }
            });
        }
        //Every 20 sec check if there is new update
        checkNotification();
        window.setInterval(checkNotification,20000);

        $('div#notification-drop-down').on('click', 'a.rejected-event-click', function(){
            var url='<?= Yii::app()->createUrl("ClickNotificationLog/VisitRejectedNotify"); ?>';
            var visit_url='<?= Yii::app()->createUrl("report/SaleInvoice"); ?>';
            $.ajax({
                type: 'POST',
                url: url,
                beforeSend: function () { $('.waiting').show(); },
                complete: function () { $('.waiting').hide(); },
                //dataType: 'json',
                success : function(response) {
                    window.location.href=visit_url;
                }
            });

        });

        $('div#notification-drop-down').on('click', 'a.approved-event-click', function(){
            var url='<?= Yii::app()->createUrl("ClickNotificationLog/VisitApprovedNotify"); ?>';
            var visit_url='<?= Yii::app()->createUrl("report/SaleInvoice"); ?>';
            $.ajax({
                type: 'POST',
                url: url,
                //dataType: 'json',
                beforeSend: function () { $('.waiting').show(); },
                complete: function () { $('.waiting').hide(); },
                success : function(response) {
                    window.location.href=visit_url;
                }
            });

        });
    });
</script>