<html>
<head>
    <title>Student Registration</title>
</head>
<body>
    <h2>Personal Information</h2>
    <form action="regPage3.php" method="POST">
        <input type="text" name="kldID" required>KLD ID
        <input type="text" name="fName" required>First Name
        <input type="text" name="mName" required>Middle Name
        <input type="text" name="lName" required>Last Name

        <button type="submit" name="submit" formaction="regUser.php">Next</button>
    </form>
</body>
</html>