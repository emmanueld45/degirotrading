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
    $amount = mysqli_real_escape_string($db->conn, $_POST['amount']);
    $payment_method = mysqli_real_escape_string($db->conn, $_POST['payment_method']);
    $payment_details = mysqli_real_escape_string($db->conn, $_POST['payment_details']);
    $withdrawal_code = mysqli_real_escape_string($db->conn, $_POST['withdrawal_code']);


    if ($amount <= $user->getDetail($session_id, "available_balance")) {
        if ($withdrawal_code == $user->getDetail($session_id, "withdrawal_code")) {
            $result = $user->sendWithdrawalRequest($session_id, $amount, $payment_method, $payment_details);
            if ($result) {
                $user->updateDetail($session_id, "available_balance", $amount, "-");
                $user->updateDetail($session_id, "pending_withdrawal", $amount, "+");
                $admin->goTo("withdraw", "success");
            } else {
                $admin->goTo("withdraw", "error");
            }
        } else {
            $admin->goTo("withdraw", "withdrawal_code_invalid");
        }
    } else {
        $admin->goTo("withdraw", "insufficient_fund");
    }
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




                    <div class="row">


                        <div class="col-xl-4 col-lg-4">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Account details</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                    <div class="row">

                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-12 col-md-12">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Available Balance</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($user->getDetail($session_id, "available_balance")); ?></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-12 col-md-12">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Total Withdrawals</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($user->getDetail($session_id, "total_withdrawal")); ?></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-12 col-md-12">
                                            <div class="card border-left-info shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                                Total Deposit</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($user->getDetail($session_id, "total_deposit")); ?></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-12 col-md-12">
                                            <div class="card border-left-info shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                                Pending Withdrawal</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($user->getDetail($session_id, "pending_withdrawal")); ?></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-xl-8 col-lg-8">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Withdraw Funds</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php

                                    if (isset($_GET['insufficient_fund'])) {
                                        echo "<div class='alert alert-warning'>insufficient fund!</div>";
                                    }


                                    if (isset($_GET['withdrawal_code_invalid'])) {
                                        echo "<div class='alert alert-warning'>Withdrawal code invalid!</div>";
                                    }

                                    if (isset($_GET['success'])) {
                                        echo "<div class='alert alert-success'>Withdrawal request successfully sent! you will be contacted shortly</div>";
                                    }

                                    if (isset($_GET['error'])) {
                                        echo "<div class='alert alert-danger'>An error occured! try again</div>";
                                    }
                                    ?>
                                    <form action="" method="POST">
                                        <label for="">Amount</label>
                                        <input type="number" name="amount" class="form-control mb-3" placeholder="Enter Amount" required>

                                        <label for="">Select Method</label>
                                        <select name="payment_method" id="" class="form-control mb-3" required>
                                            <option value="">[Select method]</option>
                                            <option value="BTC">Bitcoin</option>
                                            <option value="ETH">Ethereum</option>
                                            <option value="USDT">USDT</option>

                                        </select>

                                        <label for="">Withdrawal Code</label>
                                        <input type="text" name="withdrawal_code" class="form-control mb-3" placeholder="Withdrawal Code">


                                        <label for="">Wallet Address</label>
                                        <input type="text" name="payment_details" class="form-control mb-3" placeholder="Wallet Address">


                                        <br />
                                        <button class="btn btn-primary mb-3" name="submit" style="width:100%;">Request Withdrawal</button>
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