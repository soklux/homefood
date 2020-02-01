<?php
Yii::app()->clientScript->registerScript( 'deleteItem', "
        jQuery( function($){
            $('div#grid-cart,div#grid_cart').on('click','a.delete-item',function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').slideDown(); },
                        complete: function() { $('.waiting').slideUp(); },
                        success : function(data) {
                            $('#register_container').html(data);
                          }
                    });
                });
        });
      ");
?>

<script>

    var submitting = false;

    $(document).ready(function()
    {
        //Here just in case the loader doesn't go away for some reason
        $('.waiting').slideUp();

        // ajaxForm to ensure is submitting as Ajax even user press enter key
        $('#add_item_form').ajaxForm({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: itemScannedSuccess});

        $('.line_item_form').ajaxForm({target: "#register_container", beforeSubmit: receivingsBeforeSubmit });

        $('#total_discount_form').ajaxForm({target: "#register_container", beforeSubmit: receivingsBeforeSubmit});

        $('#cart_contents').on('change','input.input-grid',function(e) {
            e.preventDefault();
            $(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit });
        });

        $('#cancel_cart').on('click','#cancel_receiving_button',function(e) {
            e.preventDefault();
            if (confirm("<?php echo Yii::t('app','Are you sure you want to clear this receiving? All items will cleared.'); ?>")){
                $('#cancel_recv_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit});
            }
        });

        $('#supplier_cart').on('click','a.detach-supplier', function(e) {
            e.preventDefault();
            $('#supplier_selected_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit});
        });

        $('#total_discount_cart').on('change','input.input-totaldiscout',function(e) {
            e.preventDefault();
            $(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit });
        });

        $('#outlet,#InventoryCount_created_date,#InventoryCount_count_time,#InventoryCount_count_name').change(function(){
           // alert('hello')
            $('#set-outlet-form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit});
        })

        $('.input-mask-date').mask('99/99/9999');

    });

    function receivingsBeforeSubmit(formData, jqForm, options)
    {
        if (submitting)
        {
            return false;
        }
        submitting = true;
        $('.waiting').slideDown();
    }

    function itemScannedSuccess(itemId)
    {
        return function (responseText, statusText, xhr, $form ) {
            setTimeout(function(){$('#quantity_' + itemId).select();}, 10);
        }
    }

    /*function itemScannedSuccess(responseText, statusText, xhr, $form)
    {
        setTimeout(function(){$('#ReceivingItem_item_id').focus();}, 10);
    }*/

</script>

<?php Yii::app()->clientScript->registerScript('setFocus', '$("#ReceivingItem_item_id").focus();'); ?>



<?php
Yii::app()->clientScript->registerScript( 'setComment', "
        jQuery( function($){
            $('#comment_content').on('change','#comment_id',function(e) {
                e.preventDefault();
                var comment=$(this).val();
                $.ajax({
                        url: 'SetComment',
                        dataType : 'json',
                        data : {comment : comment},
                        type : 'post',
                        beforeSend: function() { $('.waiting').slideDown(); },
                        complete: function() { $('.waiting').slideUp(); },
                        success : function(data) {
                                if (data.status==='success')
                                {
                                    console.log('comment saved');

                                }
                                else
                                {
                                    alert('someting wrong');
                                    return false;
                                }
                       }
                 });
            });
        });
      ");
?>