<?php require "sqlConnection/db_connect.php"; // Connect to the database 
session_start();
// Get the user ID from the session
$userId = $_SESSION["stdID"];
// Get the user type from the session
$userType = $_SESSION["userType"];
// Get the name of user
$name = $_SESSION["stdFName"];
// Get the profile picture
$pfp = $_SESSION["pfp"];
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
    <link rel="stylesheet" href="styles/news.css">
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
          <a href="profile.php" class="profile-side">
            <span class="material-icons-sharp"> account_circle </span>
            <h3>Account</h3>
          </a>
          <a href="dashboard.php">
            <span class="material-icons-sharp"> home </span>
            <h3>Home</h3>
          </a>
          <a href="" class="active">
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
          <a href="schedule.php">
            <span class="material-icons-sharp"> schedule </span>
            <h3>Schedule</h3>
          </a>
          <?php
            if ($userType == "admin") {
              echo 
              "<a href='admin/adminDashboard.php'>
                <span class='material-icons-sharp'> admin_panel_settings </span>
                <h3>Admin</h3>
              </a>";
            }
          ?>
          <a href="logout.php">
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
        <div class="ann-grid">
          <?php
          date_default_timezone_set("Asia/Manila"); // Set the timezone

          $sql =
            "SELECT * FROM `tblannouncements` ORDER BY `announcementTime` DESC LIMIT 4"; // Get the latest announcement
          $result = mysqli_query($conn, $sql); // Execute the query

          while($row = mysqli_fetch_assoc($result)) {
            // Loop through the results
            $title = $row["announcementTitle"]; // Get the title
            $content = $row["announcementText"]; // Get the content
            $imageData = $row["announcementImage"]; // Get the image data
            $uploadTime = strtotime($row["announcementTime"]); // Get the upload time
            $announcementId = $row["announcementId"]; // Unique identifier for each announcement
            $shortContent = substr($content, 0, 300); // Limit content to 100 characters
            $fullContent = nl2br(htmlspecialchars($content)); // Store full content with HTML line breaks and special character encoding


            $image = base64_encode($imageData); // Encode the image

            $currentTime = time(); // Get the current time
            $timeDifference = abs($currentTime - $uploadTime); // Calculate the time difference

            $elapsedTime = formatTimeElapsed($timeDifference); // Format the time

            echo "<div class='ann-container'>
            <div class='announcement' id='announcement-$announcementId'>
                <img src='data:image/jpeg;base64,$image'/>
                <center><h2>$title</h2></center>
                <p>$elapsedTime ago</p>
                <div class='content-short'>$shortContent...</div>
                <div class='content-full' style='display: none;'>$fullContent</div>
                <medium class='read-more' onclick='toggleContent($announcementId)'>Read More</medium>
            </div>
        </div>";
          }
          mysqli_close($conn);

          function formatTimeElapsed($time) //Formats the given time elapsed into a human-readable format.
          {
            $seconds = $time;
            $minutes = floor($seconds / 60);
            $hours = floor($seconds / 3600);
            $days = floor($seconds / 86400);

            if ($seconds < 60) { // If the time elapsed is less than a minute
              return $seconds . " sec" . ($seconds == 1 ? "" : "s");
            } elseif ($minutes < 60) { // If the time elapsed is less than an hour
              return $minutes . " min" . ($minutes == 1 ? "" : "s");
            } elseif ($hours < 24) { // If the time elapsed is less than a day
              return $hours . " hour" . ($hours == 1 ? "" : "s");
            } else { // If the time elapsed is more than a day
              return $days . " day" . ($days == 1 ? "" : "s");
            }
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
      <!-- End of right section -->
    </div>
      <script src="scripts/dashboard.js"></script>

      <!-- SCRIPT FOR SEE MORE PAGE -->
  <script>
    function toggleContent(announcementId) {
        var shortContent = document.getElementById(`announcement-${announcementId}`).getElementsByClassName('content-short')[0];
        var fullContent = document.getElementById(`announcement-${announcementId}`).getElementsByClassName('content-full')[0];

        if (shortContent.style.display === 'none') {
            shortContent.style.display = 'block';
            fullContent.style.display = 'none';
        } else {
            shortContent.style.display = 'none';
            fullContent.style.display = 'block';
        }
    }
</script>
  </body>

</html>