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
    $plan = mysqli_real_escape_string($db->conn, $_POST['plan']);

    if ($amount <= $user->getDetail($session_id, "available_balance")) {
        if ($investment->amountAndPlanIsValid($amount, $plan)) {
            $result = $investment->createInvestment($session_id, $plan, $amount);
            if ($result) {
                $user->updateDetail($session_id, "available_balance", $amount, "-");
                $admin->goTo("investments", "success");
            } else {
                $admin->goTo("select-plan", "error");
            }
        } else {
            $admin->goTo("select-plan", "invalid_amount");
        }
    } else {
        $admin->goTo("select-plan", "insufficient_balance");
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

    <title>degirotrading - Select Plan</title>

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



                    <form action="" method="POST">
                        <div class="row">

                            <!-- Area Chart -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Select Plan</h6>

                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <?php
                                        if (isset($_GET['insufficient_balance'])) {
                                            echo "<div class='alert alert-warning'>Insufficient funds! kindly make a deposit <a href='deposit' ><b>here</b></a></div>";
                                        }

                                        if (isset($_GET['invalid_amount'])) {
                                            echo "<div class='alert alert-warning'>The amount entered is invalid for this plan!</div>";
                                        }

                                        if (isset($_GET['error'])) {
                                            echo "<div class='alert alert-danger'>An error occured! please try again</div>";
                                        }
                                        ?>
                                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount" required>
                                        <br />
                                        <label for="">Select Plan</label>
                                        <select name="plan" id="" class="form-control plan">
                                            <option value="A1026">A1026</option>
                                            <option value="A1066">A1066</option>
                                            <option value="A1066 Pro">A1066 Pro</option>
                                            <option value="A1166 Pro">A1166 Pro</option>

                                        </select>
                                        <br />
                                        <p>Current Balance: <b>$<?php echo number_format($user->getDetail($session_id, "available_balance")); ?></b></p>
                                        <p>In degirotrading - Your Trusted Crypto Investment Broker, You will receive profits everyday including weekends.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Plan Details</h6>

                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div>
                                            <ul>
                                                <li style="margin-bottom:20px;">Duration: <b><span class="duration">0</span></b></li>
                                                <li style="margin-bottom:20px;">Daily Profit: <b><span class="daily-profit">0</span></b></li>
                                                <li style="margin-bottom:20px;">Total Return: <b><span class="total-return">0</span></b></li>
                                                <li style="margin-bottom:20px;">Min: <b>$<span class="min">0</span></b></li>
                                                <li style="margin-bottom:20px;">Max: <b><span class="max">0<span class="time"></b></li>
                                                <li style="margin-bottom:20px;">Deposit Return: <b><span class="deposit-return">0</span></b></li>
                                                <li style="margin-bottom:20px;">Capital Return: <b><span class="capital-return">0</span></b></li>
                                            </ul>
                                            <button class="btn btn-primary mb-3" style="width:100%;" name="submit">Start Investment</button>
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

            <script>
                getPlanDetails("A1026");
                $(".plan").change(function() {
                    var plan = $(this).val();
                    getPlanDetails(plan);

                })


                function getPlanDetails(plan) {
                    $.ajax({
                        url: `ajax.php?action=getPlanDetails&plan=${plan}`,
                        async: true,
                        data: "",
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: 'POST',
                        type: 'POST',
                        success: function(resp) {
                            var resp = JSON.parse(resp)
                            // console.log("resp: " + resp.daily_profit)
                            $(".duration").html(resp.duration)
                            $(".daily-profit").html(resp.daily_profit)
                            $(".total-return").html(resp.total_return)
                            $(".deposit-return").html(resp.deposit_return)
                            $(".capital-return").html(resp.capital_return)
                            $(".min").html(resp.min)
                            if (resp.max == "Unlimited") {
                                $(".max").html(resp.max)
                            } else {
                                $(".max").html("$" + resp.max)
                            }
                        }
                    })
                }
            </script>

</body>

</html>