<html>
<head>
    <title>Student Registration</title>
</head>
<body>
    <h2>User Type</h2>
    <form action="regPage2.php" method="POST">
        <input type="radio" name="userType" value="student">Student
        <input type="radio" name="userType" value="faculty">Faculty
        <input type="radio" name="userType" value="staff">Staff

        <button type="submit" name="submit" formaction="regUser.php">Next</button>
    </form>
</body>
</html>