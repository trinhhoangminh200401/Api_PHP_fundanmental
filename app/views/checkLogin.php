<?php
require_once '../../app/lib/session.php'; 

echo (Session::checkLogin()) ? "true" : "false";
?>