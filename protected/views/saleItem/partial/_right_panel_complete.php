<?php if ($count_check > 0) { ?>
    <table class="table table-striped table-condensed">

        <?php //if ($amount_change<=0) { ?>

        <td colspan="3" style='text-align:right'>
            <?php $type=Yii::app()->session['tran_type'];?>
            <?php $btn_text = $type==param('sale_submit_status') ? 'Save' : ($type==param('sale_validate_status') ? 'Save' : ($type==param('sale_complete_status') ? 'Save' :''));?>
            <?php
            echo TbHtml::linkButton(Yii::t('app', $btn_text), array(
                'color' => $color_style,
                'icon' => 'glyphicon glyphicon-off white',
                'url' => Yii::app()->createUrl('SaleItem/CompleteSale/'),
                'class' => 'complete-sale',
                'id' => 'finish_sale_button',
                //'title' => Yii::t('app', 'Complete Sale'),
            ));
            ?>
        </td>
        <!--
            <div id="comment_content" align="right">
            <?php //echo $form->textArea($model,'comment',array('rows'=>1, 'cols'=>20,'class'=>'input-small','maxlength'=>250,'id'=>'comment_id'));  ?>
            </div>
        -->
        <?php //} ?>
        </tbody>
    </table>
<?php } ?>



