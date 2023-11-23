<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/PHPMailer-master/src/Exception.php';
require '../../vendor/PHPMailer-master/src/PHPMailer.php';
require '../../vendor/PHPMailer-master/src/SMTP.php';

function sendEmail($email, $id, $password, $name) {
    $URL = "kldstudentportal.rf.gd";
    $supportEmail = "recordingsandrew@gmail.com";
    $contactInfo = "09123456789";
    
    $emailText = sprintf("
    Dear %s,
    
    We are delighted to welcome you to KLD's Student Portal, your central hub for academic resources, announcements, and personalized information. Your login credentials are provided below:
    
    Student ID: %s
    Password: %s
    
    Please follow the steps below to get started:
    
    Login URL: %s
    Use your provided Student ID and the temporary password to log in.
    You will be prompted to complete your information upon your first login. 
    You should change your password after logging in. Choose a strong and secure password.
    If you have any issues or questions regarding your login credentials, please contact our support team at %s.
    
    We encourage you to explore the various features of the Student Portal, including:
    
    Personalized academic information
    Important announcements
    Thank you for being part of our academic community. We look forward to supporting you on your educational journey.
    
    Best regards,
    
    Kolehiyo ng Lungsod ng Dasmariñas
    Brngy. Burol Main
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

    $mail->send();

    echo "Sent Successfully";
}