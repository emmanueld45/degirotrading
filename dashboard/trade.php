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


if (isset($_POST['buy'])) {
    $amount = mysqli_real_escape_string($db->conn, $_POST['amount']);
    $asset = mysqli_real_escape_string($db->conn, $_POST['asset']);

    if ($amount <= $user->getDetail($session_id, "available_balance")) {
        $result = $user->createTrade($session_id, $asset, $amount, "BUY");
        $user->updateDetail($session_id, "available_balance", $amount, "-");
        $admin->goTo("trade", "trade_placed");
    } else {
        $admin->goTo("trade", "insufficient_fund");
    }
}


if (isset($_POST['sell'])) {
    $amount = mysqli_real_escape_string($db->conn, $_POST['amount']);
    $asset = mysqli_real_escape_string($db->conn, $_POST['asset']);

    if ($amount <= $user->getDetail($session_id, "available_balance")) {
        $result = $user->createTrade($session_id, $asset, $amount, "SELL");
        $user->updateDetail($session_id, "available_balance", $amount, "-");
        $admin->goTo("trade", "trade_placed");
    } else {
        $admin->goTo("trade", "insufficient_fund");
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


                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Market</h6>
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
                                            "theme": "light",
                                            "style": "1",
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
                                    <h6 class="m-0 font-weight-bold text-primary">Place Trade</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php

                                    if (isset($_GET['insufficient_fund'])) {
                                        echo "<script>
                                        alert('You do not have enough fund to place this trade! Kindly deposit and try again!')
                                        </script>";
                                        echo "<div class='alert alert-warning'>You don't have enough fund to place this trade! Kindly deposit and try again!</div>";
                                    }

                                    if (isset($_GET['trade_placed'])) {
                                        echo "<div class='alert alert-success'>Trade placed successfully!</div>";
                                    }
                                    ?>

                                    <form action="" method="POST">
                                        <input type="number" name="amount" min="10" max="20000" class="form-control mb-3" placeholder="Enter Amount" required>
                                        <select name="asset" id="" class="form-control" required>
                                            <option value="">[Select Asset]</option>
                                            <option>EUR/USD</option>
                                            <option>GBP/JPY</option>
                                            <option>GBP/USD</option>
                                            <option>AUD/USD</option>
                                            <option>USD/CAD</option>
                                            <option>USD/JPY</option>
                                            <option>GOLD</option>
                                            <option>EUR/GBP</option>
                                            <option>EUR/JPY</option>
                                            <option>USD/NZD</option>
                                        </select>
                                        <div class="p-3">
                                            <button class="btn btn-danger" name="sell" style="padding:5px 30px;">SELL</button>
                                            <button class="btn btn-success" name="buy" style="padding:5px 30px;">BUY</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>






                    <div class="row">


                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Trade History</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Amount</th>
                                                    <th>Asset</th>

                                                    <th>Type</th>
                                                    <th>Profit</th>
                                                    <th>Date</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $result = $db->setQuery("SELECT * FROM trades WHERE user_id='$session_id';");
                                                $numrows = mysqli_num_rows($result);
                                                $sn = 1;
                                                if ($numrows != 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $sn; ?></td>
                                                            <td>$<?php echo number_format($row['amount']); ?></td>
                                                            <td><?php echo $row['asset'] ?></td>

                                                            <td><?php echo $row['trade_type'] ?></td>
                                                            <td>$<?php echo number_format($row['profit']); ?></td>
                                                            <td><?php echo $row['time_created'] ?></td>

                                                        </tr>
                                                <?php
                                                        $sn++;
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
                $(document).ready(function() {



                })
            </script>

</body>

</html>