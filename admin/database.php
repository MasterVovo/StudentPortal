<?php
  if(isset($_GET['tab'])) {
    $tab = $_GET['tab'];
  } else {
    $tab = null;
  }
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KLD Student Portal</title>
    <link rel="shortcut icon" href="../images/KLD LOGO.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" integrity="sha512-jx8R09cplZpW0xiMuNFEyJYiGXJM85GUL+ax5G3NlZT3w6qE7QgxR4/KE1YXhKxijdVTDNcQ7y6AJCtSpRnpGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" integrity="sha512-3Epqkjaaaxqq/lt5RLJsTzP6cCIFyipVRcY4BcPfjOiGM1ZyFCv4HHeWS7eCPVaAigY3Ha3rhRgOsWaWIClqQQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../styles/dashboard.css" />
    <link rel="stylesheet" href="styles/dashboard.css" />
    <link rel="stylesheet" href="styles/database.css">
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
          <a href="adminDashboard.php">
            <span class="material-icons-sharp"> space_dashboard </span>
            <h3>Dashboard</h3>
          </a>
          <a href="database.php" class="active">
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
          <a href="../logout.php">
            <span class="material-icons-sharp"> logout </span>
            <h3>Logout</h3>
          </a>
        </div>
      </aside>
      <!-- End of sidebar -->

      <!-- Main content -->
      <main>
        <div class="ann-header">
          <h1>Database</h1>
        </div>

        <!-- Nav -->
        <div class="ann-container">
            <a href="database.php?tab=stdAdd" <?php if ($tab == 'stdAdd') echo 'class="selected"' ?>>Add Student</a>
            <a href="database.php?tab=stdList" <?php if ($tab == 'stdList') echo 'class="selected"' ?>>Student List</a>
            <a href="database.php?tab=fctList" <?php if ($tab == 'fctList') echo 'class="selected"'?>>Faculty List</a>
          </div>

        

        <!-- Show the content depending on the tab opened -->
        <?php
          if(isset($_GET['tab'])) {
            echo '
            <!-- Table -->
            <div class="ann-container">
            <div class="grid-table-container">
                <div id="grid-table"></div>
            </div>
            </div>
            ';

            if ($_GET['tab'] == 'stdAdd') echo file_get_contents('html-pieces/stdAdd');
          } else {
            echo file_get_contents('html-pieces/no-tab');
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
              <img src="../images/KLD LOGO.png" />
            </div>
          </div>
        </div>

        
        <!-- End of navbar -->
      </div>
      <!-- End of right section -->
    </div>
      <script src="../scripts/dashboard.js"></script>
      <!-- jQuery and jsGrid for Table -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <!-- SweetAlert for notification -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- AdminLTE for table widget card -->
      <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

      <?php
          if(isset($_GET['tab'])) {
            switch($tab) {
              case 'stdAdd':
                echo '<script src="scripts/stdAdd.js"></script>';
                break;
              case 'stdList':
                echo '<script src="scripts/stdList.js"></script>';
                break;
              case 'fctList':
                echo '<script src="scripts/fctList.js"></script>';
            }
          }
         
        ?>
      
      <script>
        
      </script>
  </body>

</html>