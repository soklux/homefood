<div class="row">
    <div id="cancel_cart">
        <?php if ($count_item <> 0) { ?>
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'suspend_sale_form',
                'action' => Yii::app()->createUrl('saleItem/SuspendSale/'),
                'enableAjaxValidation' => false,
                'layout' => TbHtml::FORM_LAYOUT_INLINE,
            ));
            ?>
            <div align="right">
                <?php
/*                echo TbHtml::linkButton(Yii::t('app', 'Save Sale'), array(
                    'color' => TbHtml::BUTTON_COLOR_INFO,
                    'size' => TbHtml::BUTTON_SIZE_SMALL,
                    'icon' => 'ace-icon fa fa-save white',
                    'url' => Yii::app()->createUrl('SaleItem/SuspendSale/'),
                    'class' => 'suspend-sale',
                    //'title' => Yii::t('app', 'Suspend Sale'),
                ));
                */?>

                <?php
                echo TbHtml::linkButton(Yii::t('app', 'Empty Cart'), array(
                    'color' => TbHtml::BUTTON_COLOR_DANGER,
                    'size' => TbHtml::BUTTON_SIZE_SMALL,
                    'icon' => '	glyphicon-remove white',
                    'url' => Yii::app()->createUrl('SaleItem/CancelSale/'),
                    'class' => 'cancel-sale',
                    'id' => 'cancel_sale_button',
                    //'title' => Yii::t('app', 'Cancel Sale'),
                ));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        <?php } ?>
    </div>
</div>