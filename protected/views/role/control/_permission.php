<div class="row">
    <div class="col-sm-12">
        <div class="widget-box widget-color-blue" id="widget-box-2">

            <?php $this->renderPartial('//role/control/_permission_header', array(
                'header_title' => $header_title,
                'header_icon' => $header_icon,
            )) ?>

            <?php $this->renderPartial('//role/control/_permission_content', array(
                'user' => $user,
                'grid_items' => $grid_items,
            )) ?>

        </div>
    </div>
</div>
