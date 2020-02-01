<?php foreach (Yii::app()->user->getFlashes() as $key => $message) {
    if (isset($key)) { ?>
        <script>
            $(function(){
                $.gritter.add({
                    //title: '<?= ucfirst($key); ?>',
                    text: '<?= Yii::t('app',$message); ?>',
                    image: '<?= Yii::app()->theme->baseUrl ?>/avatars/avatar3.png',
                    sticky: false,
                    time: '',
                    class_name: '<?= 'gritter-' . 'light' ?>'
                });
                return false;
            });
        </script>
<?php   }
}