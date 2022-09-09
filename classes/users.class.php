<?php

class User
{
    public $user_id;




    public function createReferralCode()
    {
        $alph = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
        $nums = str_shuffle("12345678901234567890");
        if (strlen($alph) > 3) {
            $cutalph = substr($alph, 0, 3);

            $alph = $cutalph;
        }

        if (strlen($nums) > 3) {
            $cutnums = substr($nums, 0, 3);

            $nums = $cutnums;
        }

        $result = $alph . $nums;
        $final_result = str_shuffle($result);
        return  $final_result;
    }

    public function createUser($user_id, $username, $firstname, $lastname, $email, $phone, $country, $wallet_address, $password, $withdrawal_code)
    {
        global $db;
        $status = "Active";
        $time = time();
        $a = date("h");
        $b = $a - 1;
        $c = date("i A");
        $time_created = date("M,d,Y h:i A");
        $date = date("d-m-y");
        $referral_code = $this->createReferralCode();
        $available_balance = 0;
        $total_referral_bonus = 0;
        $total_deposit = 0;
        $total_bonus = 0;
        $total_withdrawal = 0;
        $total_referral_bonus = 0;
        $pending_deposit = 0;
        $pending_withdrawal = 0;
        // $withdrawal_code = "withdrawal_code";
        $verification_status = "Not Verified";
        $image = "default.svg";


        $result = $db->setQuery("INSERT INTO users (user_id, username, firstname, lastname, email, phone, country, password, image, wallet_address, status, available_balance, total_deposit, total_bonus, total_withdrawal, total_referral_bonus, pending_deposit, pending_withdrawal, withdrawal_code, referral_code, time, date, time_created, verification_status, last_login) VALUES ('$user_id', '$username', '$firstname', '$lastname', '$email', '$phone', '$country', '$password', '$image', '$wallet_address', '$status', '$available_balance', '$total_deposit', '$total_bonus', '$total_withdrawal', '$total_referral_bonus', '$pending_deposit', '$pending_withdrawal', '$withdrawal_code', '$referral_code', '$time', '$date', '$time_created', '$verification_status', '$time_created');");
        return $result;
    }


    public function getDetail($user_id, $detail)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM users WHERE user_id='$user_id';");
        $row = mysqli_fetch_assoc($result);
        $detail = $row[$detail];

        return $detail;
    }


    public function setDetail($user_id, $field, $detail)
    {
        global $db;

        $result = $db->setQuery("UPDATE users SET $field='$detail' WHERE user_id='$user_id';");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function updateDetail($userid, $detail, $value, $op)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM users WHERE user_id='$userid';");
        $row = mysqli_fetch_assoc($result);
        $old_value = $row[$detail];

        if ($op == "+") {
            $new_value = $old_value + $value;
        } else if ($op == "-") {
            $new_value = $old_value - $value;
        }

        $result1 = $db->setQuery("UPDATE users SET $detail='$new_value' WHERE user_id='$userid';");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function userIdExists($user_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM users WHERE user_id='$user_id';");
        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function userEmailExists($email)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM users WHERE email='$email';");
        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sendWithdrawalRequest($user_id, $amount, $payment_method, $payment_details)
    {
        global $db;
        $status = "Pending";
        $time = time();
        $date = date("d-m-y");
        $time_created = date("M,d,Y h:i A");

        $result = $db->setQuery("INSERT INTO withdrawals (user_id, amount, payment_method, payment_details, status, time, date, time_created) VALUES ('$user_id', '$amount', '$payment_method', '$payment_details', '$status','$time', '$date', '$time_created');");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function sendVerificationRequest($user_id, $image1, $image2)
    {
        global $db;
        $status = "Pending";
        $time = time();
        $time_created = date("d-m-y");

        $result = $db->setQuery("INSERT INTO verification_requests (user_id, image1, image2, status, time, time_created) VALUES ('$user_id', '$image1', '$image2', '$status', '$time', '$time_created');");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }





    public function referralCodeIsValid($referral_code)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM users WHERE referral_code='$referral_code';");
        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function hasReferredSomeone($user_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM referrals WHERE referrer_id='$user_id';");
        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function wasReferred($user_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM referrals WHERE referred_id='$user_id';");
        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getReferrerId($referred_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM referrals WHERE referred_id='$referred_id';");
        $row = mysqli_fetch_assoc($result);

        return $row['referrer_id'];
    }

    public function getReferredId($referrer_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM referrals WHERE referrer_id='$referrer_id';");
        $row = mysqli_fetch_assoc($result);

        return $row['referred_id'];
    }




    public function getReferralIdFromReferralCode($referral_code)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM users WHERE referral_code='$referral_code';");
        $row = mysqli_fetch_assoc($result);

        return $row['user_id'];
    }



    public function addReferral($referrer_id, $referred_id)
    {
        global $db;

        $result = $db->setQuery("INSERT INTO referrals (referrer_id, referred_id) VALUES ('$referrer_id', '$referred_id')");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalInvestmentPlans($user_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM investments WHERE user_id='$user_id';");
        $numrows = mysqli_num_rows($result);
        return $numrows;
    }

    public function getTotalInvestmentAmount($user_id)
    {
        global $db;

        $total = 0;
        $result = $db->setQuery("SELECT * FROM investments WHERE user_id='$user_id';");
        $numrows = mysqli_num_rows($result);
        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $total += $row['amount'];
            }
        }
        return $total;
    }

    public function isEligibleForDailyProfit($last_updated_time, $seconds_remaining)
    {
        $d = 60; //86400;
        $seconds = time() - $last_updated_time;
        if (($seconds + $seconds_remaining) >= $d) {
            $days = floor(($seconds + $seconds_remaining) / $d);
            $seconds_remaining = ($seconds + $seconds_remaining) - ($days * $d);
            return array("status" => "eligible", "days" => $days, "seconds_remaining" => $seconds_remaining);
        } else {
            return  array("status" => "not eligible");
        }
    }



    public function checkDailyInvestmentsStatus($user_id)
    {
        global $db;
        global $investment;

        $result = $db->setQuery("SELECT * FROM investments WHERE user_id='$user_id' AND status='Active';");
        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            $row = mysqli_fetch_assoc($result);
            $investment_id = $row['investment_id'];
            $plan = $row['plan'];
            $amount = $row['amount'];
            $time_remaining = $row['end_time'] - time();
            $is_eligible = $this->isEligibleForDailyProfit($row['last_updated_time'], $row['seconds_remaining']);
            // echo "Time remaining" . $time_remaining;
            if ($time_remaining > 0) {
                // There is still time available here

                if ($is_eligible['status'] == "eligible") {
                    $roi = $investment->getPlanROI($plan);
                    $profit = $amount * $roi * $is_eligible['days'];

                    $this->updateDetail($user_id, "total_profit", $profit, "+");
                    $this->updateDetail($user_id, "withdrawable_balance", $profit, "+");
                    $investment->updateDetail($investment_id, "roi", $profit, "+");
                    $investment->updateDetail($investment_id, "withdrawable_balance", $profit, "+");
                    $investment->setDetail($investment_id, "seconds_remaining", $is_eligible['seconds_remaining']);
                    $investment->setDetail($investment_id, "last_updated_time", time() + $is_eligible['seconds_remaining']);
                }
            } else {
                // Investment plan time is up
                $db->setQuery("UPDATE investments SET status='Ended' WHERE investment_id='$investment_id';");
                $roi = $investment->getPlanROI($plan);
                $profit = $amount * $roi;
                // Remove amount from user's current balance and add amount + profit to Earnings
                // No need to remove from current balance again cause we already removed when creating investment

                // if ($amount > $this->getDetail($user_id, "balance")) {
                //     $this->setDetail($user_id, "balance", 0);
                // } else {
                //     $this->updateDetail($user_id, "balance", $amount, "-");
                // }
                $this->updateDetail($user_id, "total_profit", $profit, "+");
                $this->updateDetail($user_id, "withdrawable_balance", $profit + $amount, "+");
                $investment->updateDetail($investment_id, "roi", $profit, "+");
                $investment->updateDetail($investment_id, "withdrawable_balance", $profit + $amount, "+");
            }
        }
    }




    public function addDeposit($deposit_id, $user_id, $deposit_type, $amount, $coin_type, $wallet_address, $transaction_slip, $from_wallet_address)
    {
        global $db;

        // $deposit_id = uniqid();
        $status = "Pending";
        $time = time();
        $time_created = date("M,d,Y h:i A");
        $result = $db->setQuery("INSERT INTO deposits (deposit_id, user_id, deposit_type, coin_type, wallet_address, usd_amount, transaction_slip, from_wallet_address, status, time, time_created) VALUES ('$deposit_id', '$user_id', '$deposit_type', '$coin_type', '$wallet_address', '$amount', '$transaction_slip', '$from_wallet_address', '$status', '$time', '$time_created');");
        if ($result) {
            return $deposit_id;
        } else {
            return false;
        }
    }

    public function depositExists($deposit_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM deposits WHERE deposit_id='$deposit_id';");
        $numrows = mysqli_num_rows($result);
        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createSupportTicketReferenceId()
    {
        $alph = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
        $nums = str_shuffle("12345678901234567890");
        if (strlen($alph) > 3) {
            $cutalph = substr($alph, 0, 3);

            $alph = $cutalph;
        }

        if (strlen($nums) > 3) {
            $cutnums = substr($nums, 0, 3);

            $nums = $cutnums;
        }

        $result = $alph . $nums;
        $final_result = str_shuffle($result);
        return  $final_result;
    }

    public function sendSupportTicket($user_id, $subject, $message)
    {
        global $db;

        $reference_id = $this->createSupportTicketReferenceId();
        $time = time();
        $time_created = date("M,d,Y h:i A");
        $result = $db->setQuery("INSERT INTO support_tickets (user_id, reference_id, subject, message, time, time_created) VALUES ('$user_id', '$reference_id', '$subject', '$message', '$time', '$time_created');");
        if ($result) {
            return $reference_id;
        } else {
            return false;
        }
    }

    public function sendNotification($user_id, $title, $message)
    {
        global $db;

        $status = "Not Seen";
        $time = time();
        $time_created = date("M,d,Y h:i A");
        $result = $db->setQuery("INSERT INTO notifications (user_id, title, message, status, time_created) VALUES ('$user_id', '$title', '$message', '$status', '$time_created');");

        return $result;
    }

    public function getTotalNumUnseenNotifications($user_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM notifications WHERE user_id='$user_id' and status='Not Seen';");
        $numrows = mysqli_num_rows($result);
        return $numrows;
    }

    public function passwordResetKeyIsValid($key_id)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM password_reset_keys WHERE key_id='$key_id' and status='unused';");
        $numrows = mysqli_num_rows($result);
        if ($numrows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createTrade($user_id, $asset, $amount, $trade_type)
    {
        global $db;
        $trade_id = uniqid();
        $time_created = date("M,d,Y h:i A");
        $profit = 0;

        $result = $db->setQuery("INSERT INTO trades (user_id, trade_id, asset, amount, profit, trade_type, time_created) VALUES ('$user_id', '$trade_id', '$asset', '$amount', '$profit', '$trade_type', '$time_created');");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function formatWhatsappPhone($phone)
    {
        $new_phone = $phone;
        $phone_array = explode("+", $new_phone);
        $new_phone = "";
        foreach ($phone_array as $phone) {
            $new_phone .= $phone;
        }

        $phone_array = explode("(", $new_phone);
        $new_phone = "";
        foreach ($phone_array as $phone) {
            $new_phone .= $phone;
        }

        $phone_array = explode(")", $new_phone);
        $new_phone = "";
        foreach ($phone_array as $phone) {
            $new_phone .= $phone;
        }

        $phone_array = explode(" ", $new_phone);
        $new_phone = "";
        foreach ($phone_array as $phone) {
            $new_phone .= $phone;
        }

        return $new_phone;
    }
}

$user = new User();
