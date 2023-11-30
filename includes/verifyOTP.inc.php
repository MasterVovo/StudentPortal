<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $enteredOtp = $_POST["otp"];

    if($enteredOtp != $_SESSION["otp"]){
        echo "Incorrect OTP";
        exit();
    }

    header("Location: ../resetPass.php");
    exit();
}
?>