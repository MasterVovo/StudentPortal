<?php
require "../../sqlConnection/db_connect.php";

if (isset($_GET['functionName'])) {
    $function = $_GET['functionName'];
    
    switch($function) {
        case 'getGenderData':
            echo getGenderData();
            break;

    }
}

function getGenderData() {
    global $conn;
    $sql = "SELECT `stdGender` FROM stdinfo WHERE (stdGender = 'Male')";
    $result = mysqli_query($conn, $sql);
    $maleCount = mysqli_num_rows($result);
    
    $sql = "SELECT `stdGender` FROM stdinfo WHERE (stdGender = 'Female')";
    $result = mysqli_query($conn, $sql);
    $femaleCount = mysqli_num_rows($result);
    
    $data = array($maleCount, $femaleCount);
    return json_encode($data);
}

