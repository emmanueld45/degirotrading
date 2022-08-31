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


if (isset($_POST['activate_promo'])) {

    $amount = mysqli_real_escape_string($db->conn, $_POST['amount']);

    if ($amount <= $user->getDetail($session_id, "available_balance")) {
        $investment->createInvestment($session_id, "Promo", $amount);
        $user->updateDetail($session_id, "available_balance", $amount, "-");
        $admin->goTo("./", "promo_activated");
    } else {
        $admin->goTo("./", "insufficient_fund");
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

    <title>degirotrading - Dashboard</title>

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

                    <!-- Page Heading -->
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div> -->
                    <div class="alert alert-success" style="font-size:14px;text-align:center;">
                        <h5>Referral Link</h5>
                        <p>https://degirotrading.com/signup?r=<?php echo $user->getDetail($session_id, "referral_code"); ?></p>
                    </div>
                    <div class="alert alert-danger" style="color:#106eea;font-size:23px;text-align:center;font-weight:bold;"><a href="deposit">DEPOSIT FUND</a></div>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
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
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
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

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Deposit</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($user->getDetail($session_id, "pending_deposit")); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Market Overview</h6>
                                    <!-- <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div id="tradingview_df6a8"></div>
                                    <!-- TradingView Widget BEGIN -->
                                    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                                    <script type="text/javascript">
                                        new TradingView.widget({
                                            "width": '100%',
                                            "height": '430px',
                                            "symbol": "COINBASE:BTCUSD",
                                            "interval": "1",
                                            "timezone": "Etc/UTC",
                                            "theme": "dark",
                                            "style": "2",
                                            "locale": "en",
                                            "toolbar_bg": "#f1f3f6",
                                            "enable_publishing": false,
                                            "hide_legend": true,
                                            "allow_symbol_change": true,
                                            "save_image": false,
                                            "container_id": "tradingview_df6a8"
                                        });
                                    </script>
                                    <!-- TradingView Widget END -->
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Promo Plan</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php

                                    if (isset($_GET['promo_activated'])) {
                                        echo "<div class='alert alert-success'>Promo plan activated successfully! view investment history <a href='investments'>here</a></div>";
                                    }
                                    ?>
                                    <p>Hey dear Big Investor! Wouldn't you like to come in our extremely Accurate
                                        AI driven trade strategy?

                                        we promise 86.70% yields if you enter at a minimum of $2000.00.
                                        THIS IS A TIME LIMITED OFFER!</p>

                                    <p>Time: <b>72 Hours</b></p>
                                    <p>Profit: <b>85%</b></p>
                                    <p>Min: <b>$2000</b></p>
                                    <p>Min: <b>$20000</b></p>
                                    <p>Current Balance: <b>$<?php echo number_format($user->getDetail($session_id, "available_balance")); ?></b></p>

                                    <form action="" method="POST">
                                        <input type="number" name="amount" min="2000" max="20000" class="form-control mb-2" placeholder="Enter Amount" required>
                                        <button class="btn btn-primary" name="activate_promo">Activate Promo</button>
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