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

if (isset($_POST['update_password'])) {
    $old_password = mysqli_real_escape_string($db->conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($db->conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($db->conn, $_POST['confirm_password']);

    if ($old_password == $user->getDetail($session_id, "password")) {
        if ($new_password == $confirm_password) {
            $user->setDetail($session_id, "password", $new_password);
            $admin->goTo("profile", "password_changed");
        } else {
            $admin->goTo("profile", "passwords_dont_match");
        }
    } else {
        $admin->goTo("profile", "old_password_incorrect");
    }
}






if (isset($_POST['update_profile'])) {
    $phone = mysqli_real_escape_string($db->conn, $_POST['phone']);
    $email = mysqli_real_escape_string($db->conn, $_POST['email']);
    $withdrawal_code = mysqli_real_escape_string($db->conn, $_POST['withdrawal_code']);
    // $wallet_address = mysqli_real_escape_string($db->conn, $_POST['wallet_address']);

    $user->setDetail($session_id, "phone", $phone);
    $user->setDetail($session_id, "email", $email);
    $user->setDetail($session_id, "withdrawal_code", $withdrawal_code);
    // $user->setDetail($session_id, "wallet_address", $wallet_address);

    $admin->goTo("profile", "profile_updated");
}

if (isset($_POST['update_photo'])) {

    $id = uniqid();
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "../profile-images/" . $id . $filename;
    $image = $id . $filename;
    $uploaded = move_uploaded_file($tempname, $folder);

    $user->setDetail($session_id, "image", $image);

    $admin->goTo("profile", "photo_updated");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>degirotrading - Profile</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/css/dashboard.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'header.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">




                    <div class="row">


                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Account details</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <?php
                                        if (isset($_GET['old_password_incorrect'])) {
                                            echo "<div class='alert alert-warning'>Old password is incorrect!</div>";
                                        }

                                        if (isset($_GET['passwords_dont_match'])) {
                                            echo "<div class='alert alert-warning'>Passwords do not match!</div>";
                                        }

                                        if (isset($_GET['password_changed'])) {
                                            echo "<div class='alert alert-success'>Password changed!</div>";
                                        }
                                        ?>
                                        <p style="color:#4e73df;"><b>Name:</b> <?php echo $user->getDetail($session_id, "firstname") . " " . $user->getDetail($session_id, "lastname"); ?></p>
                                        <!-- <p style="color:#4e73df;"><b>Wallet: <?php echo $user->getDetail($session_id, "wallet_address") ?></b> </p> -->
                                        <p style="color:#4e73df;"><b>Email:</b> <?php echo $user->getDetail($session_id, "email") ?></p>
                                        <p style="color:#4e73df;"><b>Status:</b> <?php echo $user->getDetail($session_id, "verification_status") ?></p>

                                        <input type="password" name="old_password" class="form-control mb-3" placeholder="Old Password" required>
                                        <input type="password" name="new_password" class="form-control mb-3" placeholder="New Password" required>
                                        <input type="password" name="confirm_password" class="form-control mb-3" placeholder="Confirm Password" required>

                                        <button class="btn btn-primary mb-3" style="width:100%;" name="update_password">Update Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Profile Photo</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php

                                    if (isset($_GET['photo_updated'])) {
                                        echo "<div class='alert alert-success'>Photo updated!</div>";
                                    }
                                    ?>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div style="width:100%;position:relative;display:flex;justify-content:center;margin-bottom:30px;">
                                            <img src="../profile-images/<?php echo $user->getDetail($session_id, "image"); ?>" style="width:150px;height:150px;" alt="">
                                        </div>
                                        <input name="image" type="file" class="form-control" required>

                                        <br />
                                        <button name="update_photo" class="btn btn-primary mb-3" style="width:100%;">Update Photo</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php

                                    if (isset($_GET['profile_updated'])) {
                                        echo "<div class='alert alert-success'>Profile updated!</div>";
                                    }
                                    ?>
                                    <form action="" method="POST">
                                        <label for="">Phone Number</label>
                                        <input type="text" name="phone" value="<?php echo $user->getDetail($session_id, "phone"); ?>" class="form-control mb-3" placeholder="Phone" required>

                                        <label for="">Email</label>
                                        <input type="email" name="email" value="<?php echo $user->getDetail($session_id, "email"); ?>" class="form-control mb-3" placeholder="Email" required>

                                        <label for="">Withdrawal Code</label>
                                        <input type="text" name="withdrawal_code" value="<?php if ($user->getDetail($session_id, "withdrawal_code") != "empty") {
                                                                                                echo $user->getDetail($session_id, "withdrawal_code");
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>" class="form-control mb-3" placeholder="Enter Withdrawal Code" required>

                                        <!-- <label for="">Country</label>
                                        <input type="password" name="country" class="form-control mb-3" placeholder="Address"> -->

                                        <!-- <label for="">Wallet Address</label>
                                        <input type="text" name="wallet_address" value="<?php echo $user->getDetail($session_id, "wallet_address"); ?>" class="form-control mb-3" placeholder="Wallet" required> -->

                                        <br />
                                        <button class="btn btn-primary mb-3" name="update_profile" style="width:100%;">Update Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>








                    <!-- Content Row -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include 'footer.php'; ?>
            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>