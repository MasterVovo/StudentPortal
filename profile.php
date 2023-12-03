<?php
// Connect to the database
require "sqlConnection/db_connect.php";
// Set time zone
date_default_timezone_set("Asia/Manila");
// Start the session
session_start();
// Get the user ID from the session
$userId = $_SESSION["stdID"];
// Check if the user type is not set (For auto login)
if (!isset($_SESSION["userType"])) {
    $sql = "SELECT * FROM userinfo WHERE schoolID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $_SESSION["userType"] = $row["userType"]; // Set the user type in the session
}
// Get the user type from the session
$userType = $_SESSION["userType"];

// Get the name of user in the database and store it in a variable
$sql = "SELECT * FROM stdinfo WHERE stdId = ?";
$fname = "stdFName";

if ($userType != "student") {
    $sql = "SELECT * FROM thrinfo WHERE thrId = ?";
    $fname = "thrFName";
    $mname = "thrMName";
    $lname = "thrLName";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$_SESSION["stdFName"] = $name = $row[$fname]; // Set the name in the session
$fullname = $row[$fname] . " " . $row[$mname] . " " . $row[$lname];

$_SESSION["pfp"] = $pfp = "";

if ($userType == "student" && $row["stdImage"] != "") {
    $_SESSION["pfp"] = $pfp = base64_encode($row["stdImage"]); // Set the profile picture in the session
} else {
    $_SESSION["pfp"] = $pfp = "teacher";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KLD Student Portal</title>
  <link rel="shortcut icon" href="images/KLD LOGO.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
  <link rel="stylesheet" href="styles/dashboard.css" />

  <style>
    .container {
      grid-template-columns: 12rem 1fr;
      grid-template-rows: 3rem auto;

      grid-template-areas:
        "sidebar navbar"
        "sidebar content";

      gap: 0 1.8rem;
    }

    aside {
      grid-area: sidebar;
    }

    main {
      grid-area: content;
    }

    main .pfp {
      width: 100%;
    }

    main .ann-container {
      display: flex;

      align-items: center;
      flex-direction: column;
    }

    main .ann-container a {
      translate: 0 -1rem;
      text-decoration: none;
      cursor: default;
    }

    main .ann-container #upload {
      display: none;
    }

    .right-section {
      grid-area: navbar;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <aside>
      <div class="toggle">
        <div class="logo">
          <img src="images/KLD LOGO.png" />
          <h2>KLD Student Portal</h2>
        </div>
        <div class="close" id="close-btn">
          <span class="material-icons-sharp">close</span>
        </div>
      </div>
      <div class="sidebar">
        <a href="#" class="profile-side active" title="Account">
          <span class="material-icons-sharp"> account_circle </span>
          <h3>Account</h3>
        </a>
        <a href="dashboard.php" title="Home">
          <span class="material-icons-sharp"> home </span>
          <h3>Home</h3>
        </a>
        <a href="news.php" title="News">
          <span class="material-icons-sharp"> feed </span>
          <h3>News</h3>
        </a>
        <?php $gradePath =
            $userType == "student" ? "grades.php" : "gradestudents.php"; ?>
        <a href=<?php echo $gradePath; ?> title="Grades">
          <span class="material-icons-sharp"> grade </span>
          <h3>Grades</h3>
        </a>
        <a href="schedule.php" title="Schedules">
          <span class="material-icons-sharp"> schedule </span>
          <h3>Schedule</h3>
        </a>
        <?php if ($userType == "admin") {
            echo "<a href='admin/adminDashboard.php' title='Admin'>
              <span class='material-icons-sharp'> admin_panel_settings </span>
              <h3>Admin</h3>
            </a>";
        } ?>
        <a href="logout.php" title="Logout">
          <span class="material-icons-sharp"> logout </span>
          <h3>Logout</h3>
        </a>
      </div>
    </aside>
    <!-- End of sidebar -->

    <!-- Main content -->
    <main>
      <div class="ann-header">
        <center><h1>Profile</h1></center>
      </div>
      <div class="ann-container">
      <?php
        echo "<form id='profilePictureForm' action='includes/uploadProfilePicture.php' method='post' enctype='multipart/form-data'>";
        if ($pfp == "") {
            echo "<img class='pfp' src='images/profile.png'>";
        } elseif ($pfp == "teacher") {
            echo "<img class='pfp' src='images/KLD LOGO.png'>";
        } else {
            echo "<img class='pfp' src='data:image/jpeg;base64,$pfp'>";
        }
        echo "<input id='upload' type='file' name='profilePicture' accept='.jpeg, .png, .jpg' style='display: none;'/>";
        echo "<center><a href='' id='upload-link'>Change Profile</a></center>";
        echo "<button type='submit' style='display: none;'>Submit</button>"; // Hidden submit button
        echo "</form>";

        echo "<h2>Name: $fullname</h2>";

        if ($userType == "student") {
        } else {
            $sql =
                "SELECT * FROM thrinfo JOIN tbldept ON thrinfo.thrDept = tbldept.deptId WHERE thrId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userId);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            echo "<h2>Department: " . $row["deptName"] . "</h2>";
            echo "<h2>Email: " . $row["thrEmail"] . "</h2>";
        }
        ?>
      </div>
    </main>
    <!-- End of main content -->

    <!-- Right section -->
    <div class="right-section">
      <!-- Navbar -->
      <div class="nav">
        <button id="menu-btn">
          <span class="material-icons-sharp"> menu </span>
        </button>
        <div class="dark-mode">
          <span class="material-icons-sharp active"> light_mode </span>
          <span class="material-icons-sharp"> dark_mode </span>
        </div>

        <div class="profile">
          <div class="info">
            <?php echo "<p>Good day 
                  <b>$name</b>
                </p>"; ?>
            <small class="text-muted">
              <?php echo ucfirst($userType); ?>
            </small>
          </div>
          <div class="profile-photo">
            <img src=
            <?php if ($pfp == "") {
                echo "'images/profile.png'";
            } elseif ($pfp == "teacher") {
                echo "'images/KLD LOGO.png'";
            } else {
                echo "'data:image/jpeg;base64,$pfp'";
            } ?> 
            />
          </div>
        </div>
      </div>
      <!-- End of navbar -->
    </div>
    <!-- End of right section -->
  </div>
  <script src="scripts/dashboard.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    {
      // Get the current date
      var currentDate = new Date();

      // Format the date as needed
      var options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      };
      var formattedDate = currentDate.toLocaleDateString('en-US', options);

      // Display the current date in the element with id "currentDate"
      document.getElementById('currentDate').textContent = formattedDate;
    }

  </script>
  <script>
    $(function(){
      $("#upload-link").on('click', function(e){
        e.preventDefault();
        $("#upload:hidden").trigger('click');
      });
    });
  </script>
</body>

</html>