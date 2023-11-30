<?php
require "../../sqlConnection/db_connect.php";

if (isset($_POST['functionName'])) {
    $function = $_POST['functionName'];

    switch ($function) {
        case 'updateFctSection':
            echo updateFctSection($_POST['fctData']);
            break;
    }
}

function updateFctSection($fctData) {
    global $conn;

    // Check if there is already an adviser in that section
    $sqlQuery = $conn->prepare("Select * FROM tblsections WHERE sectionName = ?");
    $sqlQuery->bind_param('s', $fctData['sectionName']);
    $sqlQuery->execute();
    $result = $sqlQuery->get_result();
    $row = $result->fetch_assoc();
    if (isset($row['sectionAdviserId']) && $row['sectionAdviserId'] != "") {
        return 'adviser already exist';
    } else {
        // UPDATE the professors section
        $sqlQuery = $conn->prepare("UPDATE tblsections SET sectionAdviserId = ? WHERE sectionName = ?");
        $sqlQuery->bind_param('ss', $fctData['thrId'], $fctData['sectionName']);
        $sqlQuery->execute();
        if ($sqlQuery->affected_rows == 1) {
            return 'success';
        } else {
            return 'something went wrong';
        }
    }
}