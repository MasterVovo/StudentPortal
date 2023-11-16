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
          <a href="#" class="profile-side">
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
          <a href="logout.html">
            <span class="material-icons-sharp"> logout </span>
            <h3>Logout</h3>
          </a>
        </div>
      </aside>
      <!-- End of sidebar -->

    <!-- NAV BAR -->
   <header>
        <div class="nav-header">
        </div>
        <div class="nav-container">
          <div class="announcement">
          <h2>Grade Table</h2>

<table>
    <thead>
        <tr>
            <th>Subject</th>
            <th>Midterm Grade</th>
            <th>Final Grade</th>
            <th>Overall Grade</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Mathematics</td>
            <td>90</td>
            <td>85</td>
            <td>88.5</td>
        </tr>
        <tr>
            <td>English</td>
            <td>85</td>
            <td>88</td>
            <td>86.5</td>
        </tr>
        <!-- Add more rows for other subjects -->
    </tbody>
</table>
          </div>
        </div>
   </header>
    
<!-- Main content -->
      <main>
        <div class="ann-header">
        </div>
        <div class="ann-container">
          <div class="announcement">
          <h2>Grade Table</h2>

<table>
    <thead>
        <tr>
            <th>Subject</th>
            <th>Midterm Grade</th>
            <th>Final Grade</th>
            <th>Overall Grade</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Mathematics</td>
            <td>90</td>
            <td>85</td>
            <td>88.5</td>
        </tr>
        <tr>
            <td>English</td>
            <td>85</td>
            <td>88</td>
            <td>86.5</td>
        </tr>
        <!-- Add more rows for other subjects -->
    </tbody>
</table>
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
              <p>Good day <b>Kolehiyan</b></p>
              <small class="text-muted">Student - BSIS201</small>
            </div>
            <div class="profile-photo">
              <img src="images/KLD LOGO.png" />
            </div>
          </div>
        </div>
        <!-- End of navbar -->

        <!-- Schedule list -->
        <!-- <div class="schedule">
          <div class="schedule-header">
            <h2>Schedule for Today</h2><small class="text-muted">Friday: Oct 13</small>
            <span class="material-icons-sharp"> add </span>
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
        </div> -->
        <!-- End of schedule list -->
        
        <!-- Grades list -->
        <!-- 
        <div class="grades">
          <div class="grades-header">
            <h2>Midterm Grades</h2>
          </div>

          <div class="grades-list">
            <div class="icon">
              <span class="material-icons-sharp"> code </span>
            </div>
            <div class="subject-title">
              <div class="info">
                <h3>GEC1000 - Web Development</h3>
              </div>
              <div class="info">
                <h2>1.25</h2>
              </div>
            </div>
          </div>

          <div class="grades-list">
            <div class="icon">
              <span class="material-icons-sharp"> edit </span>
            </div>
            <div class="subject-title">
              <div class="info">
                <h3>GEC1000 - IT Infrastructure</h3>
              </div>
              <div class="info">
                <h2>1.25</h2>
              </div>
            </div>
          </div>
        </div> -->
        <!-- End of grades list -->
      </div>
      <!-- End of right section -->
    </div>
      <script src="scripts/dashboard.js"></script>
  </body>

</html>