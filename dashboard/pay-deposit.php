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

if (!isset($_GET['deposit_id'])) {
    $admin->goTo("transactions", "invalid_deposit");
}

if (!$user->depositExists($_GET['deposit_id'])) {
    $admin->goTo("transactions", "invalid_deposit");
}

$deposit_id = $_GET['deposit_id'];

$result = $db->setQuery("SELECT * FROM deposits WHERE deposit_id='$deposit_id';");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>degirotrading - Deposit</title>

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



                    <form>
                        <div class="row">

                            <!-- Area Chart -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Pending Deposit</h6>

                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            You are to transfer <b>$<?php echo number_format($row['usd_amount']) ?></b> BTC to your personal wallet address on degirotrading.
                                            Your account will be funded once deposit is confirmed.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Copy Wallet Address</h6>

                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">

                                        <div style="width:100%;display:flex;justify-content:center;margin-bottom:10px;">
                                            <div id="qrcode"></div>
                                        </div>
                                        <div class="coin-address-text" style="width:100%;text-align:center;margin-bottom:10px;color:#106eea;font-size:14px;font-weight:bold;">
                                            <?php echo $row['wallet_address']; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>








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
            <script src="../assets/js/jquery.min.js"></script>
            <script src="../assets/js/qrcode.min.js"></script>

</body>
<script>
    var wallet_address = "<?php echo $row['wallet_address']; ?>"
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: wallet_address,
        width: 150,
        height: 150,
        colorDark: "#12326b", //"#000000",
        colorLight: "#ffffff",
        padding: 1,
        correctLevel: QRCode.CorrectLevel.H
    });
</script>

</html>