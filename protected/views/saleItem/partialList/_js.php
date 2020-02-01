<script>

    /*
    jQuery(function ($) {
        $('div#report_grid').on('click', 'a.btn-order-approve', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to APPROVE this order?')) {
                return false;
            }
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                beforeSend: function () {
                    $('.waiting').show();
                },
                complete: function () {
                    $('.waiting').hide();
                },
                success: function (data) {
                    $("#report_grid").html(data);
                    $('.nav-tabs a[href="#tab_3"]').tab('show');
                    $.fn.yiiGridView.update('sale-order-wait-grid');
                    $.fn.yiiGridView.update('sale-order-review-grid');
                    $.fn.yiiGridView.update('sale-order-complete-grid');
                    $.fn.yiiGridView.update('sale-order-grid');
                    return false;
                }
            });
        });

    });

    jQuery(function ($) {
        $('div#report_grid').on('click', 'a.btn-order-complete', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to Complete this order?')) {
                return false;
            }
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                beforeSend: function () {
                    $('.waiting').show();
                },
                complete: function () {
                    $('.waiting').hide();
                },
                success: function (data) {
                    $("#report_grid").html(data);
                    $('.nav-tabs a[href="#tab_4"]').tab('show');
                    $.fn.yiiGridView.update('sale-order-complete-grid');
                    $.fn.yiiGridView.update('sale-order-grid');
                    $.fn.yiiGridView.update('sale-order-wait-grid');
                    $.fn.yiiGridView.update('sale-order-review-grid');
                    return false;
                }
            });
        });

    });

    jQuery(function ($) {
        $('div#report_grid').on('click', 'a.btn-order-reject', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to Reject this order?')) {
                return false;
            }
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                beforeSend: function () {
                    $('.waiting').show();
                },
                complete: function () {
                    $('.waiting').hide();
                },
                success: function (data) {
                    $.fn.yiiGridView.update('sale-order-wait-grid');
                    $.fn.yiiGridView.update('sale-order-complete-grid');
                    $.fn.yiiGridView.update('sale-order-grid');
                    $.fn.yiiGridView.update('sale-order-review-grid');
                    return false;
                }
            });
        });

    });
    */

    // Every tab click refresh the grid view to make the sub detail view Ajax work
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        //var target = e.target.attributes.href.value;
        //var tab_number = target.substr(target.indexOf('_')+1,1) + 1;
        //var next_tab = '#tab_' + tab_number;
        //console.log(next_tab);
        //$('.nav-tabs a[href=next_tab]').tab('show');
        // $('.nav-tabs > .active').next('li').find('a').trigger('click'); // Next tab
        $.fn.yiiGridView.update('sale-order-wait-grid');
        $.fn.yiiGridView.update('sale-order-review-grid');
        $.fn.yiiGridView.update('sale-order-complete-grid');
        $.fn.yiiGridView.update('sale-order-grid');
    });

    jQuery(function ($) {
        $('div#report_grid').on('click', 'a.btn-order', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to Update this order?')) {
                return false;
            }
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                beforeSend: function () {
                    $('.waiting').show();
                },
                complete: function () {
                    $('.waiting').hide();
                },
                success: function (data) {
                    return false;
                }
            });
        });

    });
</script>

<script>
    jQuery(function ($) {
        $('div#report_header').on('click', '.btn-view', function (e) {
            e.preventDefault();
            var data = $("#report-form").serialize();
            $.ajax({
                url: '<?=  Yii::app()->createUrl($this->route); ?>',
                type: 'GET',
                //dataType : 'json',
                data: data,
                beforeSend: function () {
                    $('.waiting').show();
                },
                complete: function () {
                    $('.waiting').hide();
                },
                success: function (data) {
                    //$("#report_grid").html(data.div); // Using with Json Data Return
                    $("#report_grid").html(data);
                    return false;
                }
            });
        });
    });
</script>