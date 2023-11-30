<?php
echo "<tr>
    <th>Subject Code</th>
    <th>Subject Name</th>
    <th>Prelims</th>
    <th>Midterms</th>
    <th>Finals</th>
</tr>";

session_start();
require "../sqlConnection/db_connect.php"; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semesterId = $_POST["semester"];
    $userId = $_SESSION["stdID"];
    $sql = "SELECT tblsubjects.subjectName, tblgrades.subjectCode, tblgrades.gradePrelims, tblgrades.gradeMidterms, tblgrades.gradeFinals 
        FROM tblgrades JOIN tblsubjects ON tblgrades.subjectCode = tblsubjects.subjectCode 
        WHERE tblgrades.studentId = ? AND tblgrades.semesterId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $userId, $semesterId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["subjectCode"] . "</td>";
        echo "<td>" . $row["subjectName"] . "</td>";
        echo "<td>" . $row["gradePrelims"] . "</td>";
        echo "<td>" . $row["gradeMidterms"] . "</td>";
        echo "<td>" . $row["gradeFinals"] . "</td>";
        echo "</tr>";
    }
}
?>