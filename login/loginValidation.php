<?php
    session_start(); //Starts the session
    require_once("../sqlConn/db_connect.php"); //Connects to the db

    //Server POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Retrieve stdID and stdPass from form
        $stdID = $_POST["stdId"];
        $stdPass = $_POST["stdPass"];

        $sql = "SELECT * FROM userinfo WHERE schoolID = ?"; //SQL query
        $stmt = $conn->prepare($sql); //Prepares the query
        $stmt->bind_param("s", $stdID); //Binds parameters
        $stmt->execute(); //Executes the query

        $result = $stmt->get_result(); //Gets the result

        //Compare entered data to correct cred
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc(); //Fetches the row

            if ($stdPass == $row["userPass"]) {
                //Redirect to dashboard page
                header("Location: ../dashboard/dashboard.php");
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
