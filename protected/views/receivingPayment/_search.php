<script>
    
var submitting = false;

$(document).ready(function()
{   
    //Here just in case the loader doesn't go away for some reason
   $('.waiting').hide();
    
   $('#supplier_cart').on('click','a.detach-supplier', function(e) {
        e.preventDefault();
        $('#supplier_selected_form').ajaxSubmit({target: "#payment_container", beforeSubmit: paymentBeforeSubmit});
    });
    
    $('#receiving-payment-form').ajaxForm({target: "#payment_container", beforeSubmit: paymentBeforeSubmit, success: paymentAferSubmit});
    
    $('#payment_cart').on('click','a.save-payment',function(e) {
           e.preventDefault();
           $("#save_payment_button").hide();
           if (confirm("<?php echo Yii::t('app','Are you sure you want to submit this payment? This cannot be undone.'); ?>")){
               $('.waiting').hide();
               $('#receiving-payment-form').submit();
           } else { //Bring back submit and unmask if fail to confirm
               $("#save_payment_button").show();
           }
    });
    
    $('#payment_cart').on('keypress','.payment-amount-txt',function(e) {
        if (e.keyCode === 13 || e.which === 13)
        {
           e.preventDefault();
           $("#save_payment_button").hide();
           if (confirm("<?php echo Yii::t('app','Are you sure you want to submit this payment? This cannot be undone.'); ?>")){
               $('#receiving-payment-form').submit();
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

function scannedSuccess(responseText, statusText, xhr, $form)
{
    $('.waiting').hide();
    setTimeout(function(){$('#SalePayment_payment_amount').focus();}, 10);
} 

</script>   