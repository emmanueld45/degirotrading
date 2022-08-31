<?php
session_start();

include '../classes/database.class.php';
include '../classes/admin.class.php';
include '../classes/investments.class.php';
include '../classes/users.class.php';
include '../classes/emails.class.php';

if (!isset($_SESSION['admin_id'])) {
    $admin->goTo("login", "invalid_user");
}

$admin_id = $_SESSION['admin_id'];


if (isset($_GET['update_status'])) {
    $deposit_id = $_GET['deposit_id'];
    $status = $_GET['status'];
    $user_id = $_GET['user_id'];
    $amount = $_GET['amount'];

    $result = $db->setQuery("UPDATE deposits SET status='$status' WHERE deposit_id='$deposit_id';");
    if ($status == "Approved") {
        $email_class->sendDepositApprovedEmail($user_id, $amount);
    } else if ($status == "Rejected") {
        $email_class->sendDepositDeclinedEmail($user_id, $amount);
    }
    $admin->goTo("deposits", "updated");
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
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="../assets/css/admin.css" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">
    <?php include 'header.php'; ?>
    <div id="layoutSidenav">
        <?php include 'sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    <br />

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> DEPOSITS
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($_GET['updated'])) {
                                echo "<div class='alert alert-success'>Status updated!</div>";
                            }


                            ?>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Username</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <th>Time Created</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Username</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Wallet</th>
                                        <th>Status</th>
                                        <th>Time Created</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $result = $db->setQuery("SELECT * FROM deposits;");
                                    $numrows = mysqli_num_rows($result);
                                    $sn = 1;

                                    if ($numrows != 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $sn; ?></td>
                                                <td>
                                                    <?php echo $user->getDetail($row['user_id'], "username"); ?>
                                                </td>
                                                <td>$<?php echo number_format($row['usd_amount']); ?></td>
                                                <td><?php echo $row['coin_type']; ?></td>
                                                <td><?php echo $row['wallet_address']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['time_created']; ?></td>
                                                <td>
                                                    <form action="" method="GET">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="Pending">Set Pending</option>
                                                            <option value="Approved">Set Approved</option>
                                                            <option value="Rejected">Set Rejected</option>
                                                        </select>
                                                        <input type="hidden" name="amount" value="<?php echo $row['usd_amount']; ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                        <input type="hidden" name="deposit_id" value="<?php echo $row['deposit_id']; ?>">
                                                        <button class="btn btn-success" name="update_status">Update</button>
                                                    </form>
                                                    <!-- <a href="deposits?approve_deposit&deposit_id=<?php echo $row['deposit_id']; ?>" class="btn btn-primary">Approve</a>
                                                    <a href="deposits?reject_deposit&deposit_id=<?php echo $row['deposit_id']; ?>" class="btn btn-danger">Reject</a> -->
                                                </td>

                                            </tr>
                                    <?php
                                            $sn++;
                                        }
                                    } else {
                                        echo "<tr><td style='border:none;'><i>No data!</i></td></tr/>";
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
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