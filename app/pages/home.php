<?php
include(dirname(__FILE__) . "./layouts/header.php");

?>

<?php
$checkUserExist =  Session::get('level');

?>
<?php if ($checkUserExist == '2') : ?>
<?php include_once(dirname(__FILE__) . '/homepage/adminpage.php') ?>

<?php else : ?>
<?php include_once(dirname(__FILE__) . '/homepage/userpage.php') ?>
<?php endif ?>
<?php
include(dirname(__FILE__). './layouts/footer.php');
?>