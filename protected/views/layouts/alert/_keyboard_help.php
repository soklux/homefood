<i class="ace-icon fa fa-book"></i>
<?php echo TbHtml::tooltip(Yii::t('app','Keyboard Shortcuts Help'),'#',
    '[ESC] => Set the focus to the "Cancel Sale". [Enter] will trigger the functionality <br>
             [F2] => Set the focus to "Customer Box" <br>
             [F1] => Set the focus to "Payment Amount" [Enter] to make payment, Press another [Enter] to Complete Sale',
    array('data-html' => 'true','placement' => TbHtml::TOOLTIP_PLACEMENT_TOP,)
); ?>