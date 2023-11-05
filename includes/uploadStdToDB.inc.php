<?php
require_once("../sqlConnection/db_connect.php");

$sql = "SELECT COUNT(*) as row_count FROM stdinfo";
$result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // Fetch the result as an associative array
//     $row = $result->fetch_assoc();

//     // Get the row count
//     $rowCount = $row["row_count"];

//     // Format the row count as a 6-digit string
//     $rowCountString = str_pad($rowCount, 6, '0', STR_PAD_LEFT);

//     // Get the current year
//     $currentYear = date("y");

//     // Generate the unique ID
//     $uniqueID = "KLD-" . $currentYear . "-" . $rowCountString;

//     echo "Unique ID: " . $uniqueID;
// } else {
//     echo "No results found.";
// }

$numOfRows = $result->num_rows;
$stdID = "KLD-" . date("y") . "-" . str_pad($numOfRows, 6, '0', STR_PAD_LEFT);

// Close the database connection
// $conn->close();


// $sql = "INSERT INTO `stdinfo`(`stdID`, `stdFName`, `stdMName`, `stdLName`, `stdCourse`, `stdEmail`) 
// VALUES (?,?,?,?,?,?)";
// $stmt = $conn->prepare($sql);


?>