<?php
require "../../sqlConnection/db_connect.php";

$sql = "SELECT * FROM stdinfo;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

$arrayOfStdData = array();

if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $stdData = new stdData();

        $stdData->appendStdID($row['stdID']);
        $stdData->appendStdFName($row['stdFName']);
        $stdData->appendStdMName($row['stdMName']);
        $stdData->appendStdLName($row['stdLName']);

        $stdData->appendStdBirth(date('Y-m-d', strtotime($row['stdBirth'])));

        $stdData->appendStdGender($row['stdGender']);
        $stdData->appendStdCourse($row['stdCourse']);
        
        $base64 = base64_encode($row['stdImage']);
        //'<img src="data:image/jpeg;base64,' . $base64 . '"'
        $dataUrl = "<img src='data:image/jpeg;base64," . $base64 . "'/>";
        $stdData->appendStdImage($dataUrl);

        $stdData->appendStdEmail($row['stdEmail']);

        array_push($arrayOfStdData, $stdData);
    }
    echo json_encode($arrayOfStdData);
}


class stdData {
    public $stdID;
    public $stdFName;
    public $stdMName;
    public $stdLName;
    public $stdBirth;
    public $stdGender;
    public $stdCourse;
    public $stdImage;
    public $stdEmail;

    function appendStdID($data) {
        $this->stdID = $data;
    }

    function appendStdFName($data) {
        $this->stdFName = $data;
    }

    function appendStdMName($data) {
        $this->stdMName = $data;
    }

    function appendStdLName($data) {
        $this->stdLName = $data;
    }

    function appendStdBirth($data) {
        $this->stdBirth = $data;
    }

    function appendStdGender($data) {
        $this->stdGender = $data;
    }

    function appendStdCourse($data) {
        $this->stdCourse = $data;
    }
    
    function appendStdImage($data) {
        $this->stdImage = $data;
    }
    
    function appendStdEmail($data) {
        $this->stdEmail = $data;
    }
}