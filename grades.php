<?php
require "sqlConnection/db_connect.php";
// Connect to the database
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
    <link rel="stylesheet" href="styles/grades.css" />
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
          <a href="news.php">
            <span class="material-icons-sharp"> feed </span>
            <h3>News</h3>
          </a>
          <a href="grades.php" class="active">
            <span class="material-icons-sharp"> grade </span>
            <h3>Grades</h3>
          </a>
          <a href="schedule.php">
            <span class="material-icons-sharp"> schedule </span>
            <h3>Schedule</h3>
          </a>
          <?php if ($userType == "admin") {
              echo "<a href='admin/adminDashboard.php'>
                <span class='material-icons-sharp'> admin_panel_settings </span>
                <h3>Admin</h3>
              </a>";
          } ?>
          <a href="logout.php">
            <span class="material-icons-sharp"> logout </span>
            <h3>Logout</h3>
          </a>
        </div>
      </aside>
      <!-- End of sidebar -->
   
    <!-- Main content -->
    <main>
      <div class="ann-container">
        <div class="announcement">
          <h2>Grade Table</h2>

          <form id="semesterForm"> <!-- Dropdown for selecting semester -->
            <select name="semester" id="semesterSelect">
              <option value="0" selected disabled>Pick Period</option>
              <?php
                $sql = "SELECT semesterId, semesterPeriod FROM tblsemester";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<option value=\"" . $row["semesterId"] . "\">" . $row["semesterPeriod"] . "</option>";
                }
              ?>
            </select>
          </form>

          <table id="gradesTable">
          </table>
        </div>
      </div>
    </main><!-- End of main content -->

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
                echo "'images/KLD LOGO.png'";
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
    </div>
  
      
    <script src="scripts/dashboard.js"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> <!-- AJAX -->
      <script>
        $(document).ready(function(){
          $("#semesterSelect").change(function(){
            $.ajax({
              url: 'includes/getGrades.php',
              type: 'post',
              data: $('#semesterForm').serialize(),
              success: function(data){
                // Replace the grades table with the response
                $('#gradesTable').html(data);
              }
            });
          });
        });
      </script>
  </body>

</html>