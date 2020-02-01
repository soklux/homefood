<?php Yii::app()->clientScript->registerScript('setFocus',  '$("#Item_item_number").focus();'); ?>

<script>
    $("form").submit(function () {
        if($(this).data("allreadyInput")){
            return false;
        }else{
            $("input[type=submit]", this).hide();
            $(this).data("allreadyInput", true);
            // regular checks and submit the form here
        }
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#Item_image").on("change", function()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    $("#imagePreview").css("background-image", "url("+this.result+")");
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2000);
    });
</script>