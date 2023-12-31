<?php require "../sqlConnection/db_connect.php"; // Connect to the database 
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
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KLD Student Portal</title>
    <link rel="shortcut icon" href="../images/KLD LOGO.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../styles/dashboard.css" />
    <link rel="stylesheet" href="styles/dashboard.css" />
  </head>

  <body>
    <div class="orig-container">
      <!-- Sidebar -->
      <aside>
        <div class="toggle">
          <div class="logo">
            <img src="../images/KLD LOGO.png" />
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
          <a href="../dashboard.php">
            <span class="material-icons-sharp"> home </span>
            <h3>Home</h3>
          </a>
          <a href="adminDashboard.php" class="active">
            <span class="material-icons-sharp"> space_dashboard </span>
            <h3>Dashboard</h3>
          </a>
          <a href="database.php">
            <span class="material-icons-sharp"> storage </span>
            <h3>Database</h3>
          </a>
          <a href="announcement.php">
            <span class="material-icons-sharp"> feed </span>
            <h3>News</h3>
          </a>
          <a href="archive.php">
            <span class="material-icons-sharp"> auto_delete </span>
            <h3>Archive</h3>
          </a>
          <a href="../logout.html">
            <span class="material-icons-sharp"> logout </span>
            <h3>Logout</h3>
          </a>
        </div>
      </aside>
      <!-- End of sidebar -->

      <!-- Main content -->
      <main>
        <div class="ann-header">
          <h1>Dashboard</h1>
          <span class="material-icons-sharp"> filter_alt </span>
        </div>

        <!-- Gender and Age Chart -->
        <div class="flex gap gender-age-container">
          <div class="ann-container align-items-center">
            <span>Student Gender Distribution</span>
            <div class="canvas-container gender-container"><canvas id="gender"></canvas></div>
          </div>
          <div class="ann-container align-items-center" style="align-items: flex-end">
            <span>Student Age Distribution</span>
            <div class="canvas-container age-container"><canvas id="age"></canvas></div>
          </div>
        </div>
        
        <!-- Faculty and Student Count -->
        <div class="ann-container">
          <div class="faculty-student-container flex gap">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>150</h3>
                <p>Teachers</p>
              </div>
              <div class="icon">
                <i class="material-icons-sharp"> person </i>
              </div>
            </div>
            <div class="small-box bg-success">
              <div class="inner">
                <h3>150</h3>
                <p>Students</p>
              </div>
              <div class="icon">
                <i class="material-icons-sharp"> group </i>
              </div>
            </div>
            <div class="small-box bg-orange">
              <div class="inner">
                <h3>1 | 50</h3>
                <p>Teacher to Student <br>Ratio</p>
              </div>
              <div class="icon">
                <i class="material-icons-sharp"> pie_chart </i>
              </div>
            </div>
          </div>
        </div>

         <!-- Student Enrollment -->
        <div class="ann-container">
          
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-lime">
                <span class="info-box-icon"><i class="material-icons-sharp">group_add</i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Student Enrollment</span>
                  <span class="info-box-number">5,000</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 50%"></div>
                  </div>
                  <span class="progress-description">
                  50% Increase From Last Year
                  </span>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-teal">
                <span class="info-box-icon"><i class="material-icons-sharp">loop</i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Student Retention</span>
                  <span class="info-box-number">4,500</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 80%"></div>
                  </div>
                  <span class="progress-description">
                  80% Increase From Last Year
                  </span>
                </div>
              
              </div>
            
            </div>
            
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box bg-olive">
                <span class="info-box-icon"><i class="material-icons-sharp">school</i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Graduated</span>
                  <span class="info-box-number">4,350</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 10%"></div>
                  </div>
                  <span class="progress-description">
                  10% Increase From Last Year
                  </span>
                </div>
              
              </div>
            
            </div>
            
            </div>
        </div>

        <!-- Average Grades -->
        <div class="ann-container">
          <div class="select-container">
            <select>
              <option selected disabled>Course</options>
              <option value="information system">Information System</options>
              <option value="psychology">Psychology</option>
              <option value="midwifery">Midwifery</option>
              <option value="civil engineering">Civil Engineering</option>
              <option value="nursing">Nursing</option>
            </select>
  
            <select>
              <option selected disabled>Year Level</option>
              <option value="1st year">1st year</option>
              <option value="2nd year">2nd year</option>
              <option value="3rd year">3rd year</option>
              <option value="4th year">4th year</option>
            </select>
  
            <select>
              <option selected disabled>Semester</option>
              <option value="1st year">First</option>
              <option value="2nd year">Second</option>
            </select>
          </div>
          
          
          <div class="card" style="width: 100%">
            <div class="card-header">
              <h3 class="card-title">Average Grades Per Subject</h3>
            </div>
          
            <div class="card-body p-0">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th style="width: 50px">Subject Code</th>
                    <th>Subject Title</th>
                    <th>Average Grade</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>PCIS2118</td>
                    <td>Web Development</td>
                    <td><span class="badge bg-danger">55%</span></td>
                  </tr>
                  <tr>
                    <td>PCIS2118L</td>
                    <td>Web Development Lab</td>
                    <td><span class="badge bg-warning">70%</span></td>
                  </tr>
                  <tr>
                    <td>GEC1100</td>
                    <td>Technical Writing</td>
                    <td><span class="badge bg-primary">30%</span></td>
                  </tr>
                  <tr>
                    <td>GEC7000</td>
                    <td>Mga Babasahin Hinggil sa Kasaysayan ng Pilipinas</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                  <tr>
                    <td>GEC6000</td>
                    <td>The Contemporary World</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                  <tr>
                    <td>PE2103</td>
                    <td>Swimming</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                  <tr>
                    <td>PCIS2103</td>
                    <td>Professional Issues in Information System</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                  <tr>
                    <td>CCIS2104</td>
                    <td>Data Structures and Algorithm Lec</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                  <tr>
                    <td>CCIS2104L</td>
                    <td>Data Structures and Algorithm Lab</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                  <tr>
                    <td>PCIS2104</td>
                    <td>IT Infrastructure and Network Technologies Lec</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                  <tr>
                    <td>PCIS2104L</td>
                    <td>IT Infrastructure and Network Technologies Lab</td>
                    <td><span class="badge bg-success">90%</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
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
              <img src=<?php echo "data:image/jpeg;base64,$pfp";?> />
            </div>
          </div>
        </div>
        <!-- End of navbar -->

        <!-- Schedule list -->
        <div class="schedule">
          <div class="schedule-header">
            <h2>Status</h2>
          </div>

          <div class="schedule-list">
            <div class="right-chart-container"><canvas id="chart-visitors"></div>
            <div class="sched-title">
              <div class="info">
                <h3>No. of Visitors</h3>
                <small class="text_muted"> 34 </small>
              </div>
            </div>
          </div>
        <!-- End of schedule list -->

        <!-- Grades list -->
        
        <!-- End of grades list -->
      </div>
      <!-- End of right section -->
    </div>
      <script src="../scripts/dashboard.js"></script>
      <!-- jQuery -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <!-- Chart.js for charts -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <!-- AdminLTE for table widget card -->
      <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
      <script src="scripts/dashboard-chart.js"></script>
  </body>
</html>