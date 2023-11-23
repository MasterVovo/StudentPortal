<?php
require "../../sqlConnection/db_connect.php";
require "generate-pass.inc.php";

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

    $userPass = generatePass();
    $userType = 'student';
    
    $stmt = $conn->prepare("INSERT INTO stdinfo (stdID, stdFName, stdMName, stdLName, stdCourse, stdEmail) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $stdID, $stdFName, $stdMName, $stdLName, $stdCourse, $stdEmail);
    $stmt->execute();

    // Check if the operation was successful
    if ($stmt->affected_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO userinfo (schoolID, userPass, userType) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $stdID, $userPass, $userType);
        $stmt->execute();
        
        // Check if the operation was successful
        if ($stmt->affected_rows > 0) {
            // Echo a success message
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
        } else {
            // Echo an error message
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Error inserting to userinfo']);
        }
    } else {
        // Echo an error message
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Error inserting to stdinfo']);
    }

    
}

