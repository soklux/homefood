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

&nbsp;&nbsp;

<?php echo CHtml::activeCheckBox($model, $archived_attr, array(
    'value' => 1,
    'uncheckValue' => 0,
    'checked' => ($model->$archived_attr == 'false') ? false : true,
    'onclick' => "$.fn.yiiGridView.update('$grid_id',{data:{archived:$(this).is(':checked')}});"
)); ?>

<?= Yii::t('app','Show archived/deleted'); ?> <b> <?= Yii::t('app',$module_name); ?> </b>

