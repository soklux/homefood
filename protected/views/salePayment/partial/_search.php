<script>
    
var submitting = false;

$(document).ready(function()
{   
    //Here just in case the loader doesn't go away for some reason
   $('.waiting').hide();
    
   $('#client_cart').on('click','a.detach-customer', function(e) {
        e.preventDefault();
        $('#client_selected_form').ajaxSubmit({target: "#payment_container", beforeSubmit: paymentBeforeSubmit});
    });

    $('div#payment_container').on('click','a.btn-invoice-payment',function(e) {
        e.preventDefault();
        var url=$(this).attr('href');
        $.ajax({url:url,
            type : 'post',
            beforeSend: function() { $('.waiting').show(); },
            complete: function() { $('.waiting').hide(); },
            success : function(data) {
                $('#payment_container').html(data);
                return false;
            }
        });
    });

    $('#client_cart').on('click','a.detach-invoice', function(e) {
        e.preventDefault();
        $('#invoice_selected_form').ajaxSubmit({target: "#payment_container", beforeSubmit: paymentBeforeSubmit});
    });
    
    $('#sale-payment-form').ajaxForm({target: "#payment_container", beforeSubmit: paymentBeforeSubmit, success: paymentAferSubmit});
    
    $('#sale_payment_cart').on('click','a.save-payment',function(e) {
           e.preventDefault();
           $("#save_payment_button").hide();
           if (confirm("<?php echo Yii::t('app','Are you sure you want to submit this payment? This cannot be undone.'); ?>")){
               $('.waiting').hide();
               $('#sale-payment-form').submit();
           } else { //Bring back submit and unmask if fail to confirm
               $("#save_payment_button").show();
           }
    });
    
    $('#sale_payment_cart').on('keypress','.payment-amount-txt',function(e) {
        if (e.keyCode === 13 || e.which === 13)
        {
           e.preventDefault();
           $("#save_payment_button").hide();
           if (confirm("<?php echo Yii::t('app','Are you sure you want to submit this payment? This cannot be undone.'); ?>")){
               $('#sale-payment-form').submit();
           } else { //Bring back submit and unmask if fail to confirm
               $("#save_payment_button").show();
           }
        }    
    });
    
});

function paymentBeforeSubmit(formData, jqForm, options)
{
    if (submitting)
    {
        return false;
    }
    submitting = true;
    $('.waiting').show();
}   

function paymentAferSubmit(responseText, statusText, xhr, $form)
{
    $('.waiting').hide();
}  

function removeCusAferSubmit(responseText, statusText, xhr, $form)
{
    $('.waiting').show();
    window.location.href='index';
}

function clientScannedSuccess(responseText, statusText, xhr, $form)
{
    $('.waiting').hide();
    setTimeout(function(){$('#SalePayment_payment_amount').focus();}, 10);
} 

</script>

<?php if ($client_name == '') { ?>
    <?php Yii::app()->clientScript->registerScript('setFocus', '$("#SalePayment_client_id").focus();'); ?>
<?php } else { ?>
    <?php Yii::app()->clientScript->registerScript('setFocus', '$("#SalePayment_payment_amount").focus();'); ?>
<?php } ?>

