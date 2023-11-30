<?php
date_default_timezone_set("Asia/Manila");

session_start(); //Starts the session
require_once "../sqlConnection/db_connect.php"; //Connects to the db

//Server POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Retrieve stdID and stdPass from form
    $stdID = $_POST["stdId"];
    $stdPass = $_POST["stdPass"];

    //Checks the ID's patternn
    if (!preg_match("/^KLD-\d{2}-\d{6}(T|A)?$/", $stdID)) {
        $_SESSION["errorMessage"] = "Invalid ID Format";
        header("Location: ../loginPage.php");
        exit();
    }

    $sql = "SELECT * FROM userinfo WHERE schoolID = ?"; //SQL query
    $stmt = $conn->prepare($sql); //Prepares the query
    $stmt->bind_param("s", $stdID); //Binds parameters
    $stmt->execute(); //Executes the query

    $result = $stmt->get_result(); //Gets the result

    //Compare entered data to correct cred
    if ($result->num_rows === 1) { //Checks if there is a result
        $row = $result->fetch_assoc(); //Fetches the row

        if (password_verify($stdPass, $row["userPass"])) { //Checks if password is correct
            //Sets the session variables
            $_SESSION["stdID"] = $row["schoolID"]; 
            $_SESSION["userType"] = $row["userType"]; 
            $_SESSION["errorMessage"] = "Login Success";

            unset($_SESSION["errorMessage"]); //Clear error message

            if (isset($_POST["rememberUser"])) {
                //Check if checkbox is checked
                //Generate tokens
                list($selector, $validator, $session) = generateSession(); //Generate session
                $hashedValidator = password_hash($validator, PASSWORD_DEFAULT); //Hash the validator

                //Insert into DB
                $sql =
                    "INSERT INTO usersession (sessionSelector, sessionValidator, userId, sessionExpiry) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 3 DAY))";
                
                //Check if there is a session already existing
                if (sessionExists($conn, $row["schoolID"])) {
                    $sql = //Changes query to update
                        "UPDATE usersession SET sessionSelector = ?, sessionValidator = ?, sessionExpiry = DATE_ADD(NOW(), INTERVAL 3 DAY) WHERE userId = ?";
                }
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    "sss",
                    $selector,
                    $hashedValidator,
                    $row["schoolID"]
                );
                $stmt->execute();

                //Set cookies 
                setcookie("rememberUser", $session, time() + 86400 * 3, "/");
            }

            if ($row["userType"] == "student") {
                $sql = "SELECT * FROM stdinfo WHERE stdID = ?"; //SQL query
                $stmt = $conn->prepare($sql); //Prepares the query
                $stmt->bind_param("s", $stdID); //Binds parameters
                $stmt->execute(); //Executes the query

                $result = $stmt->get_result(); //Gets the result
                $row = $result->fetch_assoc(); //Fetches the row

                if ($row["stdGender"] == ""){
                    header("Location: ../registrationForm.php");
                    exit;
                }
            }
            header("Location: ../dashboard.php"); //Redirects to dashboard
            exit();
            
        } else {
            //Set error message
            $_SESSION["errorMessage"] = "Invalid Password";
            header("Location: ../loginPage.php");
            exit();
        }
    } else {
        //Set error message
        $_SESSION["errorMessage"] = "User not found";
        header("Location: ../loginPage.php");
        exit();
    }
}

function generateSession(){ //Generates session
    $selector = bin2hex(random_bytes(16));
    $validator = bin2hex(random_bytes(32));
    return [$selector, $validator, $selector . ":" . $validator];
}

function sessionExists($conn, $userId){ //Checks if session exists
    $sql = "SELECT * FROM usersession WHERE userId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        return true;
    }
    return false;
}