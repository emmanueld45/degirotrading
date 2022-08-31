<?php
session_start();

include 'classes/database.class.php';
include 'classes/admin.class.php';
include 'classes/users.class.php';


if (!isset($_GET['key_id'])) {
    $admin->goTo("login", "invalid_key");
}

$key_id = $_GET['key_id'];

if (isset($_POST['reset_password'])) {
    $new_password = mysqli_real_escape_string($db->conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($db->conn, $_POST['confirm_password']);



    if ($user->passwordResetKeyIsValid($key_id)) {

        if ($new_password == $confirm_password) {
            $result = $db->setQuery("SELECT * FROM password_reset_keys WHERE key_id='$key_id';");
            $row = mysqli_fetch_assoc($result);
            $email = $row['email'];
            $db->setQuery("UPDATE users SET password='$new_password' WHERE email='$email';");
            $db->setQuery("UPDATE password_reset_keys SET status='used' WHERE key_id='$key_id';");
            $admin->goTo("login", "password_updated");
        } else {
            $admin->goTo("reset-password", "passwords_do_not_match&key_id=$key_id");
        }
    } else {
        $admin->goTo("login", "invalid_key");
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
    <title>Reset Password</title>
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

            <div class="page-name">Reset Password</div>
            <?php


            if (isset($_GET['passwords_do_not_match'])) {
                echo "<div class='alert alert-danger'>Passwords do not match!</div>";
            }
            ?>
            <form action="" method="POST">
                <input type="hidden" name="key_id" value="<?php echo $key_id ?>">
                <input type="password" placeholder="New Password" name="new_password" class="field">

                <input type="password" placeholder="Confirm Password" name="confirm_password" class="field">

                <div class="submit-btn-container">
                    <button class="submit-btn" name="reset_password">Reset Password</button>
                </div>
                <div class="info">Don't have an account? <a href="signup" class="info-link">Signup</a></div>
            </form>
        </div>
    </section>

</body>

</html>