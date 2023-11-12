<?php
require "sqlConnection/db_connect.php";
// Connect to the database
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KLD Student Portal</title>
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
          <a href="dashboard.php" class="profile-side">
            <span class="material-icons-sharp"> account_circle </span>
            <h3>Account</h3>
          </a>
          <a href="dashboard.php">
            <span class="material-icons-sharp"> home </span>
            <h3>Home</h3>
          </a>
          <a href="#" class="active">
            <span class="material-icons-sharp"> feed </span>
            <h3>News</h3>
          </a>
          <a href="#">
            <span class="material-icons-sharp"> grade </span>
            <h3>Grades</h3>
          </a>
          <a href="#">
            <span class="material-icons-sharp"> schedule </span>
            <h3>Schedule</h3>
          </a>
          <a href="logout.html">
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

                $image = base64_encode($imageData); // Encode the image

                $currentTime = time(); // Get the current time
                $timeDifference = abs($currentTime - $uploadTime); // Calculate the time difference

                $elapsedTime = formatTimeElapsed($timeDifference); // Format the time

                echo "<div class='ann-container'>
                <div class='announcement'>
                <img src='data:image/jpeg;base64,$image'/>
                <h2>$title</h2>
                <p>$elapsedTime ago</p>
                <h3>$content</h3><small>Read More</small>
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
              <p>Good day <b>Kolehiyan</b></p>
              <small class="text-muted">Student - BSIS201</small>
            </div>
            <div class="profile-photo">
              <img src="images/KLD LOGO.png" />
            </div>
          </div>
        </div>
        <!-- End of navbar -->
      <!-- End of right section -->
    </div>
      <script src="scripts/dashboard.js"></script>
  </body>

</html>