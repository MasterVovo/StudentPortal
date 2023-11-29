<?php
require "../../sqlConnection/db_connect.php";

if (isset($_POST['functionName'])) {
    $function = $_POST['functionName'];
    
    switch($function) {
        case 'fetchThrData':
            echo fetchThrData();
            break;
        case 'fetchSections':
            echo fetchSections();
            break;
    }
}

function fetchThrData() {
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

    global $conn;
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
        return json_encode($arrayOfFctData);
    }
    
    
    
}

function fetchSections() {
    class sectionList {
        public $value;
        public $text;

        function addSection($sectionName) {
            $this->value = $sectionName;
            $this->text = $sectionName;
        }
    }

    global $conn;
    $sql = "SELECT `sectionName` FROM tblsections";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $arrayOfSectionList = array();
        while ($section = mysqli_fetch_assoc($result)) {
            $sectionList = new sectionList();
            $sectionList->addSection($section['sectionName']);
            array_push($arrayOfSectionList, $sectionList);
        }
        return json_encode($arrayOfSectionList);
    } else {
        return 'No sections found';
    }
}