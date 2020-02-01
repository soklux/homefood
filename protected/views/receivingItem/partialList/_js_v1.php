<script>
    jQuery(function ($) {
        $('div#report_grid').on('click', 'a.btn-order', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to Perform this action?')) {
                return false;
            }
            var url = $(this).attr('href');
            $.ajax({
                url : url,
                type : 'post',
                beforeSend: function () { $('.waiting').show(); },
                complete: function () { $('.waiting').hide(); },
                success: function () {
                    //$("#report_grid").html(data);
                    $.fn.yiiGridView.update('receiving-item-grid');
                    return false;
                }
            });
        });

    });

    jQuery( function($){
        $('div#report_header').on('click','.btn-view',function(e) {
            e.preventDefault();
            var data=$("#report-form").serialize();
            $.ajax({url: '<?=  Yii::app()->createUrl($this->route); ?>',
                type : 'GET',
                //dataType : 'json',
                data : data,
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    //$("#report_grid").html(data.div); // Using with Json Data Return
                    $("#report_grid").html(data);
                    return false;
                }
            });
        });
    });
</script>