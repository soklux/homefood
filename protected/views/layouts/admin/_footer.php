<script>
    jQuery( function($){
        $('div#<?= $main_div_id ?>').on('click','a.btn-undodelete',function(e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to activate this Item?')) {
                return false;
            }
            var url=$(this).attr('href');
            $.ajax({url:url,
                type : 'post',
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function() {
                    $.fn.yiiGridView.update('<?= $grid_id ?>');
                    return false;
                }
            });
        });

        $('div#<?= $main_div_id ?>').on('click','a.btn-inactive',function(e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to inactive this Item?')) {
                return false;
            }
            var url=$(this).attr('href');
            //alert(url);
            $.ajax({url:url,
                type : 'post',
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function() {
                    $.fn.yiiGridView.update('<?= $grid_id ?>');
                    return false;
                }
            });
        });

        $('.search-form form').submit(function(e) {
            e.preventDefault();
            $.fn.yiiGridView.update('<?= $grid_id ?>', {
                data: $(this).serialize()
            });
            return false;
        });

        $('div#<?= $main_div_id ?>').on('change','.change-pagesize',function(e) {
            e.preventDefault();
            $.fn.yiiGridView.update('<?= $grid_id ?>', {
                data: {pageSize:$(this).val()}
            });
            return false;

        });

    });

    $(document).ready(function () {
        window.setTimeout(function () {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function () {
                $(this).remove();
            });
        }, 2000);
    });

</script>

<?php $this->widget('ext.modaldlg.EModalDlg'); ?>

<div class="waiting"><!-- Place at bottom of page --></div>