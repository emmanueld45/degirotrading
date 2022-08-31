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





if (isset($_POST['submit'])) {

    $id = uniqid();
    $filename = $_FILES["image1"]["name"];
    $tempname = $_FILES["image1"]["tmp_name"];
    $folder = "../verification-images/" . $id . $filename;
    $image1 = $id . $filename;
    move_uploaded_file($tempname, $folder);


    $id = uniqid();
    $filename2 = $_FILES["image2"]["name"];
    $tempname2 = $_FILES["image2"]["tmp_name"];
    $folder2 = "../verification-images/" . $id . $filename2;
    $image2 = $id . $filename2;
    move_uploaded_file($tempname2, $folder2);

    $user->sendVerificationRequest($session_id, $image1, $image2);
    $user->setDetail($session_id, "verification_status", "Pending");

    $admin->goTo("kyc", "uploaded");
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
                                    <h6 class="m-0 font-weight-bold text-primary">KYC Verification</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php

                                    if ($user->getDetail($session_id, "verification_status") == "Not Verified") {
                                    ?>
                                        <form action="" method="POST" enctype="multipart/form-data">

                                            <label for="">Identification Documents (National ID, International Passport etc..)</label>
                                            <input name="image1" type="file" class="form-control mb-4" required>

                                            <label for="">Proof of address (Bank statement, Any ID with your address on it)</label>
                                            <input name="image2" type="file" class="form-control" required>

                                            <br />
                                            <button name="submit" class="btn btn-primary mb-3" style="width:100%;">Submit documents</button>
                                        </form>
                                    <?php } ?>
                                    <?php

                                    if ($user->getDetail($session_id, "verification_status") == "Pending") {
                                        echo "<div class='alert alert-warning'>Your documents have been submitted and is being checked!</div>";
                                    }
                                    ?>

                                    <?php

                                    if ($user->getDetail($session_id, "verification_status") == "Verified") {
                                        echo "<div class='alert alert-success'>Your account has been verified!</div>";
                                    }
                                    ?>
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