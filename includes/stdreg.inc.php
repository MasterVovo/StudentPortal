<?php
require "../vendor/autoload.php";
require "../sqlConnection/db_connect.php";

$sql = "SELECT COUNT(*) as row_count FROM stdinfo";
$result = $conn->query($sql);
$result->num_rows;
$row = $result->fetch_assoc();

// Close the database connection
$conn->close();

use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = $_FILES["excelFile"]["tmp_name"]; // get uploaded file
$spreadsheet = IOFactory::load($filePath); // load file

$worksheet = $spreadsheet->getActiveSheet(); // Select the first worksheet in the Excel file

echo "<div class='tblContainer'>
        <p>Student List</p>
        <button id='uploadToDB'>Save</button>
        <div class='stdTable'>
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Course</th>
                    <th>Email</th>
                </tr>";

$counter = $row["row_count"] + 1;

// Loop through rows and columns to output cell values
foreach ($worksheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator(); // Get cell iterator
    $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even empty ones
    $firstCell = true;

    if ($firstCell && empty($cellIterator->current()->getValue())) {
        // Skip empty cells
        continue;
    }

    $firstCell = false;

    echo "<tr>";

    echo "<td>KLD-" .
        date("y") .
        "-" .
        str_pad($counter, 6, "0", STR_PAD_LEFT) .
        "</td>";
    $counter++;

    foreach ($cellIterator as $cell) {
        // Get value of each cell
        echo "<td>" . $cell->getValue() . "</td>"; // Output cell value
    }
    echo "</tr>";
}
echo "</table></div></div>";

$output = ob_get_clean();

echo $output;

echo "<script>
        $(document).ready(function() {
            $('#uploadToDB').click(function(e) {
                e.preventDefault();

                // Show the loader
                document.getElementById('loaderContainer').style.display = 'flex';

                var formData = new FormData();
                formData.append('excelFile', $('#excelFile')[0].files[0]);

                $.ajax({
                    url: 'includes/uploadStdToDB.inc.php',
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function(data) {
                        // Hide the loader
                        document.getElementById('loaderContainer').style.display = 'none';

                        // Show a success message
                        alert('Data inserted successfully!');
                    }
                });
            });
        });
    </script>";
