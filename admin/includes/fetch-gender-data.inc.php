<?php
require "../../sqlConnection/db_connect.php";

$sql = "SELECT `stdGender` FROM stdinfo;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0) {
    $maleCount = 0;
    $femaleCount = 0;

    while ($gender = mysqli_fetch_assoc($result)) {
        if ($gender['stdGender'] == 'Male') {
            $maleCount++;
        } else if ($gender['stdGender'] == 'Female') {
            $femaleCount++;
        }
    }
    
    $data = array($maleCount, $femaleCount);
    echo json_encode($data);
}