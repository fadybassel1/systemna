<?php
session_start();
include('../DB/Database.php');
$DB = new Database();

use PHPMailer\PHPMailer\PHPMailer; /* Namespace alias. */
use PHPMailer\PHPMailer\Exception; /* Namespace alias. */
require '../composer/vendor/autoload.php'; /* Include the Composer generated autoload.php file. */
date_default_timezone_set('Etc/UTC'); /* Set the script time zone to UTC. */
$mail = new PHPMailer(TRUE); /* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$mail->SMTPOptions = array('ssl'=>array('verify_peer'=>false, 'verify_peer_name'=>false, 'allow_self_signed'=>true));
$mail->isSMTP(); /* Use SMTP. */
$mail->Host = 'smtp.gmail.com'; /* Google (Gmail) SMTP server. */
$mail->Port = 587; /* SMTP port. */
$mail->SMTPAuth = true; /* Set authentication. */
$mail->SMTPSecure = 'tls'; /* Set authentication. */
$mail->Username = 'systemnamiu@gmail.com'; /* Username (email address). */
$mail->Password = 'tpwvzpocyggbhmlr'; /* Google account password. */
$mail->setFrom('systemnamiu@gmail.com', $_SESSION["name"] . ' from SYSTEMNA'); /* Set the mail sender. */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['type'] == "notiall")
    {
        $sql = "SELECT * FROM employee";
        $DB->query($sql);
        $DB->execute();
        $x=$DB->getdata();
        $y=$DB->numRows();
        for ($i=0; $i<$y; $i++) {
            if (isset($_POST['notification'])) {
                $notification=filter_var($_POST['notification'], FILTER_SANITIZE_STRING);
                $uid=$x[$i]->id;
                $sql2="INSERT INTO notifications (status, userid, notidata) VALUES ('0','$uid','$notification')";
                $DB->query($sql2);
                $DB->execute();
            }
        }
        echo "true";
    }
    else if ($_POST['type'] == "notione")
    {
        $uid = $_POST['id'];
        if (isset($_POST['notification'])) {
            $notification=filter_var($_POST['notification'], FILTER_SANITIZE_STRING);
            $sql2="INSERT INTO notifications (status, userid, notidata) VALUES ('0','$uid','$notification')";
            $DB->query($sql2);
            $DB->execute();
        }
        echo "true";
    }
    else if ($_POST['type'] == "mailall")
    {
        $sql = "SELECT * FROM employee";
        $DB->query($sql);
        $DB->execute();
        $x=$DB->getdata();
        $y=$DB->numRows();
        if (isset($_POST['mailsubject']) && isset($_POST['mailcontent'])) {
            $mailsubject=filter_var($_POST['mailsubject'], FILTER_SANITIZE_STRING);
            $mailcontent=filter_var($_POST['mailcontent'], FILTER_SANITIZE_STRING);
            $mail->Subject = "$mailsubject"; /* Set the subject. */
            $mail->Body = "$mailcontent"; /* Set the mail message body. */
            for ($i=0; $i<$y; $i++) {
                $umail=$x[$i]->email;
                $uname=$x[$i]->fullname;
                $mail->addAddress("$umail", "$uname"); /* Add a recipient. */
                $mail->send(); /* Send the mail. */
                $mail->ClearAddresses(); /* Removes the data after sending. */
            }
        }
        echo "true";
    }
    else if ($_POST['type'] == "mailone")
    {
        $umail=$_POST['email'];
        $sql = "SELECT fullname FROM employee WHERE email='$umail' ";
        $DB->query($sql);
        $DB->execute();
        $x = $DB->getdata();
        $uname = $x[0]->fullname;
        if (isset($_POST['mailsubject']) && isset($_POST['mailcontent'])) {
            $mailsubject=filter_var($_POST['mailsubject'], FILTER_SANITIZE_STRING);
            $mailcontent=filter_var($_POST['mailcontent'], FILTER_SANITIZE_STRING);
            $mail->Subject = "$mailsubject"; /* Set the subject. */
            $mail->Body = "$mailcontent"; /* Set the mail message body. */
            $mail->addAddress("$umail", "$uname"); /* Add a recipient. */
            $mail->send(); /* Send the mail. */
        }
        echo "true";
    }
}
else 
{
    header("location: ../index.php");
}
?>