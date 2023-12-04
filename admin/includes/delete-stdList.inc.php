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
        case 'archiveFct': {
            archiveFct($_POST['fctData']);
            break;
        }
        case 'restoreFct':
            restoreFct($_POST['fctData']);
            break;
    }
}

function archiveStd($stdData) {
    global $conn;

    // Create an expiration date that will last for 2 years
    $newDate = createExpiration();

    // Archive the student data in the backup table
    $stmtArchivedStdInfo = $conn->prepare("INSERT INTO archived_stdinfo SELECT *, ? FROM stdinfo WHERE stdID = ?");
    $stmtArchivedStdInfo->bind_param('ss', $newDate, $stdData['stdID']);
    $stmtArchivedStdInfo->execute();

    // Archive the student login credential to the backup table
    $stmtArchivedUserInfo = $conn->prepare("INSERT INTO archived_userinfo SELECT *, ? FROM userinfo WHERE schoolID = ?");
    $stmtArchivedUserInfo->bind_param('ss', $newDate, $stdData['stdID']);
    $stmtArchivedUserInfo->execute();

    // Set the student as dropped
    $stmtDropStd = $conn->prepare("UPDATE archived_userinfo SET userStatus = 'dropped'");
    $stmtDropStd->execute();

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
    $stmtStdInfo = $conn->prepare("INSERT INTO stdinfo SELECT stdID, stdFName, stdMName, stdLName, stdSection, dateEnrolled, stdBirth, stdGender, stdCourse, stdImage, stdEmail, stdPhoneNum, stdStreet, stdCity, stdProvince, stdBrgy, stdFatherName, stdFatherPhone, stdFatherJob, stdMotherName, stdMotherPhone, stdMotherJob, stdParentAddr, stdEmerName, stdEmerRel, stdEmerPhone, stdEmerBlood FROM archived_stdinfo WHERE stdID = ?");
    $stmtStdInfo->bind_param('s', $stdData['stdID']);
    $stmtStdInfo->execute();

    // Delete the student data from the archive table
    $stmtArchivedStdInfo = $conn->prepare("DELETE FROM archived_stdinfo WHERE stdID = ?");
    $stmtArchivedStdInfo->bind_param('s', $stdData['stdID']);
    $stmtArchivedStdInfo->execute();

    // Insert the student login credential to the main table
    restoreUserInfo($stdData['stdID']);

    // Removed students dropped status
    $stmtUserInfo = $conn->prepare("UPDATE userinfo SET userStatus = ' '");
    $stmtUserInfo->execute();
}

function archiveFct($fctData) {
    global $conn;

    // Create an expiration date that will last for 2 years
    $newDate = createExpiration();

    // Archive the teacher data in the backup table
    $stmtArchivedStdInfo = $conn->prepare("INSERT INTO archived_thrinfo SELECT *, ? FROM thrinfo WHERE thrId = ?");
    $stmtArchivedStdInfo->bind_param('ss', $newDate, $fctData['thrId']);
    $stmtArchivedStdInfo->execute();

    // Archive the teacher login credential to the backup table
    $stmtArchivedUserInfo = $conn->prepare("INSERT INTO archived_userinfo SELECT *, ? FROM userinfo WHERE schoolID = ?");
    $stmtArchivedUserInfo->bind_param('ss', $newDate, $fctData['thrId']);
    $stmtArchivedUserInfo->execute();

    // Delete the teacher data in the main table
    $stmtStdInfo = $conn->prepare("DELETE FROM thrinfo WHERE thrId = ?");
    $stmtStdInfo->bind_param('s', $fctData['thrId']);
    $stmtStdInfo->execute();

    // Delete the teacher login credential in the main table
    $stmtUserInfo = $conn->prepare("DELETE FROM userinfo WHERE schoolID = ?");
    $stmtUserInfo->bind_param('s', $fctData['thrId']);
    $stmtUserInfo->execute();
}

function restoreFct($fctData) {
    global $conn;

    // Insert the teacher data to the main table
    $stmtStdInfo = $conn->prepare("INSERT INTO thrinfo SELECT thrId, thrFName, thrMName, thrLName, thrEmail, thrDept FROM archived_thrinfo WHERE thrId = ?");
    $stmtStdInfo->bind_param('s', $fctData['thrId']);
    $stmtStdInfo->execute();

    // Delete the teacher data from the archive table
    $stmtArchivedStdInfo = $conn->prepare("DELETE FROM archived_thrinfo WHERE thrId = ?");
    $stmtArchivedStdInfo->bind_param('s', $fctData['thrId']);
    $stmtArchivedStdInfo->execute();

    // Insert the teacher login credential to the main table
    restoreUserInfo($fctData['thrId']);
};

function createExpiration() {
    $currentDate = date_create();
    date_add($currentDate, date_interval_create_from_date_string('2 years'));
    $newDate = date_format($currentDate, 'Y-m-d');
    return $newDate;
}

function restoreUserInfo($schoolID) {
    global $conn;

    $stmt1 = $conn->prepare("INSERT INTO userinfo SELECT schoolID, userPass, userType, userStatus FROM archived_userinfo WHERE schoolID = ?");
    $stmt1->bind_param('s', $schoolID);
    $stmt1->execute();

    $stmt2 = $conn->prepare("DELETE FROM archived_userinfo WHERE schoolID = ?");
    $stmt2->bind_param('s', $schoolID);
    $stmt2->execute();
}