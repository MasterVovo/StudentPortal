<?php
session_start();
require "../sqlConnection/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["stdID"];

    // Specify the target directory where the file will be stored
    $targetDir = "../images/";

    // Get the old profile picture
    $sql = "SELECT thrImage FROM thrinfo WHERE thrId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $oldProfilePic = $targetDir . $row['thrImage'];

    // Delete the old profile picture if it exists
    if (file_exists($oldProfilePic)) {
        unlink($oldProfilePic);
    }

    // Specify a unique name for the uploaded file (e.g., user ID + random string + timestamp)
    $fileExtension = pathinfo($_FILES["profilePicture"]["name"], PATHINFO_EXTENSION);
    $fileName = $userId . '_' . bin2hex(random_bytes(8)) . '_' . time() . '.' . $fileExtension;

    // Specify the target path
    $targetFilePath = $targetDir . $fileName;

    // Check if the file is an actual image
    if (getimagesize($_FILES["profilePicture"]["tmp_name"])) {
        // Upload file to the server
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
            // Update the user's profile picture in the database
            $sql = "UPDATE thrinfo SET thrImage = ? WHERE thrId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $fileName, $userId);
            $stmt->execute();

            // Close statement
            $stmt->close();

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
