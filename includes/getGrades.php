<?php // TODO: Show grades
require "sqlConnection/db_connect.php"; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semesterId = $_POST["semester"];
    $userId = $_SESSION["stdID"];
    $sql = "SELECT subjectCode, gradePrelims, gradeMidterms, gradeFinals FROM tblgrades WHERE studentId = ? AND semesterId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $userId, $semesterId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["subjectName"] . "</td>";
        echo "<td>" . $row["gradePrelims"] . "</td>";
        echo "<td>" . $row["gradeMidterms"] . "</td>";
        echo "<td>" . $row["gradeFinals"] . "</td>";
        echo "</tr>";
    }
}
?>