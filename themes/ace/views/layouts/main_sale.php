<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
   <meta charset="utf-8" />
   <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
    ?>
    <?php Yii::app()->bootstrap->register(); ?>
    
    <!--<link rel="icon" type="image/ico" href="<?php /*echo $baseUrl */?>/css/img/bakouicon.ico" />-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $baseUrl ?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $baseUrl ?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $baseUrl ?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $baseUrl ?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $baseUrl ?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $baseUrl ?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= $baseUrl ?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $baseUrl ?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $baseUrl ?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= $baseUrl ?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseUrl ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $baseUrl ?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseUrl ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $baseUrl ?>/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= $baseUrl ?>/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <!-- bootstrap & fontawesome -->
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/font-awesome.min.css" />
    
    <!-- page specific plugin styles -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/jquery-ui.custom.min.css" /> -->
    
    <!-- text fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-fonts.css" />
    
    <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.min.css" />
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-part2.min.css" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-skins.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-rtl.min.css" />
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-ie.min.css" />
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/loading_animation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/jquery-ui-1.10.4.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/jquery.gritter.css" />
    
    <!-- ace settings handler -->
    <?php //$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js',CClientScript::POS_END); ?> 
   
    <?php
        $cs->registerScriptFile($baseUrl.'/js/ace-extra.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery-ui.custom.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery.ui.touch-punch.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.gritter.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery.slimscroll.min.js',CClientScript::POS_END); 
        //$cs->registerScriptFile($baseUrl.'/js/jquery.bxslider.min.js',CClientScript::POS_END); 
        //$cs->registerScriptFile($baseUrl.'/js/jquery.colorbox-min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.maskedinput.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/ace-elements.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/ace.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery.jkey.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/common.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.form.min.js',CClientScript::POS_END);
    ?>
    
    <?php 
        if (Yii::app()->components['user']->loginRequiredAjaxResponse){
            Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
                jQuery("body").ajaxComplete(
                    function(event, request, options) {
                        if (request.responseText == "'.Yii::app()->components['user']->loginRequiredAjaxResponse.'") {
                            window.location.href = options.url;
                        }
                    }
                );
            ');
        }
    ?>
</head>

<body class="no-skin">
    <div id="menu">
        <!-- #section:basics/navbar.layout -->
        <section id="navigation-main">  
        <!-- Require the navigation -->
        <?php require_once('tpl_navigation.php')?>
        </section> <!-- /#navigation-main --> 
    </div> <!--/ menu -->


    <!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container"> 
        <!-- #section:basics/sidebar.mobile.toggle -->
        <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>
       
        <!-- #section:basics/sidebar -->
        <div class="sidebar responsive menu-min" id="sidebar">
            <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>
            <?php require_once('tpl_sidebar_shortcut.php')?>
            <?php require_once('tpl_sidebar_v2.php')?>
        </div> <!-- /#side-bar -->

        <!-- /section:basics/sidebar.horizontal -->
        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                    <?php if(isset($this->breadcrumbs)):?>
                          <?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
                                'links' => $this->breadcrumbs,
                          )); ?>
                    <?php endif?>
               
                    <!--
                    <div class="nav-search" id="nav-search">
                        <form class="form-search" />
                                <span class="input-icon">
                                        <input type="text" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
                                        <i class="icon-search nav-search-icon"></i>
                                </span>
                        </form>
                    </div>
                    -->
            </div> 

            <div class="page-content">
                <div class="row">
                  <div class="col-xs-12">
                    <!-- Include content pages -->
                      <?php echo $content; ?>
                  </div>
                </div>
            </div>

        <!--</div> --><!--/.main-content-->

        <!-- Require the footer -->
        <?php require_once('tpl_footer.php')?>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
            
    </div><!--/.main-container-->
 
   
  </body>
</html>