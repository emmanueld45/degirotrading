<?php
session_start();

include '../classes/database.class.php';
include '../classes/admin.class.php';
include '../classes/investments.class.php';
include '../classes/users.class.php';
include '../classes/emails.class.php';

if (!isset($_SESSION['user_id'])) {
    $admin->goTo("../login", "invalid_user");
}

$session_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {

    $amount = mysqli_real_escape_string($db->conn, $_POST['amount']);
    $coin_type = mysqli_real_escape_string($db->conn, $_POST['coin_type']);
    $wallet_address = mysqli_real_escape_string($db->conn, $_POST['wallet_address']);

    // $transaction_slip = mysqli_real_escape_string($db->conn, $_POST['transaction_slip']);
    $from_wallet_address = mysqli_real_escape_string($db->conn, $_POST['from_wallet_address']);

    $id = uniqid();
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "../transaction-slips/" . $id . $filename;
    $transaction_slip = $id . $filename;
    $uploaded = move_uploaded_file($tempname, $folder);

    $deposit_id = uniqid();
    $result = $user->addDeposit($deposit_id, $session_id, "Deposit", $amount, $coin_type, $wallet_address, $transaction_slip, $from_wallet_address);
    $user->updateDetail($session_id, "pending_deposit", $amount, "+");
    $txn_ref = RAND(10000, 100000);
    $email_class->sendDepositEmail($session_id, $coin_type, $amount, $wallet_address, $txn_ref);
    $admin->goTo("pay-deposit", "deposit_id=$deposit_id");
    if ($result) {
    } else {
        $admin->goTo("deposit", "deposit_error");
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



                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">

                            <!-- Area Chart -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Deposit Funds</h6>

                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <input type="number" class="form-control" name="amount" placeholder="Enter Amount" required>
                                        <br />
                                        <label for="">Select Method</label>
                                        <select id="" name="coin_type" class="form-control coin-type">
                                            <option value="BTC">Bitcoin</option>
                                            <option value="ETH">Ethereum</option>
                                            <option value="USDT">USDT</option>
                                        </select>
                                        <br />
                                        <input type="hidden" class="wallet-address" name="wallet_address">

                                        <p>
                                            You are provided with a very convenient method of depositing using Bitcoin, Ethereum and USDT
                                        </p>
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
                                            dksjhdjshdshdkjsdhkjshdkjhkjshkjahsjhk
                                        </div>

                                        <label>Translip slip</label>
                                        <input type="file" class="form-control mb-3" name="image" required>

                                        <label>Sent from:</label>
                                        <input type="text" class="form-control mb-3" placeholder="Enter Wallet Address" name="from_wallet_address" required>

                                        <button class="btn btn-primary mb-3" style="width:100%;" name="submit">Request Deposit</button>

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
    getCoinAddress("BTC");
    $(".coin-type").change(function() {
        var coin = $(this).val();
        getCoinAddress(coin);

    })


    function getCoinAddress(coin) {
        $.ajax({
            url: `ajax.php?action=getCoinAddress&coin=${coin}`,
            async: true,
            data: "",
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                console.log("resp: " + resp)
                document.getElementById("qrcode").innerHTML = "";
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    text: resp,
                    width: 150,
                    height: 150,
                    colorDark: "#12326b", //"#000000",
                    colorLight: "#ffffff",
                    padding: 1,
                    correctLevel: QRCode.CorrectLevel.H
                });

                $(".coin-address-text").html(resp)
                $(".wallet-address").val(resp)
            }
        })
    }
</script>

</html>