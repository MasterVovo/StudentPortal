<?php //TODO: NOT YET WORKING POTAENA
session_start();
require "sqlConnection/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["stdID"];

    // Specify the target directory where the file will be stored
    $targetDir = "../images/";

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

            echo "Profile picture uploaded successfully!";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Only valid images are allowed.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
