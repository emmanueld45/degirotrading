<?php
session_start();

include 'classes/database.class.php';
include 'classes/admin.class.php';
include 'classes/users.class.php';


if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db->conn, $_POST['username']);
    $password = mysqli_real_escape_string($db->conn, $_POST['password']);

    $result = $db->setQuery("SELECT * FROM users WHERE username='$username';");
    $numrows = mysqli_num_rows($result);

    if ($numrows != 0) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {
            $_SESSION['user_id'] = $row['user_id'];
            $last_login = date("M,d,Y h:i A");
            $user->setDetail($_SESSION['user_id'], "last_login", $last_login);

            $admin->goTo("dashboard", "loggin_success");
        } else {

            $admin->goTo("login", "invalid_password");
        }
    } else {

        $admin->goTo("login", "invalid_user");
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
    <title>Login</title>
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
            <div class="page-name">Login</div>
            <?php
            if (isset($_GET['invalid_user'])) {
                echo "<div class='alert alert-danger'>Username does not exists</div>";
            }

            if (isset($_GET['invalid_password'])) {
                echo "<div class='alert alert-danger'>Invalid password</div>";
            }

            if (isset($_GET['password_updated'])) {
                echo "<div class='alert alert-success'>Password updated! Kindly login below</div>";
            }
            ?>
            <form action="" method="POST">
                <input type="text" placeholder="Username" name="username" class="field">

                <input type="password" placeholder="Password" name="password" class="field">

                <div class="submit-btn-container">
                    <button class="submit-btn" name="login">Login</button>
                </div>
                <div class="info">Don't have an account? <a href="signup" class="info-link">Signup</a></div>
                <div class="info">Forgotten your password? <a href="forgot-password" class="info-link">Click here</a></div>
            </form>
        </div>
    </section>

</body>

</html>