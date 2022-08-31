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


if (isset($_GET['delete_user'])) {

    $user_id = $_GET['user_id'];

    $db->setQuery("DELETE FROM users WHERE user_id='$user_id';");
    $db->setQuery("DELETE FROM deposits WHERE user_id='$user_id';");
    $db->setQuery("DELETE FROM investments WHERE user_id='$user_id';");
    $db->setQuery("DELETE FROM withdrawals WHERE user_id='$user_id';");
    $db->setQuery("DELETE FROM referrals WHERE referrer_id='$user_id';");
    $db->setQuery("DELETE FROM referrals WHERE referred_id='$user_id';");

    $admin->goTo("./", "user_deleted");
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
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    Total Deposits <br />
                                    <span>$<?php echo number_format($admin->getTotalDeposits()); ?></span>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <!-- <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    Total Withdrawals <br />
                                    <span>$<?php echo number_format($admin->getTotalWithdrawals()); ?></span>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <!-- <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> USER MANAGEMENT
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($_GET['user_deleted'])) {
                                echo "<div class='alert alert-success'>User Deleted!</div>";
                            }


                            ?>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $result = $db->setQuery("SELECT * FROM users ORDER BY id DESC;");
                                    $numrows = mysqli_num_rows($result);
                                    if ($numrows != 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['user_id']; ?></td>
                                                <td>
                                                    <?php echo $row['firstname'] . " " . $row['lastname']; ?><br />
                                                    <span><b><?php echo $row['email']; ?></b></span>
                                                </td>
                                                <td>
                                                    <a href="manage-user?user_id=<?php echo $row['user_id']; ?>" class="btn btn-primary">Manage</a>
                                                    <a user_id="<?php echo $row['user_id']; ?>" class="btn btn-danger delete-user-btn">Delete</a>
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
            </main>
            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        $(document).ready(function() {


            $(".delete-user-btn").click(function() {

                var user_id = $(this).attr("user_id");
                if (confirm("You are about to delete this user.. Do you wish to continue?")) {
                    window.location.href = `./?delete_user&user_id=${user_id}`;
                }
            })
        })
    </script>
</body>

</html>