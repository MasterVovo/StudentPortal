<?php
require "../../sqlConnection/db_connect.php";

if (isset($_POST['functionName'])) {
    $function = $_POST['functionName'];

    switch ($function) {
        case 'updateFctSection':
            echo updateFctSection($_POST['fctData']);
            break;
        case 'updateSectionOverride':
            echo updateSectionOverride($_POST['fctData']);
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
    if (isset($row['sectionAdviserId']) && $row['sectionAdviserId'] != "" && $row['sectionAdviserId'] != $fctData['thrId']) {
        return 'adviser already exist';
    } else if ($row['sectionAdviserId'] == $fctData['thrId']) {
        $sqlQuery = $conn->prepare("UPDATE thrinfo SET thrFName = ?, thrMName = ?, thrLName = ?, thrEmail = ?, thrDept = ? WHERE thrId = ?");
        $sqlQuery->bind_param('ssssss', $fctData['thrFName'], $fctData['thrMName'], $fctData['thrLName'], $fctData['thrEmail'], $fctData['thrDept'], $fctData['thrId']);
        $sqlQuery->execute();

        if ($sqlQuery->affected_rows == 1) {
            return 'Teachers info is successfully updated';
        } else {
            return 'Something\'s wrong in updating teacher information';
        }
    } else {
        $sqlQuery = $conn->prepare("UPDATE tblsections SET sectionAdviserId = ? WHERE sectionName = ?");
        $sqlQuery->bind_param('ss', $fctData['thrId'], $fctData['sectionName']);
        $sqlQuery->execute();
        if ($sqlQuery->affected_rows == 1) {
            $sqlQuery = $conn->prepare("UPDATE thrinfo SET thrFName = ?, thrMName = ?, thrLName = ?, thrEmail = ?, thrDept = ? WHERE thrId = ?");
            $sqlQuery->bind_param('ssssss', $fctData['thrFName'], $fctData['thrMName'], $fctData['thrLName'], $fctData['thrEmail'], $fctData['thrDept'], $fctData['thrId']);
            $sqlQuery->execute();

            if ($sqlQuery->affected_rows == 1) {
                return 'Teachers info is successfully updated';
            } else {
                return 'Something\'s wrong in updating teacher information';
            }
        } else {
            return 'Error in updating section';
        }
    }
}

function updateSectionOverride($fctData) {
    global $conn;

    // Removes the teacher from the old section
    $sqlQuery1 = $conn->prepare("UPDATE tblsections SET sectionAdviserId = '' WHERE sectionAdviserId = ?");
    $sqlQuery1->bind_param('s', $fctData['thrId']);
    $sqlQuery1->execute();

    // Replace the adviser of the new section
    $sqlQuery2 = $conn->prepare("UPDATE tblsections SET sectionAdviserId = ? WHERE sectionName = ?");
    $sqlQuery2->bind_param('ss', $fctData['thrId'], $fctData['sectionName']);
    $sqlQuery2->execute();

    if ($sqlQuery2->affected_rows == 1) {
        if (isset($fctData['thrMName'])) {
            $sqlQuery = $conn->prepare("UPDATE thrinfo SET thrFName = ?, thrMName = ?, thrLName = ?, thrEmail = ?, thrDept = ? WHERE thrId = ?");
            $sqlQuery->bind_param('ssssss', $fctData['thrFName'], $fctData['thrMName'], $fctData['thrLName'], $fctData['thrEmail'], $fctData['thrDept'], $fctData['thrId']);
            $sqlQuery->execute();
        } else {
            $sqlQuery = $conn->prepare("UPDATE thrinfo SET thrFName = ?, thrLName = ?, thrEmail = ?, thrDept = ? WHERE thrId = ?");
            $sqlQuery->bind_param('sssss', $fctData['thrFName'], $fctData['thrLName'], $fctData['thrEmail'], $fctData['thrDept'], $fctData['thrId']);
            $sqlQuery->execute();
        }
        
        if ($sqlQuery->affected_rows == 1) {
            return 'Teachers info is successfully updated';
        } else {
            return 'Something\'s wrong in updating teacher information';
        }
    } else {
        return 'Something went wrong in replacing adviser';
    }
   
}