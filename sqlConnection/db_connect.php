<?php //For connecting to the database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "webhost"; 
    // $database = "sample_portal"; //For testing only
    // $database = "student_portal";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>