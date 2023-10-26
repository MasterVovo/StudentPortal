<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$headers = ["First Name: ", "Middle Name: ", "Last Name: ", "Course: ", "Email: "];

$filePath = $_FILES['excelFile']['tmp_name'];
// Load the Excel file
$spreadsheet = IOFactory::load($filePath);

// Select the first worksheet in the Excel file
$worksheet = $spreadsheet->getActiveSheet();

// Loop through rows and columns to output cell values
echo "<table>
        <tr>
            <!--<td>Student ID</td>-->
            <td>First Name</td>
            <td>Middle Name</td>
            <td>Last Name</td>
            <td>Course</td>
            <td>Email</td>
        </tr>";

$counter = 1;
foreach ($worksheet->getRowIterator() as $row) {
    echo "<tr>";
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(FALSE); // Loop through all cells, even empty ones
    $firstCell = TRUE;

    // echo "<td>KLD-22-" . $counter . "</td>";
    $counter++;

    foreach ($cellIterator as $cell) {
        if ($firstCell && empty($cell->getValue())) {
            break;
        }
        // Output cell value
        echo "<td>" . $cell->getValue() . "</td>";
        $firstCell = FALSE;
    }
    echo "</tr>";
}
echo "</table>";
?>

<style>
    table {
        margin-top: 1rem;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>