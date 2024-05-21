<?php
require_once(__DIR__ . "/./../layouts/header.php");
Session::init();

if ($_SESSION["level"] != "2") {

    echo "<script>window.location.href='/app/pages/404.php'</script>";
    exit();
}
?>
<div class="calendar my-5" id="calendar"></div>
<?php
require_once(__DIR__ . "/./../layouts/footer.php");
?>