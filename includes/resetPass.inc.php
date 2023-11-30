<?php
session_start();
require_once "../sqlConnection/db_connect.php"; //Connects to the db

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPass = $_POST["newPass"];
    $repeatPass = $_POST["repeatPass"];

    if($newPass != $repeatPass){
        echo "error";
        exit();
    }

    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

    $sql = "UPDATE userinfo SET userPass = ? WHERE schoolID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashedPass, $_SESSION["userId"]);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo "success";
        exit();
    } else {
        echo "error";
        exit();
    }
}
?>