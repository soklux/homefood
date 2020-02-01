<?php
$this->breadcrumbs=array(
    'Home' => array('home'),
);
?>

<!-- PAGE CONTENT BEGINS -->
<div class="row">

    <?php $this->renderPartial('pages/_sale') ?>

    <?php $this->renderPartial('pages/_product') ?>

    <?php $this->renderPartial('pages/_customer') ?>


</div>

<script>
    $( ".btn-app" ).tooltip({
        show: {
            effect: "slideDown",
            delay: 250
        }
    });
</script>