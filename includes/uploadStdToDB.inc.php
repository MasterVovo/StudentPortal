<?php
require "../vendor/autoload.php";
require "../sqlConnection/db_connect.php";

$sql = "SELECT COUNT(stdID) as row_count FROM stdinfo";
$result = $conn->query($sql);
$result->num_rows;

// Fetch the result as an associative array
$row = $result->fetch_assoc();

// Get the row count
$numOfRows = $row["row_count"] + 1;

if (isset($_FILES["excelFile"])) {
    $filePath = $_FILES["excelFile"]["tmp_name"]; // get uploaded file
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath); // load file

    $worksheet = $spreadsheet->getActiveSheet(); // Select the first worksheet in the Excel file

    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator(); // Get cell iterator
        $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even empty ones

        $stdID =
            "KLD-" .
            date("y") .
            "-" .
            str_pad($numOfRows, 6, "0", STR_PAD_LEFT);

        $data = [];
        foreach ($cellIterator as $cell) {
            // Get value of each cell
            $data[] = $cell->getValue(); // Add cell value to data array
        }

        // Prepare an SQL statement
        $stmt = $conn->prepare(
            "INSERT INTO stdinfo (stdID, stdFName, stdMName, stdLName, stdCourse, stdEmail) VALUES (?, ?, ?, ?, ?, ?)"
        );

        // Bind parameters
        $stmt->bind_param(
            "ssssss",
            $stdID,
            $data[0],
            $data[1],
            $data[2],
            $data[3],
            $data[4]
        );

        // Execute the statement
        $stmt->execute();

        $numOfRows++;
    }

    // Close the database connection
    $conn->close();

    echo "Data inserted successfully!";
} else {
    echo "No file uploaded!";
}
