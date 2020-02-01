<?= TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
    'color'=>TbHtml::BUTTON_COLOR_PRIMARY
    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
));