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

if($userType != "student") {
  $sql = "SELECT * FROM thrinfo WHERE thrId = ?";
  $fname = "thrFName";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$_SESSION["stdFName"] = $name = $row[$fname]; // Set the name in the session

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
        <a href="profile.php" class="profile-side" title="Account">
          <span class="material-icons-sharp"> account_circle </span>
          <h3>Account</h3>
        </a>
        <a href="#" class="active" title="Home">
          <span class="material-icons-sharp"> home </span>
          <h3>Home</h3>
        </a>
        <a href="news.php" title="News">
          <span class="material-icons-sharp"> feed </span>
          <h3>News</h3>
        </a>
        <?php
          $gradePath = ($userType == "student") ? "grades.php" : "gradestudents.php";
        ?>
        <a href=<?php echo $gradePath;?> title="Grades">
          <span class="material-icons-sharp"> grade </span>
          <h3>Grades</h3>
        </a>
        <a href="schedule.php" title="Schedules">
          <span class="material-icons-sharp"> schedule </span>
          <h3>Schedule</h3>
        </a>
        <?php
          if ($userType == "admin") {
            echo 
            "<a href='admin/adminDashboard.php' title='Admin'>
              <span class='material-icons-sharp'> admin_panel_settings </span>
              <h3>Admin</h3>
            </a>";
          }
        ?>
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
        <h1>Latest Announcement</h1>
      </div>
      <div class="ann-container">
        <div class="announcement">
          <?php
          $sql = "SELECT * FROM `tblannouncements` ORDER BY `announcementTime` DESC LIMIT 1"; // Get the latest announcement
          $result = mysqli_query($conn, $sql); // Execute the query

          if($result->num_rows === 0){ // Check if there is no announcement
              echo "<h2>No announcement yet</h2>";
          } else {
            $row = mysqli_fetch_assoc($result); // Get the row
            $title = $row["announcementTitle"]; // Get the title
            $content = $row["announcementText"]; // Get the content

            $imageData = $row["announcementImage"]; // Get the image data
            $image = base64_encode($imageData); // Encode the image

            $uploadTime = strtotime($row["announcementTime"]); // Get the upload time
            $currentTime = time(); // Get the current time
            $timeDifference = abs($currentTime - $uploadTime); // Calculate the time difference
            $elapsedTime = formatTimeElapsed($timeDifference); // Format the time

            echo "<img src='data:image/jpeg;base64,$image'/>
                <center><h2>$title</h2></center>
                <p>$elapsedTime ago</p>
                <h3>$content</h3><small>Read More</small>"; // Display the announcement
          }

          mysqli_close($conn); // Close the connection

          function formatTimeElapsed($time)
          {
              // Function to format time
              $seconds = $time;
              $minutes = floor($seconds / 60);
              $hours = floor($seconds / 3600);
              $days = floor($seconds / 86400);

              if ($seconds < 60) {
                  return $seconds . " sec" . ($seconds == 1 ? "" : "s");
              } elseif ($minutes < 60) {
                  return $minutes . " min" . ($minutes == 1 ? "" : "s");
              } elseif ($hours < 24) {
                  return $hours . " hour" . ($hours == 1 ? "" : "s");
              } else {
                  return $days . " day" . ($days == 1 ? "" : "s");
              }
          }
          ?>
        </div>
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
            <?php
                echo "<p>Good day 
                  <b>$name</b>
                </p>"; ?>
            <small class="text-muted">
              <?php
                echo ucfirst($userType);
              ?>
            </small>
          </div>
          <div class="profile-photo">
            <a href="profile.php">
            <img src=
            <?php 
              if ($pfp == "") {
                echo "'images/profile.png'";
              } else if ($pfp == "teacher") {
                if(isset($_SESSION["imagePath"])) {
                  echo "'images/" . $_SESSION["imagePath"] . "'";
                } else {
                  echo "'images/KLD LOGO.png'";
                }
              } else {
                echo "'data:image/jpeg;base64,$pfp'";
              }
              ?> 
            />
            </a>
          </div>
        </div>
      </div>
      <!-- End of navbar -->

      <!-- Schedule list -->
      <div class="schedule">
        <div class="schedule-header">
          <h2>Schedule for Today</h2><small class="text-muted" id="currentDate"></small>
          <a href="schedule.php">
            <span class="material-icons-sharp"> add </span>
          </a>
        </div>

        <div class="schedule-list">
          <div class="icon">
            <span class="material-icons-sharp"> code </span>
          </div>
          <div class="sched-title">
            <div class="info">
              <h3>GEC1000 - Web Development</h3>
              <small class="text_muted"> 08:00 AM - 12:00 PM </small>
            </div>
          </div>
        </div>

        <div class="schedule-list">
          <div class="icon">
            <span class="material-icons-sharp"> edit </span>
          </div>
          <div class="sched-title">
            <div class="info">
              <h3>GEC1000 - IT Infrastructure</h3>
              <small class="text_muted"> 08:00 AM - 12:00 PM </small>
            </div>
          </div>
        </div>

        <div class="schedule-list">
          <div class="icon">
            <span class="material-icons-sharp"> edit </span>
          </div>
          <div class="sched-title">
            <div class="info">
              <h3>GEC1000 - Data Structure and Algorithm</h3>
              <small class="text_muted"> 08:00 AM - 12:00 PM </small>
            </div>
          </div>
        </div>
      </div>
      <!-- End of schedule list -->

      <!-- Grades list -->
      <?php
        if ($userType == "student") {
          echo "<div class='grades'>
          <div class='grades-header'>
            <h2>Latest Grades</h2>
            <a href='grades.php'>
              <h4>View all</h4>
            </a>
          </div>
  
          <div class='grades-list'>
            <div class='icon'>
              <span class='material-icons-sharp'> code </span>
            </div>
            <div class='subject-title'>
              <div class='info'>
                <h3>GEC1000 - Web Development</h3>
              </div>
              <div class='info'>
                <h2>1.25</h2>
              </div>
            </div>
          </div>
  
          <div class='grades-list'>
            <div class='icon'>
              <span class='material-icons-sharp'> edit </span>
            </div>
            <div class='subject-title'>
              <div class='info'>
                <h3>GEC1000 - IT Infrastructure</h3>
              </div>
              <div class='info'>
                <h2>1.25</h2>
              </div>
            </div>
          </div>
        </div>";
        }
      ?>
      <!-- End of grades list -->
    </div>
    <!-- End of right section -->
  </div>
  <script src="scripts/dashboard.js"></script>
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
</body>

</html>