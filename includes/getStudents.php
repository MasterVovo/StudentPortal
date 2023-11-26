<?php
    echo "<tr>
    <th>Student ID</th>
    <th>Student Name</th>
    <th>Prelims</th>
    <th>Midterms</th>
    <th>Finals</th>
    </tr>";

    session_start();
    require "../sqlConnection/db_connect.php"; 

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sectionName = $_POST["section"];
        $sql = "SELECT stdID, stdFName, stdMName, stdLName FROM stdinfo WHERE stdSection = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sectionName);
        $stmt->execute();

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["stdID"] . "</td>";
            echo "<td>" . $row["stdLName"] . ", " . $row["stdFName"] . " " . $row["stdMName"] . "</td>";
            echo "<td><input type='text' name='gradePrelims[" . $row["stdID"] . "]'></td>";
            echo "<td><input type='text' name='gradeMidterms[" . $row["stdID"] . "]'></td>";
            echo "<td><input type='text' name='gradeFinals[" . $row["stdID"] . "]'></td>";
            echo "</tr>";
        }
    }
?>