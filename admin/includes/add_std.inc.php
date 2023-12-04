<?php
require "../../sqlConnection/db_connect.php";
require "generate-pass.inc.php";
require "send-email.inc.php";

$uploadStatus = array();

$jsonData = $_POST['jsonData'];
// $jsonData = json_encode(array(
//     array(
//       "stdID" => 1,
//       "stdFName" => "Jason",
//       "stdMName" => "Foreman",
//       "stdLName" => "Hello",
//       "stdCourse" => "PSY",
//       "stdEmail" => "ahtiw3ukkhtew@gmail.com"
      
//     ),
//     array(
//         "stdID" => 2,
//         "stdFName" => "Thor",
//         "stdMName" => "Foreman",
//         "stdLName" => "Hello",
//         "stdCourse" => "PSY",
//         "stdEmail" => "ahtiw3ukkhtew@gmail.com"
//     )
//  ));

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
    $hashedPass = password_hash($userPass, PASSWORD_DEFAULT);
    $userType = 'student';
    
    $stmt = $conn->prepare("INSERT INTO stdinfo (stdID, stdFName, stdMName, stdLName, stdCourse, stdEmail) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $stdID, $stdFName, $stdMName, $stdLName, $stdCourse, $stdEmail);
    $stmt->execute();

    // Check if the insert to stdinfo was successful
    if ($stmt->affected_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO userinfo (schoolID, userPass, userType, userStatus) VALUES (?, ?, ?, 'new')");
        $stmt->bind_param("sss", $stdID, $hashedPass, $userType);
        $stmt->execute();
        
        // Check if the insert to userinfo was successful
        if ($stmt->affected_rows > 0) {
            if (sendEmail($stdEmail, $stdID, $userPass, $stdFName)) {
                $uploadStatus[] = array('success' => true, 'message' => $stdFName . '\'s Data inserted successfully.');
            } else {
                $uploadStatus[] = array('success' => false, 'message' => $stdFName . '\'s Data inserted successfully. But couldn\'t send email.');
            }
            
        } else {
            $uploadStatus[] = array('success' => false, 'message' => $stdFName . '\'s Data cannot be inserted to userinfo.');
        }
    } else {
        $uploadStatus[] = array('success' => false, 'message' => $stdFName . '\'s Data connot be inserted to stdinfo.');
    }
}

echo json_encode($uploadStatus);