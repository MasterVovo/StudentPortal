<?php
    require_once("../sqlConn/db_connect.php");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $userType = $_POST["userType"];

        $sql = "INSERT INTO `userinfo` (`userType`, `userAddress`, `userEmergCon`) VALUES (?, 2, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userType);

        if($userType != null) {
            if($stmt->execute()){
                header("Location: regPage2.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            header("Location: regPage.php");
            echo "Error: User type cannot be null.";
            exit();
        }

        $stmt->close();
    }
?>