<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student</title>
</head>

<body>
    <form action="#" method="POST" enctype="multipart/form-data">
        <input type="file" name="excelFile" id="excelFile" accept=".xls,.xlsx">
        <button type="submit" name="uploadBtn" id="uploadBtn">Upload File</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uploadedFile = $_FILES["excelFile"];

        if ($uploadedFile["error"] === UPLOAD_ERR_OK) {
            $allowedExtensions = ["xlsx", "xls"];
            $extension = pathinfo($uploadedFile["name"], PATHINFO_EXTENSION);

            if (in_array(strtolower($extension), $allowedExtensions)) {
                $filePath = $uploadedFile["tmp_name"];
                require_once("includes/stdreg.inc.php");
            } else {
                echo "Invalid file format. Please upload an Excel file.";
            }
        } else {
            echo "Error uploading file. Try again";
        }
    }
    ?>
</body>

</html>