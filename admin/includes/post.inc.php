<?php
require_once "../../sqlConnection/db_connect.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Check if the image was uploaded without errors
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        // The image was uploaded without errors
        // Read the contents of the uploaded file
        $imageData = file_get_contents($_FILES['image']['tmp_name']);

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO tblannouncements (`announcementTitle`, `announcementText`, `announcementImage`) VALUES (?, ?, ?)");
        // Bind the parameters
        $stmt->bind_param("sss", $title, $content, $imageData);
        // Execute the statement
        $stmt->execute();
        exit("success");
    } 
    exit("error");
}

?>