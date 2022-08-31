<?php
session_start();

include '../classes/database.class.php';
include '../classes/admin.class.php';
include '../classes/investments.class.php';
include '../classes/users.class.php';

if (!isset($_SESSION['admin_id'])) {
    $admin->goTo("login", "invalid_user");
}

$admin_id = $_SESSION['admin_id'];


if (isset($_POST['update_details'])) {

    $admin->setDetail($admin->admin_id, "username", $_POST['username']);
    $admin->setDetail($admin->admin_id, "password", $_POST['password']);
    $admin->setDetail($admin->admin_id, "phone", $_POST['phone']);
    $admin->setDetail($admin->admin_id, "email", $_POST['email']);
    $admin->setDetail($admin->admin_id, "BTC_wallet", $_POST['BTC_wallet']);
    $admin->setDetail($admin->admin_id, "ETH_wallet", $_POST['ETH_wallet']);
    $admin->setDetail($admin->admin_id, "USDT_wallet", $_POST['USDT_wallet']);

    $admin->goTo("settings", "updated");
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include 'header.php'; ?>
    <div id="layoutSidenav">
        <?php include 'sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- <h1 class="mt-4">Support Ticket</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol> -->


                    <br />
                    <div class="row">

                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Account SETTINGS
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['updated'])) {
                                        echo "<div class='alert alert-success'>Status updated!</div>";
                                    }


                                    ?>
                                    <form action="" method="POST">
                                        <label for="">Username</label>
                                        <input type="text" name="username" value="<?php echo $admin->getDetail($admin->admin_id, "username"); ?>" class="form-control mb-2" required>

                                        <label for="">Password</label>
                                        <input type="password" name="password" value="<?php echo $admin->getDetail($admin->admin_id, "password"); ?>" class="form-control mb-2" required>

                                        <label for="">Phone</label>
                                        <input type="text" name="phone" value="<?php echo $admin->getDetail($admin->admin_id, "phone"); ?>" class="form-control mb-2" required>

                                        <label for="">Email</label>
                                        <input type="email" name="email" value="<?php echo $admin->getDetail($admin->admin_id, "email"); ?>" class="form-control mb-2" required>

                                        <label for="">Bitcoin</label>
                                        <input type="text" name="BTC_wallet" value="<?php echo $admin->getDetail($admin->admin_id, "BTC_wallet"); ?>" class="form-control mb-2" required>

                                        <label for="">Ethereum</label>
                                        <input type="text" name="ETH_wallet" value="<?php echo $admin->getDetail($admin->admin_id, "ETH_wallet"); ?>" class="form-control mb-2" required>

                                        <label for="">USDT</label>
                                        <input type="text" name="USDT_wallet" value="<?php echo $admin->getDetail($admin->admin_id, "USDT_wallet"); ?>" class="form-control mb-2" required>




                                        <button class="btn btn-success" name="update_details">UPDATE</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />








                </div>
            </main>
            <?php include 'footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>