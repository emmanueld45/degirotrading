<?php
session_start();

include 'classes/database.class.php';
include 'classes/admin.class.php';
include 'classes/users.class.php';
include 'classes/emails.class.php';


if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($db->conn, $_POST['email']);

    $result = $db->setQuery("SELECT * FROM users WHERE email='$email';");
    $numrows = mysqli_num_rows($result);

    if ($numrows != 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        $key_id = uniqid();
        $db->setQuery("INSERT INTO password_reset_keys (key_id, email, status) VALUES ('$key_id', '$email', 'unused');");
        $email_class->sendRecoverPasswordEmail($user_id, $key_id);
        $admin->goTo("forgot-password", "email_sent&email=$email");
    } else {

        $admin->goTo("forgot-password", "invalid_email");
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
    <title>Forgot password</title>
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

            <?php
            if (!isset($_GET['email_sent'])) {
            ?>
                <div class="page-name">Forgot Password</div>
                <?php
                if (isset($_GET['invalid_email'])) {
                    echo "<div class='alert alert-danger'>Email address does not exist</div>";
                }


                ?>
                <form action="" method="POST">
                    <input type="email" placeholder="Email" name="email" class="field">

                    <div class="submit-btn-container">
                        <button class="submit-btn" name="login">Send Link</button>
                    </div>
                    <div class="info">Don't have an account? <a href="signup" class="info-link">Signup</a></div>
                </form>
            <?php
            } else {
                echo "<div class='alert alert-success'>An email has been sent to <b>" . $_GET['email'] . "</b> with a password reset link 
                <br/><br/>
                <a href='login'>Return to login</a>
                </div>";
            }
            ?>
        </div>
    </section>

</body>

</html>