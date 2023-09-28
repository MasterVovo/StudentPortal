<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <input type="text" name="stdId" id="stdId" placeholder="KLD ID">
        <input type="password" name="stdPass" id="stdPass" placeholder="Password">
        <input type="submit" value="Login">
    </form>

    <?php
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
                    $errorMessage = "Invalid Password";
                }
            } else {
                //Set error message
                $errorMessage = "User not found";
            }
        }

        //Display the error message
        if (isset($errorMessage)){
            echo "<p>$errorMessage</p>";
        }
    ?>
    
</body>
</html>