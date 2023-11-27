<?php
session_start();
require_once "../sqlConnection/db_connect.php"; //Connects to the db

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer-master/src/Exception.php';
require '../vendor/PHPMailer-master/src/PHPMailer.php';
require '../vendor/PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT userType FROM userinfo WHERE schoolID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST["userId"]);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows === 0){
        echo "No ID found";
        exit();
    }

    $row = $result->fetch_assoc();

    if($row["userType"] != "student"){ //! Debugging
        $sql = "SELECT stdEmail FROM stdinfo WHERE stdID = ?";
        $emailType = "stdEmail";
    } else {
        $sql = "SELECT thrEmail FROM thrinfo WHERE thrId = ?";
        $emailType = "thrEmail";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST["userId"]);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($row[$emailType] != $_POST["email"]){
        echo "No email found";
        exit();
    }

    $emailText = sprintf("
    Dear User,<br><br>

    Someone is trying to change your password in KLD's Student Portal. If it's not you, please ignore this email. <br><br>

    One Time Password:<br>
    <h1>%s</h1>

    Best regards, <br><br>
    
    Kolehiyo ng Lungsod ng Dasmariñas<br>
    Brgy. Burol Main<br>
    ", $_POST["otp"]);

    $_SESSION["otp"] = $_POST["otp"];

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

    $mail->Subject = 'Verify your email';
    $mail->Body = $emailText;

    $mail->send();
}