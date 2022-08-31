<?php

class Investments
{
    public $investment_id;


    // public function getPlanEndtime($plan)
    // {

    //     if ($plan == "Basic") {
    //         return 600; //2160000;
    //     } else if ($plan == "Executive") {
    //         return 600; //1728000;
    //     } else if ($plan == "Vip") {
    //         return 600; //1555200;
    //     } else if ($plan == "Vvip") {
    //         return 600; //1296000;
    //     } else if ($plan == "Representative") {
    //         return 600; //1296000;
    //     }
    // }

    public function getPlanROI($plan)
    {
        if ($plan == "Basic") {
            return 0.05;
        } else if ($plan == "Executive") {
            return 0.1;
        } else if ($plan == "Vip") {
            return 0.15;
        } else if ($plan == "Vvip") {
            return 0.2;
        } else if ($plan == "Representative") {
            return 0.205;
        }
    }

    public function amountAndPlanIsValid($amount, $plan)
    {
        if ($plan == "Gold") {
            if ($amount >= 1000 && $amount <= 4999) {
                return true;
            } else {
                return false;
            }
        } else if ($plan == "Platinum") {
            if ($amount >= 5000 && $amount <= 9999) {
                return true;
            } else {
                return false;
            }
        } else if ($plan == "Diamond") {
            if ($amount >= 10000 && $amount <= 25000) {
                return true;
            } else {
                return false;
            }
        } else if ($plan == "Block") {
            if ($amount >= 25000) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getPlanDisplayDetails($plan)
    {
        if ($plan == "Bronze") {
            $details = array(
                'min' => 100,
                'max' => 4999,
                'duration' => '5 Days',
                'profit' => '2.8%'
            );

            return $details;
        } else if ($plan == "Silver") {
            $details = array(
                'min' => 5000,
                'max' => 14999,
                'duration' => '5 Days',
                'profit' => '3.5%'
            );
            return $details;
        } else if ($plan == "Gold") {
            $details = array(
                'min' => 15000,
                'max' => 'Unlimited',
                'duration' => '5 Days',
                'profit' => '4%'
            );
            return $details;
        } 
    }


    public function createInvestmentId()
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
        return  "FIL_" . $final_result;
    }

    public function createInvestment($user_id, $plan, $amount)
    {
        global $db;

        $investment_id = $this->createInvestmentId();
        $status = "Active";
        $time_created = date("M,d,Y h:i A");

        $result = $db->setQuery("INSERT INTO investments (investment_id, user_id, plan, amount, status, time_created) VALUES ('$investment_id', '$user_id', '$plan', '$amount', '$status', '$time_created');");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getDetail($investment_id, $detail)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM investments WHERE investment_id='$investment_id';");
        $row = mysqli_fetch_assoc($result);
        $detail = $row[$detail];

        return $detail;
    }


    public function setDetail($investment_id, $field, $detail)
    {
        global $db;

        $result = $db->setQuery("UPDATE investments SET $field='$detail' WHERE investment_id='$investment_id';");

        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function updateDetail($investment_id, $detail, $value, $op)
    {
        global $db;

        $result = $db->setQuery("SELECT * FROM investments WHERE investment_id='$investment_id';");
        $row = mysqli_fetch_assoc($result);
        $old_value = $row[$detail];

        if ($op == "+") {
            $new_value = $old_value + $value;
        } else if ($op == "-") {
            $new_value = $old_value - $value;
        }

        $result1 = $db->setQuery("UPDATE investments SET $detail='$new_value' WHERE investment_id='$investment_id';");
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}

$investment = new Investments();
