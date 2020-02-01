<?php if (ckacc('sale.create')) { ?>

    <?= TbHtml::linkButton(Yii::t('app',  'Add Sale Order'), array(
        'color' => TbHtml::BUTTON_COLOR_SUCCESS,
        'size' => TbHtml::BUTTON_SIZE_SMALL,
        'icon' => 'ace-icon fa fa-plus white',
        'url' => $this->createUrl('saleItem/update'),
    )); ?>

    <?php /* echo  TbHtml::linkButton(Yii::t('app',  'Add Invoice'), array(
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        'size' => TbHtml::BUTTON_SIZE_SMALL,
        'icon' => 'ace-icon fa fa-plus white',
        'url' => $this->createUrl('saleItem/update',array('tran_type' => '1')),
    )); */?>

<?php } ?>

<!--<a href="<?/*= Yii::app()->createUrl('saleItem/reminder'); */?>">
    <i class="ace-icon fa fa-bell-o"></i>
    <?/*= t('invoice reminder off','app'); */?>
</a>-->