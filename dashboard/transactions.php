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


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>degirotrading - Withdraw</title>

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




                    <div class="mb-3">
                        <button class="btn btn-primary deposit-btn">Deposits</button>
                        <button class="btn btn-info withdrawal-btn">Withdrawals</button>
                    </div>
                    <div class="row">


                        <div class="col-xl-12 col-lg-12">

                            <!-- Deposit start -->
                            <div class="card shadow mb-4 deposit-container">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Deposit History</h6>

                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Status</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $result = $db->setQuery("SELECT * FROM deposits WHERE user_id='$session_id';");
                                                $numrows = mysqli_num_rows($result);
                                                if ($numrows != 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $row['deposit_type']; ?></td>
                                                            <td>$<?php echo number_format($row['usd_amount']); ?></td>
                                                            <td><?php echo $row['time_created']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row['status'] == "Pending") {
                                                                    echo "<a class='btn btn-warning'>PENDING</a>";
                                                                } else if ($row['status'] == "Approved") {
                                                                    echo "<a class='btn btn-success'>APPROVED</a>";
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td style='border:none;'><i>No data available</i></td></tr>";
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Deposit end -->


                            <!-- Withdrawal start -->
                            <div class="card shadow mb-4 withdrawal-container" style="display:none;">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Withdrawal History</h6>

                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Wallet Address</th>
                                                    <th>Date</th>
                                                    <th>Status</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $result = $db->setQuery("SELECT * FROM withdrawals WHERE user_id='$session_id';");
                                                $numrows = mysqli_num_rows($result);
                                                if ($numrows != 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                        <tr>
                                                            <td>Withdrawal</td>
                                                            <td>$<?php echo number_format($row['amount']); ?></td>
                                                            <td><?php echo $row['payment_method']; ?></td>
                                                            <td><?php echo $row['payment_details']; ?></td>
                                                            <td><?php echo $row['time_created']; ?></td>

                                                            <td>
                                                                <?php
                                                                if ($row['status'] == "Pending") {
                                                                    echo "<a class='btn btn-warning'>PENDING</a>";
                                                                } else if ($row['status'] == "Approved") {
                                                                    echo "<a class='btn btn-success'>APPROVED</a>";
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td style='border:none;'><i>No data available</i></td></tr>";
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Withdrawal end -->



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

            <script>
                $(".deposit-btn").click(function() {
                    $(".withdrawal-container").hide()
                    $(".deposit-container").show()
                })

                $(".withdrawal-btn").click(function() {
                    $(".deposit-container").hide()
                    $(".withdrawal-container").show()
                })
            </script>

</body>

</html>