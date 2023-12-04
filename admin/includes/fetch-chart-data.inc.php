<?php
require "../../sqlConnection/db_connect.php";

if (isset($_POST['functionName'])) {
    $function = $_POST['functionName'];
    
    switch($function) {
        case 'getGenderData':
            echo getGenderData();
            break;
        case 'getAgeData':
            echo getAgeData();
            break;
        case 'getRowNum':
            echo getRowNum($_POST['tableName']);
            break;
        case 'getStudentRetention':
            echo getStudentRetention();
            break;
        case 'getDetailedGenderData':
            echo getDetailedGenderData();
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

function getDetailedGenderData() {
    global $conn;
    $sqlMale = "SELECT stdID, stdFName, stdMName, stdLName, stdCourse FROM stdinfo WHERE (stdGender = 'Male')";
    $maleResult = mysqli_query($conn, $sqlMale);
    
    $sqlFemale = "SELECT stdID, stdFName, stdMName, stdLName, stdCourse FROM stdinfo WHERE (stdGender = 'Female')";
    $femaleResult = mysqli_query($conn, $sqlFemale);

    $maleArray = $femaleArray = array();
    while ($row = mysqli_fetch_assoc($maleResult)) {
        $maleArray[] = array('stdID' => $row['stdID'], 'stdFName' => $row['stdFName'], 'stdMName' => $row['stdMName'], 'stdLName' => $row['stdLName'], 'stdCourse' => $row['stdCourse']);
    }
    // while ($row = mysqli_fetch_assoc($femaleResult)) {
    //     $femaleArray[] = array('stdID' => $row['stdID'], 'stdFName' => $row['stdFName'], 'stdMName' => $row['stdMName'], 'stdLName' => $row['stdLName'], 'stdCourse' => $row['stdCourse']);
    // }

    // return json_encode(array('Male' => $maleArray, 'Female' => $femaleArray));

    return json_encode($maleArray);
}

function getAgeData() {
    global $conn;
    // Get the ages and also the max age and min age for male and female to be used for dividing the age graph
    $sqlForMale = "
        SELECT 
            TIMESTAMPDIFF(YEAR, stdBirth, CURDATE()) AS age,
            MAX(TIMESTAMPDIFF(YEAR, stdBirth, CURDATE())) AS max_age,
            MIN(TIMESTAMPDIFF(YEAR, stdBirth, CURDATE())) AS min_age
        FROM stdinfo 
        WHERE
            (stdGender = 'Male')
    ";
    $sqlForFemale = "
        SELECT 
            TIMESTAMPDIFF(YEAR, stdBirth, CURDATE()) AS age,
            MAX(TIMESTAMPDIFF(YEAR, stdBirth, CURDATE())) AS max_age,
            MIN(TIMESTAMPDIFF(YEAR, stdBirth, CURDATE())) AS min_age
        FROM stdinfo 
        WHERE
            (stdGender = 'Female')
    ";

    $maleResult = mysqli_query($conn, $sqlForMale);
    $femaleResult = mysqli_query($conn, $sqlForFemale);

    $maleRow = mysqli_fetch_assoc($maleResult);
    $femaleRow = mysqli_fetch_assoc($femaleResult);

    $maleMaxAge = $maleRow['max_age'];
    $maleMinAge = $maleRow['min_age'];
    $femaleMaxAge = $femaleRow['max_age'];
    $femaleMinAge = $femaleRow['min_age'];

    // Find the highest and lowest age, and the range
    $absoluteMax = ($maleMaxAge >= $femaleMaxAge) ? $maleMaxAge : $femaleMaxAge;
    $absoluteMin = ($maleMinAge <= $femaleMinAge) ? $maleMinAge : $femaleMinAge;
    $range = $absoluteMax - $absoluteMin;

    // Calculate the max value of each 8 column
    $interval = round($range / 8);
    $column = array();
    for ($i = 1; $i <= 8; $i++) {
        if ($i == 1) $column[$i - 1] = $absoluteMin + ($interval * $i);
        else $column[$i - 1] = $column[$i - 2] + $interval + 1;
    }

    // Get all the ages of male and female
    $sqlForMale = "
        SELECT 
            TIMESTAMPDIFF(YEAR, stdBirth, CURDATE()) AS age
        FROM stdinfo 
        WHERE
            (stdGender = 'Male')
    ";
    $sqlForFemale = "
        SELECT 
            TIMESTAMPDIFF(YEAR, stdBirth, CURDATE()) AS age
        FROM stdinfo 
        WHERE
            (stdGender = 'Female')
    ";

    $maleResult = mysqli_query($conn, $sqlForMale);
    $femaleResult = mysqli_query($conn, $sqlForFemale);

    // Determine which column each age will be
    $maleColumnCount = array(0, 0, 0, 0, 0, 0, 0, 0);
    while ($row = mysqli_fetch_assoc($maleResult)) {
        for ($i = 0; $i < 8; $i++) {
            if ($row['age'] >= ($column[$i] - $interval) && $row['age'] <= $column[$i]) {
                $maleColumnCount[$i]++;
                break;
            } 
            else if ($i == 7) {
                $maleColumnCount[1]++;
                break;
            }
        }
    }

    $femaleColumnCount = array(0, 0, 0, 0, 0, 0, 0, 0);
    while ($row = mysqli_fetch_assoc($femaleResult)) {
        for ($i = 0; $i < 8; $i++) {
            if ($row['age'] >= ($column[$i] - $interval) && $row['age'] <= $column[$i]) {
                $femaleColumnCount[$i]++;
                break;
            }
        }
    }

    // Create the label of each column to be used by chart.js
    $ageChartLabel = array();
    for ($i = 0; $i < 8; $i++) {
        $minValue = $column[$i] - $interval;
        $ageChartLabel[$i] = $minValue . " - " . $column[$i];
    }

    // Return the data needed by the chart.js
    $ageChartData = array();
    $ageChartData[] = $ageChartLabel;
    $ageChartData[] = $maleColumnCount;
    $ageChartData[] = $femaleColumnCount;

    return json_encode($ageChartData);
}

function getRowNum($tableName) {
    global $conn;

    $sql = $conn->prepare("SELECT * FROM " . $tableName);
    $sql->execute();
    $sql->store_result();
    return $sql->num_rows;
}

function getStudentRetention() {
    global $conn;

    // Determine if the student is dropped between 1 to 2 year or today to 1 year
    $today = date('Y-m-d');
    $oneYearFromNow = date('Y-m-d', strtotime('+1 year'));
    $twoYearFromNow = date('Y-m-d', strtotime('+2 year'));

    $stmtDroppedRecently = $conn->prepare("SELECT schoolID FROM archived_userinfo WHERE userStatus = 'dropped' AND expiration BETWEEN ? AND ?");
    $stmtDroppedRecently->bind_param('ss', $today, $oneYearFromNow);
    $stmtDroppedRecently->execute();
    $stmtDroppedRecently->store_result();
    $droppedRecently = $stmtDroppedRecently->num_rows;

    $stmtDroppedOld = $conn->prepare("SELECT schoolID FROM archived_userinfo WHERE userStatus = 'dropped' AND expiration BETWEEN ? AND ?");
    $stmtDroppedOld->bind_param('ss', $today, $twoYearFromNow);
    $stmtDroppedOld->execute();
    $stmtDroppedOld->store_result();
    $droppedOld = $stmtDroppedRecently->num_rows;
    
    // Determine how much the retention improved
    if ($droppedRecently == 0) $retentionRate = 100;
    else if ($droppedOld == 0) $retentionRate = 0;
    else $retentionRate = 100 - (($droppedRecently / $droppedOld) * 100);

    return json_encode(array($droppedRecently, $retentionRate));
}