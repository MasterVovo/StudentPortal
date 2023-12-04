<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/PHPMailer-master/src/Exception.php';
require '../../vendor/PHPMailer-master/src/PHPMailer.php';
require '../../vendor/PHPMailer-master/src/SMTP.php';

function sendEmail($email, $id, $password, $name) {
    $URL = "kldstudentportal201.000webhostapp.com";
    $supportEmail = "recordingsandrew@gmail.com";
    $contactInfo = "09123456789";
    
    $emailText = sprintf("
    Dear %s,<br><br>
    
    We are delighted to welcome you to KLD's Student Portal, your central hub for academic resources, announcements, and personalized information. Your login credentials are provided below:<br><br>
    
    Student ID: %s<br>
    Password: %s<br><br>
    
    Please follow the steps below to get started:<br><br>
    
    Login URL: %s<br>
    Use your provided Student ID and the temporary password to log in.<br>
    You will be prompted to complete your information upon your first login.<br>
    You should change your password after logging in. Choose a strong and secure password.<br>
    If you have any issues or questions regarding your login credentials, please contact our support team at %s.<br><br>
    
    We encourage you to explore the various features of the Student Portal, including:<br><br>
    
    Personalized academic information<br>
    Important announcements<br>
    Thank you for being part of our academic community. We look forward to supporting you on your educational journey.<br><br>
    
    Best regards, <br><br>
    
    Kolehiyo ng Lungsod ng Dasmariñas<br>
    Brgy. Burol Main<br>
    ", $name, $id, $password, $URL, $supportEmail);


    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'recordingsandrew@gmail.com';
    $mail->Password = 'ofhp fmgy bgol agxf';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('recordingsandrew@gmail.com');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Welcome to KLD Student Portal';
    $mail->Body = $emailText;

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}