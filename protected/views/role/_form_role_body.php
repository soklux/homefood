<div class="widget-body">
    <div class="widget-main no-padding">
        <table class="table table-bordered role-table">

            <?php $this->renderPartial('_grid_header') ?>

            <?php
            $permissions = array(
                'Item' => "item",
                'Category' => "category",
                'Price Book' => "pricebook"
            );
            ?>

            <?php foreach ($permissions as $id => $item): ?>

                <?php $this->renderPartial('_grid_body', array(
                        'row_title' => $id,
                        'permission' => $item,
                )) ?>

            <?php endforeach; ?>

         </table>

    </div>
</div>


<script>
    $('[rel=popover]').popover({
        html:true,
        placement:'bottom',
        content:function(){
            return $($(this).data('contentwrapper')).html();
        }
    });
</script>