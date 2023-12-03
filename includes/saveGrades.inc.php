<?php
session_start();
require "../sqlConnection/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted data
    $gradePrelims = $_POST["gradePrelims"];
    $gradeMidterms = $_POST["gradeMidterms"];
    $gradeFinals = $_POST["gradeFinals"];
    $subjectCode = $_POST["subjectCode"];
    $semesterId = $_POST["semesterId"];

    foreach ($gradePrelims as $stdID => $prelimGrade) {
        // Check if the student already has a record in tblgrades
        $sqlCheck = "SELECT * FROM tblgrades WHERE studentId = ? AND subjectCode = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("ss", $stdID, $subjectCode[$stdID]);  // Assuming $subjectCode is defined
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            // Update the existing record
            $sqlUpdate = "UPDATE tblgrades SET gradePrelims = ?, gradeMidterms = ?, gradeFinals = ? 
                          WHERE studentId = ? AND subjectCode = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("sssss", $prelimGrade, $gradeMidterms[$stdID], $gradeFinals[$stdID], $stdID, $subjectCode[$stdID]);
            $stmtUpdate->execute();
        } else {
            // Insert a new record
            $sqlInsert = "INSERT INTO tblgrades (studentId, subjectCode, semesterId, gradePrelims, gradeMidterms, gradeFinals) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("ssssss", $stdID, $subjectCode[$stdID], $semesterId[$stdID], $prelimGrade, $gradeMidterms[$stdID], $gradeFinals[$stdID]);
            $stmtInsert->execute();
        }
    }

    echo "Grades saved successfully";
} else {
    echo "Invalid request";
}
?>
