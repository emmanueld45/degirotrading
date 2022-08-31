<?php

class Admin
{

    public $admin_id = 1;

    public $website_name = "degirotrading";
    public $website_url = "https://degirotrading.com";
    public $website_url_e = "degirotrading.com";

    public $wallet_core_private = "";
    public $wallet_core_public = "";
    public $wallet_core_ipn = "";
    public $wallet_core_ipn_url = "";

    public function createAdmin($username, $password)
    {

        global $db;

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $result = $db->setQuery("INSERT INTO admin (username, password) VALUES ('$username', '$password');");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function getDetail($admin_id, $detail)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM admin WHERE id='$admin_id';");
        $row = mysqli_fetch_assoc($result);
        $detail = $row[$detail];

        return $detail;
    }


    public function setDetail($admin_id, $field, $detail)
    {
        global $db;

        $result = $db->setQuery("UPDATE admin SET $field='$detail' WHERE id='$admin_id';");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function updateDetail($admin_id, $detail, $value, $op)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM admin WHERE id='$admin_id';");
        $row = mysqli_fetch_assoc($result);
        $old_value = $row[$detail];

        if ($op == "+") {
            $new_value = $old_value + $value;
        } else if ($op == "-") {
            $new_value = $old_value - $value;
        }

        $result1 = $db->setQuery("UPDATE admin SET $detail='$new_value' WHERE id='$admin_id';");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    public function goTo($page, $parameter)
    {
        echo '<script>
          window.location.href="' . $page . '?' . $parameter . '";
         </script>';
    }


    public function createPasswordRecoveryKey($user_id)
    {
        global $db;

        $key_id = uniqid();

        $db->setQuery("INSERT INTO password_recovery_keys (user_id, key_id) VALUES ('$user_id', '$key_id')");

        return $key_id;
    }

    public function passwordRecoveryKeyIsValid($key_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM password_recovery_keys WHERE key_id='$key_id';");
        $numrows = mysqli_num_rows($result);

        if ($numrows != 0) {
            return true;
        } else {
            return false;
        }
    }



    public function calculateCoinPrice($coin, $usd_cost)
    {
        $url = "https://coinlib.io/api/v1/coin?key=e7f76466ade5d7bb&symbol=$coin";
        $stats = json_decode(file_get_contents($url), true);

        //$usdCost = 500;
        $coin_price = $stats['price'];

        $convertedCost = $usd_cost / $coin_price;

        return number_format($convertedCost, 8);
        // return $coin_price;
    }

    public function generateCoinAddress($coin)
    {


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/royaltradescenter/walletcore/create_new_address.php?coin=$coin");
        // curl_setopt($ch, CURLOPT_URL, "https://royaltradescenter.com/walletcore/create_new_address.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $generate_address = curl_exec($ch);
        curl_close($ch);
        $generate_address = (array) json_decode($generate_address);
        // print_r($generate_address);
        if ($generate_address['status'] == "200") {
            return $generate_address['address'];
        } else {
            return "failed";
        }
    }

    public function getRecaptchaCodes()
    {
        $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $rotations = [-43, 14, 3, 18, 7, -23, 5, 90, 2, 6];
        $code = [];
        for ($i = 0; $i < 6; $i++) {
            $rand = RAND(0, count($numbers) - 1);
            $code[count($code)] = array("number" => $numbers[$rand], "rotation" => $rotations[$rand]);
        }

        return $code;
        // $rand = RAND(0, count($numbers));
        // return $rand;
    }

    public function getCoinAddress($coin)
    {
        return $this->getDetail($this->admin_id, $coin . "_wallet");
    }


    public function validatePasswordResetKey($key_id, $email)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM password_reset_keys WHERE key_id='$key_id' AND email='$email';");
        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalDeposits()
    {
        global $db;

        $total = 0;
        $result = $db->setQuery("SELECT * FROM users;");
        $numrows = mysqli_num_rows($result);
        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $total += $row['total_deposit'];
            }
        }

        return $total;
    }

    public function getTotalWithdrawals()
    {
        global $db;

        $total = 0;
        $result = $db->setQuery("SELECT * FROM users;");
        $numrows = mysqli_num_rows($result);
        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $total += $row['total_withdrawal'];
            }
        }

        return $total;
    }
}


$admin = new Admin();
