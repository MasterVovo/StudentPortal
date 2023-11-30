<?php
require "../../sqlConnection/db_connect.php";

if (isset($_POST['functionName'])) {
    switch($_POST['functionName']) {
        case 'archiveStd': {
            archiveStd($_POST['stdData']);
            break;
        }
        case 'restoreStd':
            restoreStd($_POST['stdData']);
            break;
    }
}

function archiveStd($stdData) {
    global $conn;

    // Create an expiration date that will last for 3 months
    $currentDate = date_create();
    date_add($currentDate, date_interval_create_from_date_string('3 months'));
    $newDate = date_format($currentDate, 'Y-m-d');

    // Archive the student data in the backup table
    $stmtArchivedStdInfo = $conn->prepare("INSERT INTO archived_stdinfo SELECT *, ? FROM stdinfo WHERE stdID = ?");
    $stmtArchivedStdInfo->bind_param('ss', $newDate, $stdData['stdID']);
    $stmtArchivedStdInfo->execute();

    // Archive the student login credential to the backup table
    $stmtArchivedUserInfo = $conn->prepare("INSERT INTO archived_userinfo SELECT *, ? FROM userinfo WHERE schoolID = ?");
    $stmtArchivedUserInfo->bind_param('ss', $newDate, $stdData['stdID']);
    $stmtArchivedUserInfo->execute();

    // Delete the student data in the main table
    $stmtStdInfo = $conn->prepare("DELETE FROM stdinfo WHERE stdID = ?");
    $stmtStdInfo->bind_param('s', $stdData['stdID']);
    $stmtStdInfo->execute();

    // Delete the student login credential in the main table
    $stmtUserInfo = $conn->prepare("DELETE FROM userinfo WHERE schoolID = ?");
    $stmtUserInfo->bind_param('s', $stdData['stdID']);
    $stmtUserInfo->execute();
}

function restoreStd($stdData) {
    global $conn;

    // Insert the student data to the main table
    $stmtStdInfo = $conn->prepare("INSERT INTO stdinfo SELECT stdID, stdFName, stdMName, stdLName, stdBirth, stdGender, stdCourse, stdImage, stdEmail, stdPhoneNum, stdStreet, stdCity, stdProvince, stdBrgy, stdFatherName, stdFatherPhone, stdFatherJob, stdMotherName, stdMotherPhone, stdMotherJob, stdParentAddr, stdEmerName, stdEmerRel, stdEmerPhone, stdEmerBlood FROM archived_stdinfo WHERE stdID = ?");
    $stmtStdInfo->bind_param('s', $stdData['stdID']);
    $stmtStdInfo->execute();

    // Delete the student data from the archive table
    $stmtArchivedStdInfo = $conn->prepare("DELETE FROM archived_stdinfo WHERE stdID = ?");
    $stmtArchivedStdInfo->bind_param('s', $stdData['stdID']);
    $stmtArchivedStdInfo->execute();

    // Insert the student login credential to the main table
    restoreUserInfo($stdData['stdID']);
}

function restoreUserInfo($schoolID) {
    global $conn;

    $stmt1 = $conn->prepare("INSERT INTO userinfo SELECT schoolID, userPass, userType FROM archived_userinfo WHERE schoolID = ?");
    $stmt1->bind_param('s', $schoolID);
    $stmt1->execute();

    $stmt2 = $conn->prepare("DELETE FROM archived_userinfo WHERE schoolID = ?");
    $stmt2->bind_param('s', $schoolID);
    $stmt2->execute();
}