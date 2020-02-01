<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
   <meta charset="utf-8" />
   <title><?= CHtml::encode($this->pageTitle); ?></title>
   <meta name="description" content="overview &amp; stats" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
    ?>
    <?php Yii::app()->bootstrap->registerCoreCss(); ?>
     <script>
        var BASE_URL="<?php print Yii::app()->request->baseUrl;?>";
    </script>

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
   
    <!-- fontawesome --> 
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/font-awesome.min.css" />
    
    <!-- text fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-fonts.css" />
    
    <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.min.css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.onpage-help.css" />
  
    <?php /*
        $cs=Yii::app()->clientScript;
        $cs->registerCssFile($baseUrl .'/css/font-awesome.min.css');
        $cs->registerCssFile($baseUrl .'/css/ace.min.css');

        $cs->scriptMap=array(
             'font-awesome.min.css'=>$baseUrl. '/css/all_login.css',
             'ace.min.css'=> $baseUrl. '/css/all_login.css',
        );
      * 
      */
    ?>
</head>

<body class="login-layout">
<section class="main-body">
     <div class="main-container">
        <!-- Include content pages -->
        <?php echo $content; ?>
    </div>
</section>
</body>
</html>