<script>
    $(window).bind("load", function() {
        setTimeout(window.location.href='index?tran_type=<?= getTransType() ?>',5000);
        window.print();
        return true;
    });
</script>