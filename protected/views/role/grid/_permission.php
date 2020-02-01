<div class="row">
    <div class="col-sm-12">
        <div class="widget-box widget-color-blue" id="widget-box-2">

            <?php $this->renderPartial('//role/grid/_permission_header', array(
                'header_title' => $header_title,
                'header_icon' => $header_icon,
            )) ?>

            <?php $this->renderPartial('//role/grid/_permission_content', array(
                'user' => $user,
                'grid_items' => $grid_items,
                'auth_items' => $auth_items,
            )) ?>

            <?php /* print_r($user->items) */?>

        </div>
    </div>
</div>


<style>
    .role-table td.permission{
        min-width: 70px;
        text-align: center;
    }
</style>