<div class="form-group">
    <div class="col-xs-12">
        <?php if(isset($client_image) && !empty($client_image)):?>
            <label for="id-input-file-3" class="ace-file-input ace-file-multiple">
               <?=$form->fileField($model,'image',array('id'=>'id-input-file-3','style' => 'display:none;') )?>
                <div  id="item-image">
                <span class="ace-file-container">
                     
                    <?php foreach($client_image as $i=>$image):?>
                        <span class="ace-file-name" data-file="<?=$image['filename']?>">
                            <img class="middle" src='<?=Yii::app()->baseUrl.'/ximages/'. strtolower(get_class($model)) . '/' . $model->id.'/'.$image['filename']?>' height="50px">
                        </span>
                    <?php endforeach;?>

                </span>
                <a class="remove">
                    <i class=" ace-icon fa fa-times"></i>
                </a>
            </div>
            </label>
        <?php else:?>
            <?=$form->fileField($model,'image',array('id'=>'id-input-file-3') )?>
            <?php echo $form->error($model, 'image',array('style'=>'color:#D16E6C;')); ?>
        <?php endif;?>
    </div>
</div>

<style type="text/css">
    .ace-file-multiple .ace-file-container .ace-file-name:last-child{
        text-align: center;;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('a.remove').on('click',function(){
            alert('d');
        })
    })
    jQuery(function($){
        $('#id-input-file-3').ace_file_input({
                    style: 'well',
                    btn_choose: 'Drop files here or click to choose',
                    btn_change: null,
                    no_icon: 'ace-icon fa fa-cloud-upload',
                    droppable: true,
                    thumbnail: 'small'//large | fit
                    //,icon_remove:null//set null, to hide remove/reset button
                    ,before_change:function(files, dropped) {
                        //Check an example below
                        //or examples/file-upload.html
                        $('#item-image').html('');
                        return true;
                    }
                    /**,before_remove : function() {
                        return true;
                    }*/
                    ,
                    preview_error : function(filename, error_code) {
                        //name of the file that failed
                        //error_code values
                        //1 = 'FILE_LOAD_FAILED',
                        //2 = 'IMAGE_LOAD_FAILED',
                        //3 = 'THUMBNAIL_FAILED'
                        //alert(error_code);
                    }
            
                }).on('change', function(){
                    //console.log($(this).data('ace_input_files'));
                    //console.log($(this).data('ace_input_method'));
                });
    })
</script>