<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer-master/src/Exception.php';
require '../vendor/PHPMailer-master/src/PHPMailer.php';
require '../vendor/PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailText = sprintf("
    Dear User,<br><br>

    Someone is trying to change your password in KLD's Student Portal. If it's not you, please ignore this email. <br><br>

    One Time Password:<br>
    <h1>%s</h1>

    Best regards, <br><br>
    
    Kolehiyo ng Lungsod ng Dasmariñas<br>
    Brgy. Burol Main<br>
    ", $_POST["otp"]);


    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'recordingsandrew@gmail.com';
    $mail->Password = 'ofhp fmgy bgol agxf';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('recordingsandrew@gmail.com');

    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $mail->Subject = 'Welcome to KLD Student Portal';
    $mail->Body = $emailText;

    $mail->send();
}