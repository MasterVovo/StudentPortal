<?php
require "../../sqlConnection/db_connect.php";

$sql = "SELECT * FROM archived_thrinfo";
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
        $fctData->appendThrEmail($row['thrEmail']);
        $fctData->appendThrDept($row['thrDept']);
        $fctData->appendExpiration($row['expiration']);

        array_push($arrayOfFctData, $fctData);
    }
    echo json_encode($arrayOfFctData);
}

class fctData {
    public $thrId;
    public $thrFName;
    public $thrMName;
    public $thrLName;
    public $thrEmail;
    public $thrDept;
    public $expiration;

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

    function appendThrEmail($data) {
        $this->thrEmail = $data;
    }

    function appendThrDept($data) {
        $this->thrDept = $data;
    }

    function appendExpiration($data) {
        $this->expiration = $data;
    }
}