<div class="nav-search search-form" id="nav-search">
    <?php $this->renderPartial('//layouts/admin/_search', array(
        'model' => $model,
    )); ?>
</div>

<?php if (Yii::app()->user->checkAccess($create_permission)) { ?>

    <?php echo TbHtml::linkButton(Yii::t('app', 'Add New'), array(
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        'size' => TbHtml::BUTTON_SIZE_SMALL,
        'icon' => 'ace-icon fa fa-plus white',
        'url' => $this->createUrl($create_url),
    )); ?>

<?php } ?>

