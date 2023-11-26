<?php
require "../../sqlConnection/db_connect.php";

$sql = "SELECT `stdGender` FROM stdinfo WHERE (stdGender = 'Male')";
$result = mysqli_query($conn, $sql);
$maleCount = mysqli_num_rows($result);

$sql = "SELECT `stdGender` FROM stdinfo WHERE (stdGender = 'Female')";
$result = mysqli_query($conn, $sql);
$femaleCount = mysqli_num_rows($result);

$data = array($maleCount, $femaleCount);
echo json_encode($data);