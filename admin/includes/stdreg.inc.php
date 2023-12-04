<?php
require "../../vendor/autoload.php";
require "../../sqlConnection/db_connect.php";

$sql = " SELECT * FROM stdinfo ORDER BY dateEnrolled DESC LIMIT 1";
$result = $conn->query($sql);
$result->num_rows;
$row = $result->fetch_assoc();

$sql = " SELECT * FROM archived_stdinfo ORDER BY dateEnrolled DESC LIMIT 1";
$result = $conn->query($sql);
$result->num_rows;
$rowArchived = $result->fetch_assoc();

// Close the database connection
$conn->close();

use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = $_FILES["excelFile"]["tmp_name"]; // get uploaded file
$spreadsheet = IOFactory::load($filePath); // load file

$worksheet = $spreadsheet->getActiveSheet(); // Select the first worksheet in the Excel file

// echo "<div class='tblContainer'>
//         <p>Student List</p>
//         <button id='uploadToDB'>Save</button>
//         <div class='stdTable'>
//             <table>
//                 <tr>
//                     <th>Student ID</th>
//                     <th>First Name</th>
//                     <th>Middle Name</th>
//                     <th>Last Name</th>
//                     <th>Course</th>
//                     <th>Email</th>
//                 </tr>";

// Determine which have the highest stdId number
preg_match('/\d+$/', $row['stdID'], $matches);
$value = intval($matches[0]);
preg_match('/\d+$/', $rowArchived['stdID'], $matches);
$archivedValue = intval($matches[0]);

$counter = ($value > $archivedValue) ? $value : $archivedValue;
$counter += 1;

// $counter = $row["row_count"] + 1;

class stdData {
    public $stdId;
    public $stdFName;
    public $stdMName;
    public $stdLName;
    public $stdCourse;
    public $stdEmail;

    function append($data) {
        if (is_null($this->stdFName)) {
            $this->stdFName = $data;
        } else if (is_null($this->stdMName)) {
            $this->stdMName = $data;
        } else if (is_null($this->stdLName)) {
            $this->stdLName = $data;
        } else if (is_null($this->stdCourse)) {
            $this->stdCourse = $data;
        } else if (is_null($this->stdEmail)) {
            $this->stdEmail = $data;
        }
    }
}

$arrayOfInfo = array();

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

    $stdData = new stdData();

    // echo "<tr>";

    $stdData->stdID = 'KLD-' . date('y') . '-' . str_pad($counter, 6, "0", STR_PAD_LEFT);

    // echo "<td>KLD-" .
    //     date("y") .
    //     "-" .
    //     str_pad($counter, 6, "0", STR_PAD_LEFT) .
    //     "</td>";
    $counter++;

    foreach ($cellIterator as $cell) {
        // Get value of each cell
        // echo "<td>" . $cell->getValue() . "</td>"; // Output cell value
        $stdData->append($cell->getValue());
    }
    array_push($arrayOfInfo, $stdData);
    // echo "</tr>";
}

echo json_encode($arrayOfInfo);
// echo "</table></div></div>";

// $output = ob_get_clean();

// echo $output;

// echo "<script>
//         $(document).ready(function() {
//             $('#uploadToDB').click(function(e) {
//                 e.preventDefault();

//                 // Show the loader
//                 document.getElementById('loaderContainer').style.display = 'flex';

//                 var formData = new FormData();
//                 formData.append('excelFile', $('#excelFile')[0].files[0]);

//                 $.ajax({
//                     url: 'includes/uploadStdToDB.inc.php',
//                     type: 'POST',
//                     data: formData,
//                     processData: false,  // tell jQuery not to process the data
//                     contentType: false,  // tell jQuery not to set contentType
//                     success: function(data) {
//                         // Hide the loader
//                         document.getElementById('loaderContainer').style.display = 'none';

//                         // Show a success message
//                         alert('Data inserted successfully!');
//                     }
//                 });
//             });
//         });
//     </script>";



