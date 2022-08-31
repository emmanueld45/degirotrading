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


if (isset($_GET['update_status'])) {
    $investment_id = $_GET['investment_id'];
    $status = $_GET['status'];

    $result = $db->setQuery("UPDATE investments SET status='$status' WHERE investment_id='$investment_id';");
    $admin->goTo("investments", "updated");
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
                            <i class="fas fa-table me-1"></i> INVESTMENTS
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
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Amount</th>
                                        <th>Plan</th>
                                        <th>Status</th>
                                        <th>Time Created</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Amount</th>
                                        <th>Plan</th>
                                        <th>Status</th>
                                        <th>Time Created</th>
                                        <th>Action</th>

                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $result = $db->setQuery("SELECT * FROM investments;");
                                    $numrows = mysqli_num_rows($result);
                                    $sn = 1;

                                    if ($numrows == 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $sn; ?></td>
                                                <td>
                                                    <?php echo $user->getDetail($row['user_id'], "username"); ?>
                                                </td>
                                                <td><?php echo $row['investment_id']; ?></td>
                                                <td>$<?php echo number_format($row['amount']); ?></td>
                                                <td><?php echo $row['plan']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['time_created']; ?></td>
                                                <td>
                                                    <form action="" method="GET">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="Active">Set Active</option>
                                                            <option value="Ended">Set Ended</option>

                                                        </select>
                                                        <input type="hidden" name="investment_id" value="<?php echo $row['investment_id']; ?>">
                                                        <button class="btn btn-success" name="update_status">Update</button>
                                                    </form>

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