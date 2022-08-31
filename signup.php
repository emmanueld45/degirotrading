<?php
session_start();
include 'classes/database.class.php';
include 'classes/admin.class.php';
include 'classes/users.class.php';
include 'classes/emails.class.php';


if (isset($_POST['signup'])) {

    $firstname = mysqli_real_escape_string($db->conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db->conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($db->conn, $_POST['username']);
    $email = mysqli_real_escape_string($db->conn, $_POST['email']);
    $phone = mysqli_real_escape_string($db->conn, $_POST['phone']);
    //$country = mysqli_real_escape_string($conn, $_POST['country']);
    // $wallet_address = mysqli_real_escape_string($db->conn, $_POST['wallet_address']);
    $password = mysqli_real_escape_string($db->conn, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($db->conn, $_POST['confirm_password']);


    $time = time();
    $date = date("M,d,Y h:i A");
    $status = "inactive";


    // check if email exists
    $result = $db->setQuery("SELECT * FROM users WHERE email='$email';");
    $numrows = mysqli_num_rows($result);

    $result2 = $db->setQuery("SELECT * FROM users WHERE username='$username';");
    $numrows2 = mysqli_num_rows($result2);

    // if username does not exit
    if ($numrows2 == 0) {
        // if email email does not already exist
        if ($numrows == 0) {


            // check if passwords are the same
            if ($password == $confirmpassword) {

                $user_id = uniqid();
                $result = $user->createUser($user_id, $username, $firstname, $lastname, $email, $phone, "empty", "empty", $password);
                if ($result) {
                    $_SESSION['user_id'] = $user_id;
                    if (isset($_POST['referrer_id'])) {
                        $user->addReferral($_POST['referrer_id'], $user_id);
                    }
                    $email_class->sendSignupEmail($_SESSION['user_id']);
                    $admin->goTo("dashboard", "signup_success");
                } else {
                    $admin->goTo("signup", "signup_failure");
                }
            } else {
                $admin->goTo("signup", "passwords_dont_match");
            }
        } else {
            $admin->goTo("signup", "email_exists");
        }
    } else {
        $admin->goTo("signup", "username_exists");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/root.css">
    <title>Signup</title>

    <!-- <script type="text/javascript">
        window.$crisp = [];
        window.CRISP_WEBSITE_ID = "ae1c8296-022d-49ac-add4-344ac80714a6";
        (function() {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script> -->
</head>

<body>



    <section class="auth-page">
        <div class="auth-container">
            <div class="logo-container"><span style="color:#009FE3;">Degiro</span>Trading <span style="color:#009FE3;"></span></div>
            <div class="page-name">Register</div>
            <?php
            if (isset($_GET['username_exists'])) {
                echo "<div class='alert alert-danger'>Username already in use</div>";
            }

            if (isset($_GET['email_exists'])) {
                echo "<div class='alert alert-danger'>Email already in use</div>";
            }

            if (isset($_GET['passwords_dont_match'])) {
                echo "<div class='alert alert-danger'>Passwords do not match</div>";
            }
            ?>

            <form action="" method="POST">
                <?php

                if (isset($_GET['r'])) {
                    if ($user->referralCodeIsValid($_GET['r'])) {
                        $referrer_id = $user->getReferralIdFromReferralCode($_GET['r']);
                        echo "<div class='alert alert-info'>You are being referred by " . $user->getDetail($referrer_id, "firstname") . " " . $user->getDetail($referrer_id, "lastname") . "</div>";
                        echo "<input type='hidden' name='referrer_id' value='$referrer_id'>";
                    } else {
                        echo "<div class='alert alert-danger'>Referral code is invalid!</div>";
                    }
                }
                ?>
                <input type="text" placeholder="Username" name="username" class="field" required>

                <input type="text" placeholder="Firstname" name="firstname" class="field" required>

                <input type="text" placeholder="Lastname" name="lastname" class="field" required>

                <!-- <input type="text" placeholder="Bitcoin wallet" name="wallet_address" class="field" required> -->

                <input type="text" placeholder="Email address" name="email" class="field" required>

                <input type="text" placeholder="Phone" name="phone" class="field" required>

                <input type="password" placeholder="Password" name="password" class="field" required>

                <input type="password" placeholder="Confirm password" name="confirm_password" class="field" required>




                <div class="submit-btn-container">
                    <button class="submit-btn" name="signup">Signup</button>
                </div>
                <div class="info">Already have an account? <a href="login" class="info-link">Login</a></div>
            </form>
        </div>
    </section>

</body>

</html>