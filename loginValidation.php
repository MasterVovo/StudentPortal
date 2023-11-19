<?php
    session_start();
    require_once("db_connect.php");

    //Server POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Retrieve stdID and stdPass from form
        $stdID = $_POST["stdId"];
        $stdPass = $_POST["stdPass"];

        $sql = "SELECT * FROM userinfo WHERE kldID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $stdID);

        $stmt->execute();

        $result = $stmt->get_result();

        //Compare entered data to correct cred
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if ($stdPass == $row["pass"]) {
                //Redirect to dashboard page
                header("Location: dashboard.html");
                exit; //Terminate
            } else {
                //Set error message
                $_SESSION['errorMessage'] = "Invalid Password";
                header("Location: loginPage.php");
                exit;
            }
        } else {
            //Set error message
            $_SESSION['errorMessage'] = "User not found";
            header("Location: loginPage.php");
            exit;
        }
    }
?>