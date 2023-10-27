<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = $_FILES['excelFile']['tmp_name']; // get uploaded file
$spreadsheet = IOFactory::load($filePath); // load file

$worksheet = $spreadsheet->getActiveSheet(); // Select the first worksheet in the Excel file


echo "<div class='tblContainer'>
        <p>Student List</p>
        <form action='includes/uploadStdToDB.inc.php' method='POST'>
            <button type='submit' name='uploadToDB' id='uploadToDB'>Save</button>
        </form>
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

$counter = 1;

// Loop through rows and columns to output cell values
foreach ($worksheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator(); // Get cell iterator
    $cellIterator->setIterateOnlyExistingCells(FALSE); // Loop through all cells, even empty ones
    $firstCell = TRUE;

    if ($firstCell && empty($cellIterator->current()->getValue())) { // Skip empty cells
        continue;
    }

    $firstCell = FALSE;

    echo "<tr>";
    echo "<td>KLD-22-" . $counter . "</td>";
    $counter++;

    foreach ($cellIterator as $cell) { // Get value of each cell
        echo "<td>" . $cell->getValue() . "</td>"; // Output cell value
    }
    echo "</tr>";
}
echo "</table></div></div>";
?>