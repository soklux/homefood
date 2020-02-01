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
                success: function() {
                    //$("#report_grid").html(data);
                    //$("#sale-order-grid").html(data);
                    $.fn.yiiGridView.update('sale-order-grid');
                    return false;
                }
            });
        });
    });

    /*jQuery(function ($) {
        $('div#report_grid').on('click', 'a.btn-order-invalid', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');

            $.confirm({
                title: 'Prompt!',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Please enter your reason</label>' +
                    '<input type="text" placeholder="Your reject reason" class="reason_name form-control" required />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    confirm: {
                        text: 'Submit',
                        btnClass: 'btn-success',
                        action: function () {
                            var name = this.$content.find('.reason_name').val();
                            if(!name){
                                $.alert('Please provide a valid reason!');
                                return false;
                            }
                            //$.alert('Your name is ' + name);
                            $.ajax({
                                url : url,
                                type : 'post',
                                data : {reason: name},
                                beforeSend: function () { $('.waiting').show(); },
                                complete: function () { $('.waiting').hide(); },
                                success: function () {
                                    //$("#sale-order-grid").html(data);
                                    $.fn.yiiGridView.update('sale-order-grid');
                                    return false;
                                }
                            });
                        }
                    },
                    cancel: function () {
                        //close
                    },
                }
            });
        });
    });*/

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