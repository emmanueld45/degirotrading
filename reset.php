<!DOCTYPE html>
<?php

session_start();

include 'classes/database.class.php';
include 'classes/admin.class.php';
include 'classes/investments.class.php';
include 'classes/users.class.php';

// $user->sendSupportTicket("1234", "Withdrawal help", "How do i make withdrawals");
// $user->sendWithdrawalRequest("123", 1000, "BTC", "DHSKJDHKJSD");

// echo $user->getTotalInvestmentAmount("62c3bfdf011a5");
// $user->createTrade("1234", "EUR/USD", 10, "BUY");

// $user->formatWhatsappPhone("+1( 68283 )29+833");
setcookie("auto_login", "sdjhsdsbjd", time() - 2592000);
// if (isset($_COOKIE['auto_login'])) {
//     echo "yes";
// } else {
//     echo "no";
// }
// echo $_COOKIE['auto_login'];
