<?php

class Database
{


    public $dbservername = 'localhost';

    public $dbusername = 'root';

    public $dbpassword = '';

    public $dbname = 'degirotrading';

    /*** */
    // public $dbusername = 'financial886_financial_crypto_investment';

    // public $dbpassword = 'Emmanueld45@';

    // public $dbname = 'financial886_financial_crypto_investment';
    /*** */

    public $conn;

    public $sql;

    public function __construct()
    {
        $this->conn = mysqli_connect($this->dbservername, $this->dbusername, $this->dbpassword, $this->dbname);
    }

    public function setQuery($query)
    {
        $this->sql = $query;
        $result = mysqli_query($this->conn, $this->sql);
        return $result;
    }





    public function format_contest_time($time)
    {

        if ($time >= 0 and $time < 60) {
            $t = round($time);
            if ($t == 1) {
                return array("time" => $t, "time_frame" => "seconds", "suffix" => "s");
            } else {
                return array("time" => $t, "time_frame" => "seconds",  "suffix" => "s");
            }
        } else if ($time >= 60 and $time < 3600) {
            $t = round($time / 60);
            if ($t == 1) {
                return array("time" => $t, "time_frame" => "minutes", "suffix" => "min");
            } else {
                return array("time" => $t, "time_frame" => "minutes",  "suffix" => "mins");
            }
        } else if ($time >= 3600 and $time < 86400) {
            $t = round($time / 3600);
            if ($t == 1) {
                return array("time" => $t, "time_frame" => "hours", "suffix" => "hr");
            } else {
                return array("time" => $t, "time_frame" => "hours",  "suffix" => "hrs");
            }
        } else if ($time >= 86400 and $time < 604800) {
            $t = round($time / 86400);
            if ($t == 1) {
                return array("time" => $t, "time_frame" => "days", "suffix" => "day");
            } else {
                return array("time" => $t, "time_frame" => "days",  "suffix" => "days");
            }
        } else if ($time < 0) {
            return array("time" => 0, "time_frame" => "0", "suffix" => "0");
        }
    }





    public function format_countdown_time($time)
    {

        $hours = floor($time / 3600);

        $minutes_remainder = floor($time % 3600);
        $minutes = floor($minutes_remainder / 60);

        $seconds = round($minutes_remainder % 60);

        $time_array = array(
            "hours" => $hours,
            "minutes" => $minutes,
            "seconds" => $seconds
        );

        return $time_array;
    }
}

$db = new Database();

$website_name = "degirotrading";
$website_url = "degirotrading.com";
$website_url_http = "https://degirotrading.com";
$website_email = "support@degirotrading.com";
