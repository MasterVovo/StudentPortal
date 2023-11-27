<?php
date_default_timezone_set("Asia/Manila"); //Sets the timezone
require_once "sqlConnection/db_connect.php"; //Connects to the db
session_start(); //Starts the session

//Check if the cookie exists
if (isset($_COOKIE["rememberUser"])) {
    //Split the cookie into selector and validator
    list($selector, $validator) = explode(":", $_COOKIE["rememberUser"]); 

    //Retrieve the session from the DB
    $sql = "SELECT * FROM usersession WHERE sessionSelector = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selector);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) { //Check if there is a session
        $row = $result->fetch_assoc(); //Gets the row

        //Check if the session is still valid
        if (strtotime($row["sessionExpiry"]) >= time()) {
            //Check if the validator matches
            if (password_verify($validator, $row["sessionValidator"])) {
                
                $_SESSION['stdID'] = $row["userId"]; //Sets the session
                
                list($selector, $validator, $session) = generateSession(); //Generate session
                $hashedValidator = password_hash($validator, PASSWORD_DEFAULT); //Hash the validator

                //Updates the session
                $sql = "UPDATE usersession SET sessionSelector = ?, sessionValidator = ?, sessionExpiry = DATE_ADD(NOW(), INTERVAL 3 DAY) WHERE userId = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    "sss",
                    $selector,
                    $hashedValidator,
                    $row["userId"]
                );
                $stmt->execute(); //Executes the query

                setcookie("rememberUser", $session, time() + (86400 * 3), "/"); //Resets the cookies for another 3 days

                header("Location: dashboard.php"); //Redirect to dashboard
                exit;
            }
        }
    }
}


function generateSession() { // Generates session
    $selector = bin2hex(random_bytes(16));
    $validator = bin2hex(random_bytes(32));
    return [$selector, $validator, $selector . ':' . $validator];
}