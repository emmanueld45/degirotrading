<?php
session_start();

include '../classes/database.class.php';
include '../classes/admin.class.php';
include '../classes/investments.class.php';
include '../classes/users.class.php';

if (!isset($_SESSION['admin_id'])) {
    $admin->goTo("login", "invalid_user");
}

if (!isset($_GET['user_id'])) {
    $admin->goTo("./", "invalid_user");
}

$admin_id = $_SESSION['admin_id'];

$user_id = $_GET['user_id'];




if (isset($_GET['edit_account'])) {
    $user->setDetail($user_id, "firstname", $_GET['firstname']);
    $user->setDetail($user_id, "lastname", $_GET['lastname']);
    $user->setDetail($user_id, "phone", $_GET['phone']);
    $user->setDetail($user_id, "email", $_GET['email']);
    $user->setDetail($user_id, "country", $_GET['country']);
    $user->setDetail($user_id, "username", $_GET['username']);
    $user->setDetail($user_id, "password", $_GET['password']);

    $admin->goTo("manage-user", "account_edited&user_id=$user_id");
}


if (isset($_GET['update_deposit_status'])) {
    $deposit_id = $_GET['deposit_id'];
    $status = $_GET['status'];

    $result = $db->setQuery("UPDATE deposits SET status='$status' WHERE deposit_id='$deposit_id';");
    $admin->goTo("manage-user", "deposit_updated&user_id=$user_id");
}

if (isset($_GET['send_notification'])) {
    $title = $_GET['title'];
    $message = $_GET['message'];

    $user->sendNotification($user_id, $title, $message);
    $admin->goTo("manage-user", "notification_sent&user_id=$user_id");
}

if (isset($_GET['update_balance'])) {

    $user->setDetail($user_id, "available_balance", $_GET['available_balance']);
    $user->setDetail($user_id, "total_deposit", $_GET['total_deposit']);
    $user->setDetail($user_id, "pending_deposit", $_GET['pending_deposit']);
    $user->setDetail($user_id, "total_bonus", $_GET['total_bonus']);
    $user->setDetail($user_id, "total_withdrawal", $_GET['total_withdrawal']);
    $user->setDetail($user_id, "pending_withdrawal", $_GET['pending_withdrawal']);

    $admin->goTo("manage-user", "balance_updated&user_id=$user_id");
}

if (isset($_GET['login_as_user'])) {

    $_SESSION['user_id'] = $user_id;
    $admin->goTo("../dashboard", "login_success");
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
                    <h1 class="mt-4">Manage User</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>


                    <br />
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i> <?php echo $user->getDetail($user_id, "firstname") . " " . $user->getDetail($user_id, "lastname") . "'s"; ?> Information
                                </div>
                                <div class="card-body">
                                    <div>
                                        <img src="../profile-images/<?php echo $user->getDetail($user_id, "image"); ?>" style="width:100px;height:100px;" alt="">
                                    </div>
                                    <br />
                                    Available Balance: <span>$<?php echo number_format($user->getDetail($user_id, "available_balance")); ?></span><br />
                                    Total Deposit: <span>$<?php echo number_format($user->getDetail($user_id, "total_deposit")); ?></span><br />
                                    <!-- Total Bonus: <span>$0</span><br /> -->
                                    Total Withdrawal: <span>$<?php echo number_format($user->getDetail($user_id, "total_withdrawal")); ?></span><br />
                                    Total Investment: <span>$<?php echo number_format($user->getTotalInvestmentAmount($user_id)); ?></span><br /><br />
                                    <a href="manage-user?login_as_user&user_id=<?php echo $user_id; ?>" class="btn btn-primary">Login Account</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Update Balance
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['balance_updated'])) {
                                        echo "<div class='alert alert-success'>Balance updated!</div>";
                                    }


                                    ?>
                                    <form action="" method="GET">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <label for="">Available Balance</label>
                                        <input type="number" name="available_balance" value="<?php echo $user->getDetail($user_id, "available_balance"); ?>" class="form-control mb-2" required>
                                        <label for="">Total Deposit</label>
                                        <input type="number" name="total_deposit" value="<?php echo $user->getDetail($user_id, "total_deposit"); ?>" class="form-control mb-2" required>
                                        <label for="">Pending Deposit</label>
                                        <input type="number" name="pending_deposit" value="<?php echo $user->getDetail($user_id, "pending_deposit"); ?>" class="form-control mb-2" required>

                                        <label for="">Total Bonus</label>
                                        <input type="number" name="total_bonus" value="<?php echo $user->getDetail($user_id, "total_bonus"); ?>" class="form-control mb-2" required>
                                        <label for="">Total Withdrawal</label>
                                        <input type="number" name="total_withdrawal" value="<?php echo $user->getDetail($user_id, "total_withdrawal"); ?>" class="form-control mb-2" required>

                                        <label for="">Pending Withdrawal</label>
                                        <input type="number" name="pending_withdrawal" value="<?php echo $user->getDetail($user_id, "pending_withdrawal"); ?>" class="form-control mb-2" required>


                                        <button class="btn btn-success" name="update_balance">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i> Profile
                                </div>
                                <div class="card-body">
                                    <b>Name:</b><br />
                                    <span><?php echo $user->getDetail($user_id, "firstname") . " " . $user->getDetail($user_id, "lastname"); ?></span>
                                    <hr />
                                    <!-- <b>Country:</b><br />
                                    <span>United States</span>
                                    <hr /> -->
                                    <b>Email:</b><br />
                                    <span><?php echo $user->getDetail($user_id, "email"); ?></span>
                                    <hr />
                                    <b>Phone:</b><br />
                                    <span><?php echo $user->getDetail($user_id, "phone"); ?></span>
                                    <hr />
                                    <b>Country:</b><br />
                                    <span><?php echo $user->getDetail($user_id, "country"); ?></span>
                                    <hr />
                                    <b>Registered on:</b><br />
                                    <span><?php echo $user->getDetail($user_id, "time_created"); ?></span>
                                    <hr />
                                    <b>Referred By:</b><br />
                                    <?php
                                    if ($user->wasReferred($user_id)) {
                                        $referrer_id = $user->getReferrerId($user_id);
                                        echo "<span>" . $user->getDetail($referrer_id, "firstname") . " " . $user->getDetail($referrer_id, "lastname") . "</span>";
                                    } else {
                                        echo "<span>Was Not Referred</span>";
                                    }
                                    ?>

                                    <hr />
                                    <b>Referral link:</b><br />
                                    <span>https://degirotrading.com/signup?r=<?php echo $user->getDetail($user_id, "referral_code"); ?></span><br />
                                    <a class="btn btn-info view-referrals-btn">VIEW REFERRALS</a>
                                    <ol style="display:none;" class="view-referrals-container">
                                        <?php
                                        $result = $db->setQuery("SELECT * FROM referrals WHERE referrer_id='$user_id';");
                                        $numrows = mysqli_num_rows($result);
                                        if ($numrows != 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<li>" . $user->getDetail($row['referred_id'], "firstname") . " " . $user->getDetail($row['referred_id'], "lastname") . "</li>";
                                            }
                                        } else {
                                            echo "No referrals";
                                        }
                                        ?>

                                    </ol>
                                    <hr />
                                    <b>Profile status:</b><br />
                                    <?php
                                    if ($user->getDetail($user_id, "verification_status") == "Verified") {
                                        echo "<span><button class='btn btn-success'>VERIFIED</button></span>";
                                    } else {
                                        echo "<span><button class='btn btn-danger'>NOT VERIFIED</button></span>";
                                    }
                                    ?>
                                    <hr />
                                    <b>Last Login information:</b><br />
                                    <span><?php echo $user->getDetail($user_id, "last_login"); ?></span>
                                    <hr />
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <!-- <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Give Bonus
                                </div>
                                <div class="card-body">

                                    <label for="">Amount</label>
                                    <input type="text" class="form-control mb-2">

                                    <label for="">Subject</label>
                                    <input type="text" class="form-control mb-2">

                                    <label for="">Amount</label>
                                    <textarea name="" id="" style="height:100px" class="form-control mb-2"></textarea>

                                    <button class="btn btn-success">Update</button>
                                </div>
                            </div> -->
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i> Edit Account
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['account_edited'])) {
                                        echo "<div class='alert alert-success'>Account edited!</div>";
                                    }


                                    ?>
                                    <form action="" method="GET">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <label for="">Firstname</label>
                                        <input type="text" name="firstname" value="<?php echo $user->getDetail($user_id, "firstname"); ?>" class="form-control mb-2" required>

                                        <label for="">Lastname</label>
                                        <input type="text" name="lastname" value="<?php echo $user->getDetail($user_id, "lastname"); ?>" class="form-control mb-2" required>

                                        <label for="">Username</label>
                                        <input type="text" name="username" value="<?php echo $user->getDetail($user_id, "username"); ?>" class="form-control mb-2" required>

                                        <!-- <label for="">Country</label>
                                        <input type="text" class="form-control mb-2" required> -->

                                        <label for="">Email</label>
                                        <input type="text" name="email" value="<?php echo $user->getDetail($user_id, "email"); ?>" class="form-control mb-2" required>


                                        <label for="">Phone</label>
                                        <input type="text" name="phone" value="<?php echo $user->getDetail($user_id, "phone"); ?>" class="form-control mb-2" required>

                                        <label for="">Country</label>
                                        <input type="text" name="country" value="<?php echo $user->getDetail($user_id, "country"); ?>" class="form-control mb-2" required>


                                        <label for="">Password</label>
                                        <input type="text" name="password" value="<?php echo $user->getDetail($user_id, "password"); ?>" class="form-control mb-2" required>


                                        <button class="btn btn-info" name="edit_account">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6" id="send_notification">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Send Notification
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['notification_sent'])) {
                                        echo "<div class='alert alert-success'>Notification sent!</div>";
                                    }


                                    ?>
                                    <form action="" method="GET">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <label for="">Title</label>
                                        <input type="text" name="title" class="form-control mb-2">

                                        <label for="">Message</label>
                                        <textarea name="message" id="" style="height:100px" class="form-control mb-2"></textarea>

                                        <button class="btn btn-success" name="send_notification">Send</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> DEPOSITS BY <?php echo $user->getDetail($user_id, "firstname"); ?>
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
                                        <th>User</th>

                                        <th>Method</th>
                                        <th>To</th>
                                        <th>From</th>
                                        <th>Transaction Slip</th>
                                        <th>Status</th>
                                        <th>Time Created</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>User</th>

                                        <th>Method</th>
                                        <th>To</th>
                                        <th>From</th>
                                        <th>Transaction Slip</th>
                                        <th>Status</th>
                                        <th>Time Created</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $result = $db->setQuery("SELECT * FROM deposits WHERE user_id='$user_id';");
                                    $numrows = mysqli_num_rows($result);
                                    $sn = 1;

                                    if ($numrows != 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $sn; ?></td>
                                                <td>
                                                    <b>Client:</b> <?php echo $user->getDetail($user_id, "firstname") . " " . $user->getDetail($user_id, "lastname"); ?><br />
                                                    <b>Email:</b> <?php echo $user->getDetail($user_id, "email"); ?><br />
                                                    <b>Date:</b> <?php echo $row['time_created']; ?><br />
                                                    <b>Amount:</b> $<?php echo number_format($row['usd_amount']); ?><br />
                                                </td>

                                                <td><?php echo $row['coin_type']; ?></td>
                                                <td><?php echo $row['wallet_address']; ?></td>
                                                <td><?php echo $row['from_wallet_address']; ?></td>
                                                <td><a href="<?php echo $row['transaction_slip']; ?>">View</a></td>

                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['time_created']; ?></td>
                                                <td>
                                                    <form action="" method="GET">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="Pending">Set Pending</option>
                                                            <option value="Approved">Set Approved</option>
                                                            <option value="Rejected">Set Rejected</option>
                                                        </select>
                                                        <input type="hidden" name="deposit_id" value="<?php echo $row['deposit_id']; ?>">
                                                        <button class="btn btn-success" name="update_deposit_status">Update</button>
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        var referrals_container_is_open = false;
        $(".view-referrals-btn").click(function() {

            if (referrals_container_is_open) {
                $(".view-referrals-container").slideUp();
                referrals_container_is_open = false;
            } else {
                $(".view-referrals-container").slideDown();
                referrals_container_is_open = true;
            }
        })
    </script>
</body>

</html>