<?php
session_start();

include '../classes/database.class.php';
include '../classes/admin.class.php';
include '../classes/investments.class.php';
include '../classes/users.class.php';

if (!isset($_SESSION['user_id'])) {
    $admin->goTo("../login", "invalid_user");
}

$session_id = $_SESSION['user_id'];

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == "getCoinAddress") {
        $coin = $_GET['coin'];
        $coin_address = $admin->getCoinAddress($coin);
        echo $coin_address;
    }

    if ($action == "getPlanDetails") {
        $plan = $_GET['plan'];
        $details = $investment->getPlanDisplayDetails($plan);
        echo json_encode($details);
    }
}
