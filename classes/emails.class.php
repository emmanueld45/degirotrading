<?php

class Emails
{





        public function sendSignupEmail($userid)
        {
                global $admin;
                global $user;
                // sending email start

                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");

                $title = 'Welcome to  ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
                <head>
                <style>
                </style>
                <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
                </head>
                <body style="padding:15px;">';

                $message .= '<div style="width:100%;">
                Hello ' . $receiver_firstname . ',  
                Welcome to ' . $admin->website_name . '. Your trusted investment platform.
                You can start earning realistic returns on following these steps.

                <br><br>
               <ol>
               <li> Fund your account (Deposit)</li>
               
               <li>Select an investment Plan and wait for your investment to Mature</li>
                
                <li>Withdraw your funds instantly</li>
                </ol>

                </div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
                ' . $footer . '
                </div>

                </body></html>';

                // Sending email
                if (mail($to, $subject, $message, $headers)) {
                        return true;
                } else {
                        return false;
                }

                // sending email end
        }







        public function sendDepositEmail($userid, $method, $usd_amount, $wallet_address, $txn_ref)
        {
                global $user;
                global $admin;

                // sending email start

                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Deposit pending- ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
                <head>
                <style>
                </style>
                <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
                </head>
                <body style="padding:15px;">';

                $message .= '<div style="width:100%;">
                Hello ' . $receiver_firstname . ',  
                You have requested a deposit of $' . $usd_amount . '(in ' . $method . ').
                Your transaction reference is ' . $txn_ref . ' You are to make a deposit of ' . $usd_amount . ' in ' . $method . '
                to your personal ' . $method . ' wallet on ' . $admin->website_name . ' platform: ' . $wallet_address . ' to activate your pending deposit.
                <br><br>
                Funds are automatically added to your account when received.

                </div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
                ' . $footer . '
                </div>

                </body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end
        }




        public function sendTopupEmail($userid, $method, $usd_amount, $wallet_address, $txn_ref)
        {
                global $user;
                global $admin;

                // sending email start

                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Topup pending- ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
                <head>
                <style>
                </style>
                <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
                </head>
                <body style="padding:15px;">';

                $message .= '<div style="width:100%;">
                Hello ' . $receiver_firstname . ',  
                You have requested a deposit of $' . $usd_amount . '(in ' . $method . ').
                Your transaction reference is ' . $txn_ref . ' You are to make a deposit of ' . $usd_amount . ' in ' . $method . '
                to your personal ' . $method . ' wallet on ' . $admin->website_name . ' platform: ' . $wallet_address . ' to activate your pending deposit.
                <br><br>
                Funds are automatically added to your account when received.

                </div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
                ' . $footer . '
                </div>

                </body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end
        }


        public function sendWithdrawalActvatedEmail($userid, $usd_amount, $txn_ref)
        {

                global $user;
                global $admin;
                // sending email start

                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Withdrawal request has been confirmed - ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
<head>
<style>
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="padding:15px;">';

                $message .= '<div style="width:100%;">
Hello ' . $receiver_firstname . ',  
You have requested a withdrawal of $' . $usd_amount . '.
Your transaction reference is ' . $txn_ref . ' 
Your withdrawal will be processed shortly.
<br><br>

<br><br>

</div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
' . $footer . '
</div>

</body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end

        }




        public function sendWithdrawalDeclinedEmail($userid, $usd_amount)
        {

                global $user;
                global $admin;

                // sending email start

                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Withdrawal request Declined - ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
<head>
<style>
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="padding:15px;">';

                $message .= '<div style="width:100%;">
Hello ' . $receiver_firstname . ',  
Your withdrawal request of $' . $usd_amount . ' was declined
Please contact our support to learn more.
<br><br>


<br><br>

</div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
' . $footer . '
</div>

</body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end

        }




        public function sendWithdrawalApprovedEmail($userid, $usd_amount)
        {

                global $user;
                global $admin;

                // sending email start


                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Withdrawal request Approved - ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url_e . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
<head>
<style>
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="padding:15px;">';

                $message .= '<div style="width:100%;">
Hello ' . $receiver_firstname . ',  
Your withdrawal request of $' . $usd_amount . ' has been approved! 
Funds will be sent to you shortly
<br><br>


<br><br>

</div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
' . $footer . '
</div>

</body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end

        }



        public function sendDepositApprovedEmail($userid, $usd_amount)
        {

                global $user;
                global $admin;

                // sending email start


                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Withdrawal request Approved - ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url_e . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
<head>
<style>
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="padding:15px;">';

                $message .= '<div style="width:100%;">
Hello ' . $receiver_firstname . ',  
Your Deposit of $' . $usd_amount . ' has been approved! 
And an investment profile has been created for you and is currently Active.
Kindly login to your account and check your investments page to view this
<br><br>


<br><br>

</div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
' . $footer . '
</div>

</body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end

        }





        public function sendDepositDeclinedEmail($userid, $usd_amount)
        {

                global $user;
                global $admin;

                // sending email start

                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Deposit request Declined - ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
<head>
<style>
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="padding:15px;">';

                $message .= '<div style="width:100%;">
Hello ' . $receiver_firstname . ',  
Your Deposit request of $' . $usd_amount . ' was declined
Please contact our support to learn more.
<br><br>


<br><br>

</div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
' . $footer . '
</div>

</body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end

        }





        public function sendRecoverPasswordEmail($userid, $key_id)
        {
                global $db;
                global $admin;
                global $user;



                $receiver_username = $user->getDetail($userid, "username");
                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");

                $key = $key_id;

                $title = 'Recover password - ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url . " Learn about email security and online safety. 
       © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
<head>
<style>
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="padding:15px;">';

                $message .= '<div style="width:100%;">
Hello ' . $receiver_firstname . ',   We noticed you recently made a request to recover your password.
<br><br>
Kindly click on the link below to reset your password
<br>
<a href="' . $admin->website_url . '/reset-password?key_id=' . $key_id . '" style="font-size:20px;">CLICK HERE</a>
<br><br>
<span style="font-weight:bold;color:black;">Regards,</span>


</div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
' . $footer . '
</div>

</body></html>';

                // Sending email
                $send = mail($to, $subject, $message, $headers);
                if ($send) {
                        return true;
                }
        }



        public function sendVerificationRequestApprovedEmail($userid)
        {

                global $user;
                global $admin;

                // sending email start


                $receiver_firstname = $user->getDetail($userid, "firstname");
                $receiver_lastname = $user->getDetail($userid, "lastname");
                $receiver_email = $user->getDetail($userid, "email");


                $title = 'Account verified - ' . $admin->website_name;
                $footer = "This email was intended for <span>$receiver_firstname $receiver_lastname</span>, because you signed on " . $admin->website_name . " | The links in this email will always direct to " . $admin->website_url_e . " Learn about email security and online safety. 
   © " . $admin->website_name;

                $to =  $receiver_email;
                $subject = $title;
                $from = $admin->getDetail($admin->admin_id, "email");

                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message
                $message = '<html>
<head>
<style>
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="padding:15px;">';

                $message .= '<div style="width:100%;">
Hello ' . $receiver_firstname . ',  
This is to let you know that your account has been verified.
You can now login and start your investment journey with us.


<br><br>

</div>';

                $message .= '<div style="width:100%;text-align:center;font-size: 12px;color:rgb(100, 100, 100);padding:10px;">
' . $footer . '
</div>

</body></html>';

                // Sending email
                mail($to, $subject, $message, $headers);

                // sending email end

        }
}

$email_class = new Emails();
