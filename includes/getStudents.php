<?php
    session_start();
    require "../sqlConnection/db_connect.php"; 

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        list($sectionName, $subjectCode) = explode(",", $_POST["section"]);

        $sql = "SELECT subjectName FROM tblsubjects WHERE subjectCode = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $subjectCode);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "
        <tr>
        <th colspan='5' style = 'text-align: center'>Subject: $row[subjectName] ($subjectCode)</th>
        </tr>
        
        <tr>
        <th style = 'text-align: center'>Student ID</th>
        <th style = 'text-align: center'>Student Name</th>
        <th style = 'text-align: center'>Prelims</th>
        <th style = 'text-align: center'>Midterms</th>
        <th style = 'text-align: center'>Finals</th>
        </tr>";

        $sql = "SELECT semesterId from tblsubjects WHERE subjectCode = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $subjectCode);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $semesterId = $row["semesterId"];

        $sql = "SELECT stdinfo.stdID, stdinfo.stdFName, stdinfo.stdMName, stdinfo.stdLName, 
        tblgrades.gradePrelims, tblgrades.gradeMidterms, tblgrades.gradeFinals
        FROM stdinfo 
        LEFT JOIN tblgrades ON stdinfo.stdID = tblgrades.studentId AND tblgrades.subjectCode = ? 
        LEFT JOIN thrassign ON stdinfo.stdSection = thrassign.sectionName
        WHERE stdinfo.stdSection = ? 
        AND thrassign.thrId = ? ORDER BY stdinfo.stdLName";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $subjectCode, $sectionName, $_SESSION["stdID"]);
        $stmt->execute();

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["stdID"] . "</td>";
            echo "<td>" . $row["stdLName"] . ", " . $row["stdFName"] . " " . $row["stdMName"] . "</td>";
            echo "<td><input type='text' name='gradePrelims[" . $row["stdID"] . "]' value='" . $row["gradePrelims"] . "'></td>";
            echo "<td><input type='text' name='gradeMidterms[" . $row["stdID"] . "]' value='" . $row["gradeMidterms"] . "'></td>";
            echo "<td><input type='text' name='gradeFinals[" . $row["stdID"] . "]' value='" . $row["gradeFinals"] . "'></td>";
            echo "<input type='hidden' name='subjectCode[" . $row["stdID"] . "]' value='" . $subjectCode . "'>";
            echo "<input type='hidden' name='semesterId[" . $row["stdID"] . "]' value='" . $semesterId . "'>";
            echo "</tr>";
        }
    }
?>
