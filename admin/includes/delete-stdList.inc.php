<?php
require "../sqlConnection/db_connect.php";

$stdID = $_POST['stdID'];

// Archive the row in the backup database
$stmt = $conn->prepare("INSERT INTO archived_stdinfo SELECT * FROM stdinfo WHERE stdID = ?");
$stmt->bind_param('s', $stdID);
$stmt->execute();

// Delete the row in the main database
$stmt = $conn->prepare("DELETE FROM stdinfo WHERE stdID = ?");
$stmt->bind_param('s', $stdID);
$stmt->execute();



