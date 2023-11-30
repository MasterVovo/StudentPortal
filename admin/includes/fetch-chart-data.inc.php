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
    $absoluteMax;
    $absoluteMin;
    $range = 0;
    if ($maleMaxAge >= $femaleMaxAge) {
        $absoluteMax = $maleMaxAge;
        if ($maleMinAge <= $femaleMinAge) {
            $absoluteMin = $maleMinAge;
            $range = $maleMaxAge - $maleMinAge;
        } else if ($femaleMinAge < $maleMinAge) {
            $absoluteMin = $femaleMinAge;
            $range = $maleMaxAge - $maleMinAge;
        }
    } else if ($femaleMaxAge > $maleMaxAge) {
        $absoluteMax = $femaleMaxAge;
        if ($maleMinAge <= $femaleMinAge) {
            $absoluteMin = $maleMinAge;
            $range = $femaleMaxAge - $maleMinAge;
        } else if ($femaleMinAge < $maleMinAge) {
            $absoluteMin = $femaleMinAge;
            $range = $femaleMaxAge - $femaleMinAge;
        }
    }

    // Calculate the max value of each 8 column
    $interval = $range / 8;
    $column = array();
    for ($i = 0; $i < 8; $i++) {
        $column[$i] = $absoluteMin + ($interval * $i);
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
            if ($row['age'] > ($column[$i] - $range) && $row['age'] < $column[$i]) {
                $maleColumnCount[$i]++;
                break;
            }
        }
    }

    $femaleColumnCount = array(0, 0, 0, 0, 0, 0, 0, 0);
    while ($row = mysqli_fetch_assoc($femaleResult)) {
        for ($i = 0; $i < 8; $i++) {
            if ($row['age'] > ($column[$i] - $range) && $row['age'] < $column[$i]) {
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

