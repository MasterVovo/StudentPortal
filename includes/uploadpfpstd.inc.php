<?php
session_start();
require "../sqlConnection/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["stdID"];
    // Check if the file is an actual image
    if (getimagesize($_FILES["profilePicture"]["tmp_name"])) {
        $imageData = file_get_contents($_FILES["profilePicture"]["tmp_name"]);

        $sql = "UPDATE stdinfo SET stdImage = ? WHERE stdId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $imageData, $userId);

        // Upload file to the server
        if ($stmt->execute()) {
            $message = "Profile picture uploaded successfully!";
        } else {
            $message = "Error uploading file.";
        }
    } else {
        $message = "Invalid file type. Only valid images are allowed.";
    }
} else {
    $message = "Invalid request.";
}

// Close the database connection
$conn->close();

$_SESSION["message"] = $message;
header("Location: ../profile.php");
exit();
?>
