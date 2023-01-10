<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?= "http://" . $_SERVER['HTTP_HOST'] ?>/resources/js/pos.js"></script>
<script>
    <?php if (isset($_SESSION['alert_create'])) : ?>
        swal({
            title: "<?= $_SESSION['alert_create'] ?>",
            icon: "success",
            timer: 1500,
            button: "OK",
        });
    <?php endif;
    unset($_SESSION['alert_create']);
    ?>

    <?php if (isset($_SESSION['alert_update'])) : ?>
        swal({
            title: "<?= $_SESSION['alert_update'] ?>",
            icon: "success",
            timer: 1500,
            button: "OK",
        });
    <?php endif;
    unset($_SESSION['alert_update']);
    ?>

    <?php if (isset($_SESSION['alert_delete'])) : ?>
        swal({
            title: "<?= $_SESSION['alert_delete'] ?>",
            icon: "success",
            timer: 1500,
            button: "OK",
        });
    <?php endif;
    unset($_SESSION['alert_delete']);
    ?>
</script>

</body>

</html>