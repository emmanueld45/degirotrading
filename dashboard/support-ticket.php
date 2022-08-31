<!DOCTYPE html>
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
    $subject = mysqli_real_escape_string($db->conn, $_POST['subject']);
    $message = mysqli_real_escape_string($db->conn, $_POST['message']);

    $reference_id = $user->sendSupportTicket($session_id, $subject, $message);

    if ($reference_id) {
        $admin->goTo("support-ticket", "sent&r=$reference_id");
    } else {
        $admin->goTo("support-ticket", "error");
    }
}

?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>degirotrading - Support Ticket</title>

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

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Support Ticket</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php

                                    if (isset($_GET['sent'])) {

                                        echo "<div class='alert alert-success'>
                                       <p><b>Success!</b></p>
                                       <p>
                                       Your Ticket have been submitted. Your reference ID is <b>" . $_GET['r'] . "</b>.
                                        You will receive a response from our support team shortly
                                       </p>
                                        </div>";
                                    }



                                    if (isset($_GET['error'])) {
                                        echo "<div class='alert alert-danger'>An error occured! Try again.</div>";
                                    }

                                    ?>
                                    <form action="" method="POST">
                                        <label for="">Title</label>
                                        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                                        <br />
                                        <textarea name="message" class="form-control" style="height:200px;" required></textarea>
                                        <br />
                                        <button class="btn btn-primary mb-3" style="width:100%;" name="submit">Submit Ticket</button>
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