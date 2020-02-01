<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" charset="UTF-8" /> 
   <meta charset="utf-8" />
   <title><?= bizNameFirstUpper() . ' ' . bizTitleUcWord() . ' - ' . companySloganUcwords() ?></title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
     <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
    ?>
    <?php Yii::app()->bootstrap->register(); ?>
    
    <!--<link rel="icon" type="image/ico" href="<?php /*echo baseurl() */?>/css/img/bakouicon.ico" />-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= baseurl() ?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= baseurl() ?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= baseurl() ?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= baseurl() ?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= baseurl() ?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= baseurl() ?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= baseurl() ?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= baseurl() ?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= baseurl() ?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= baseurl() ?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= baseurl() ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= baseurl() ?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= baseurl() ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= baseurl() ?>/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= baseurl() ?>/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <!-- bootstrap & fontawesome -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo baseurl() ?>/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/colorbox.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/ace-fonts.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/ace.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/ace-skins.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/ace-rtl.min.css" />

     <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/font-awesome.css" />
    
    <!-- page specific plugin styles -->

    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/ace.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/ace-skins.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/ace-rtl.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/loading_animation.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/jquery-ui-1.10.4.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="<?= baseurl() ?>/css/jquery-confirm.min.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo baseurl() ?>/css/pace.css" />
    <script data-pace-options='{ "ajax": true, "document": true, "eventLag": false, "elements": false }' src="<?php echo baseurl() ?>/js/pace.js"></script>
    
    <!-- ace settings handler -->
    <?php //$cs->registerScriptFile(baseurl().'/js/bootstrap.min.js',CClientScript::POS_END); ?> 
    
    <?php //$this->widget( 'ext.modaldlg.EModalDlg' ); ?>
   
    <?php
        cs()->registerScriptFile(baseurl().'/js/ace-extra.min.js',CClientScript::POS_END);
        cs()->registerScriptFile(baseurl().'/js/jquery.gritter.min.js',CClientScript::POS_END);
        cs()->registerScriptFile(baseurl().'/js/ace-elements.min.js',CClientScript::POS_END);
        cs()->registerScriptFile(baseurl().'/js/ace.min.js',CClientScript::POS_END);;
        cs()->registerScriptFile(baseurl().'/js/jquery.form.min.js',CClientScript::POS_END);
        cs()->registerScriptFile(baseurl().'/js/jquery-ui.min.js',CClientScript::POS_END);
        cs()->registerScriptFile(baseurl().'/js/ace.js',CClientScript::POS_BEGIN);
        cs()->registerScriptFile(baseurl().'/js/jquery.flot.min.js',CClientScript::POS_BEGIN);
        cs()->registerScriptFile(baseurl().'/js/jquery.flot.pie.min.js',CClientScript::POS_BEGIN);
        cs()->registerScriptFile(baseurl().'/js/elements.fileinput.js',CClientScript::POS_BEGIN);
        cs()->registerScriptFile(baseurl().'/js/chosen.jquery.js',CClientScript::POS_BEGIN);
        cs()->registerScriptFile(baseurl().'/js/fine-upload.js',CClientScript::POS_BEGIN);
        cs()->registerScriptFile(baseurl().'/js/jquery-confirm.min.js',CClientScript::POS_END);
    ?>

    <?php
/*        if (Yii::app()->components['user']->loginRequiredAjaxResponse){
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
    */?>
</head>

<body class="no-skin">
    <div id="menu">
        <!-- #section:basics/navbar.layout -->
        <section id="navigation-main">  
        <!-- Require the navigation -->
        <?php require_once('tpl_navigation.php')?>
        </section> <!-- /#navigation-main --> 
    </div> <!--/ menu -->

    <!-- <section class="main-body"> -->
        <!-- /section:basics/navbar.layout -->
        <div class="main-container" id="main-container">
            <!-- #section:basics/sidebar.mobile.toggle -->
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>
            <!-- #section:basics/sidebar -->
            <div id="sidebar" class="sidebar responsive">
                <script type="text/javascript">
                        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
                </script>

                <?php require_once('tpl_sidebar_shortcut.php')?>

                
                <?php require_once('tpl_sidebar_v2.php')?>
            </div> <!-- /#side-bar --> 

            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div class="breadcrumbs" id="breadcrumbs">
                        <?php if(isset($this->breadcrumbs)):?>
                              <?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
                                    'links' => $this->breadcrumbs,
                              )); ?>
                        <?php endif?>
                </div>
                <div class="page-content">
                    <div class="row">
                      <div class="col-xs-12">
                        <!-- Include content pages -->
                        <?= $content; ?>
                      </div>
                    </div>
                </div>
            </div> <!--/.main-content-->
            <!-- Require the footer -->
            <?php require_once('tpl_footer.php')?>
            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!--/.main-container-->
    <!-- </section> <!--/.main-body-->
   
  </body>
</html>