<?php
require "../../sqlConnection/db_connect.php";

$jsonData = $_POST['jsonData'];

// Decode the JSON data
$dataArray = json_decode($jsonData, true);

// Insert data into the database
foreach ($dataArray as $item) {
    $stdID = $item['stdID'];
    $stdFName = $item['stdFName'];
    $stdMName = $item['stdMName'];
    $stdLName = $item['stdLName'];
    $stdCourse = $item['stdCourse'];
    $stdEmail = $item['stdEmail'];
    
    $stmt = $conn->prepare("INSERT INTO stdinfo (stdID, stdFName, stdMName, stdLName, stdCourse, stdEmail) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $stdID, $stdFName, $stdMName, $stdLName, $stdCourse, $stdEmail);
    $stmt->execute();
    
    // Check if the operation was successful
    if ($stmt->affected_rows > 0) {
        // Echo a success message
        echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
    } else {
        // Echo an error message
        echo json_encode(['success' => false, 'message' => 'Error inserting data']);
    }
}

?>