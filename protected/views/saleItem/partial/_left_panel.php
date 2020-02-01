<!-- #section:left.panel-->
<div class="col-xs-12 col-sm-8 widget-container-col">

    <!-- #section:left.panel.header-->
    <?php $this->renderPartial('partial/_left_panel_header',
        array('model' => $model,
              'employee_id' => $employee_id,
              'sale_header' => $sale_header,
              'sale_header_icon' => $sale_header_icon,
              'color_style' => $color_style,
              'count_item' => $count_item,
        ));
    ?>
    <!-- /section:left.panel.header-->

    <!-- #section:left.panel.grid.cart-->
    <?php $this->renderPartial('partial/_left_panel_grid_cart', array(
            'model' => $model,
            'items' => $items,
            'disable_editprice' => $disable_editprice,
            'disable_discount' => $disable_discount,
            'discount_symbol' => $discount_symbol,
            ));
    ?>
    <!-- /section:left.panel.grid.cart -->

    <?php $this->renderPartial('//layouts/alert/_keyboard_help') ?>


</div>
<!-- /section:left.panel -->