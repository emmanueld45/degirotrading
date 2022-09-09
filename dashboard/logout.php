<?php
session_start();

include '../classes/admin.class.php';
$session_id = $_SESSION['user_id'];

session_destroy();
// setcookie("auto_login", $session_id, time() - 2592000);
$admin->goTo("../", "logged_out");
