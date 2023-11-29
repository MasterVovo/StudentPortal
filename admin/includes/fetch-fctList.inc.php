<?php
require "../../sqlConnection/db_connect.php";

$sql = "SELECT * FROM thrinfo;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

$arrayOfFctData = array();

if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fctData = new fctData();

        $fctData->appendThrId($row['thrId']);
        $fctData->appendThrFName($row['thrFName']);
        $fctData->appendThrMName($row['thrMName']);
        $fctData->appendThrLName($row['thrLName']);
        $fctData->appendThrDept($row['thrDept']);

        // Fetches the section of the teacher
        $sqlSection = "SELECT `sectionName` FROM tblsections WHERE (sectionAdviserId = '" . $row['thrId'] . "')";
        $resultSection = mysqli_query($conn, $sqlSection);

        while ($rowSection = mysqli_fetch_assoc($resultSection)) {
            $fctData->appendSectionName($rowSection['sectionName']);
        }

        array_push($arrayOfFctData, $fctData);
    }
    echo json_encode($arrayOfFctData);
}


class fctData {
    public $thrId;
    public $thrFName;
    public $thrMName;
    public $thrLName;
    public $thrDept;
    public $sectionName;

    function appendThrId($data) {
        $this->thrId = $data;
    }

    function appendThrFName($data) {
        $this->thrFName = $data;
    }

    function appendThrMName($data) {
        $this->thrMName = $data;
    }

    function appendThrLName($data) {
        $this->thrLName = $data;
    }

    function appendThrDept($data) {
        $this->thrDept = $data;
    }

    function appendSectionName($data) {
        $this->sectionName = $data;
    }
}