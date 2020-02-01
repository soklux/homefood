<div class="grid-view" id="grid-cart">

    <div class="col-sm-12">
        <div class="col-sm-12" id="lasted-count">

                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Counted</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <?php if(!empty($items)):?>

                    <tbody id="cart_contents">
                        <?php foreach($items as $key=>$item):?>
                            <tr>
                                <td width="30"><?=$item['item_id']?></td>
                                <td><?=$item['name']?></td>
                                <td width="100">
                                     <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                            'method'=>'post',
                                            'action' => Yii::app()->createUrl('receivingItem/EditItemCount/',array('item_id'=>$item['item_id'])),
                                            'htmlOptions'=>array('class'=>'line_item_form'),
                                        ));
                                    ?>
                                    <div class="col-sm-12">
                                        <input type="text" name="InventoryCount[quantity]" id="quantity_<?=$item['item_id']?>" class="form-control" value="<?=$item['quantity']?>">
                                    </div>
                                    <?php $this->endWidget()?>
                                </td>
                                <td width="80" align="center">
                                    <?php
                                        echo TbHtml::linkButton('', array(
                                            'color'=>TbHtml::BUTTON_COLOR_DANGER,
                                            'size' => TbHtml::BUTTON_SIZE_MINI,
                                            'icon' => 'glyphicon glyphicon-trash ',
                                            'url' => array('DeleteItemCount', 'item_id' => $item['item_id']),
                                            'class' => 'delete-item',
                                            'title' => Yii::t('app', 'Remove'),
                                        ));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                    <?php endif;?>
                </table>

        </div>
    </div>
</div>