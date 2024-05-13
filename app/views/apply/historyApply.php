<?php
include(__DIR__ . '../../layouts/header.php');

?>
<?php if (Session::checkLogin()) : ?>
<div>

</div>


<?php else : ?>
<?= '<script> alert("You have to login before seeing history") </script>'; ?>

<?= '<script> window.location.href="../Auth/login.php" </script>'; ?>

<?php endif ?>