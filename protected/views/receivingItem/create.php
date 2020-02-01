<?php
$this->breadcrumbs=array(
    'Inventory Count' =>array('index?trans_mode=physical_count'),
    'Create',
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    //'action'=>$this->createUrl('Item/Create'),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data')
)); ?>
    <?php $this->renderPartial('_form', array(
            'model'=>$model,
            'receiveItem'=>$receiveItem,
            'data_provider'=>$data_provider,
            'grid_id' => $grid_id,
            'page_size' => $page_size,
            'grid_columns' => $grid_columns,
        ));
    ?>

<?php $this->endWidget();?>

