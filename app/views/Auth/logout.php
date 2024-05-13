<?php

include_once("../layouts/header.php");
Session::destroy();
header('Location:../../../../../app/views/Auth/login.php');
?>