<script type="text/javascript">
  function showDialog(val){
    if(val=='addnew'){
      $('#<?=$modal?>').modal('show');
      $('#<?=$modal?>').on('shown.bs.modal', function () {
          $('#<?=$name?>').focus();
          //$('#<?=$list?>').val('');
          $('.errorMsg').html('');
      })
      $('#<?=$modal?>').on('hidden.bs.modal', function () {$('#<?=$name?>').focus();
        if($('#<?=$list?>').val()=='addnew'){
          $('#<?=$list?>').val('');
        }
      })
    }
  }

  $(document).ready(function(e){
    var btn='<?=$btnSave?>';
    if(btn=='btn-supplier'){
      $('#btn-supplier').click(function(v){
        var name=$('#<?=$name?>').val();
        var first_name=$('#<?=@$first_name?>').val();
        var last_name=$('#<?=@$last_name?>').val();
        var url="<?=$url?>"
        var save=ajaxSave(url,{name,first_name,last_name},name,$('#<?=$modal?>'),$('#<?=$list?>'),$('#<?=$name?>'));
        if(save){
          $('#<?=@$first_name?>').val('');
          $('#<?=@$last_name?>').val('');  
        }
        
      })
    } else{
      $('#<?=$btnSave?>').click(function(v){
        var name=$('#<?=$name?>').val();
        var url="<?=$url?>"
        ajaxSave(url,{name},name,$('#<?=$modal?>'),$('#<?=$list?>'),$('#<?=$name?>'))
      })
    }
    
    $('#<?=$list?>').change(function(e){
      
      if($(this).val()=='addnew'){
        $('#<?=$modal?>').modal('show');
        $('#<?=$modal?>').on('shown.bs.modal', function () {
            $('#<?=$name?>').focus();
            $(this).val('');
            $('.errorMsg').html('');
        })
      }
    })
  })

  function ajaxSave(url,data,field,modal,dblist,textbox){
    //console.log(url+'-'+data+' '+' '+field+' '+modal+' '+dblist+' '+textbox)
    if(field==''){
      $('.errorMsg').html('<span style="color:red;">This field is required</span>');
    }else{
      $.ajax({
      type:'post',
      data:data,
      url:url,
      beforeSend:function(){
        $('.errorMsg').html('<span style="color:green;">Processing...</span>')
      },
      success:function(data){

        if(data=='error'){
          
          $('#success').html('');

        }else if(data=='null_first_name'){

          $('.error_last_name').html('');

          $('.error_first_name').html('<span style="color:red;">First Name is required.</span>');

          $('.errorMsg').html('')

        }else if(data=='null_last_name'){

           $('.error_first_name').html('');

          $('.error_last_name').html('<span style="color:red;">Last Name is required.</span>');

          $('.errorMsg').html('')

        }else if(data=='existed'){

          $('.error_first_name').html('');

          $('.error_last_name').html('');

          $('.errorMsg').html('<span style="color:red;">Name "'+field+'" has already been taken.</span>');

        }else if(data.indexOf('success')>=0){

          $('.errorMsg').html('');

          modal.modal('hide');
          $('.txt-box').val('');
          textbox.val('');

          $('body').removeClass('modal-open');

          dblist.html(data);

        }
        
      }
    })
  }
    
}
</script>