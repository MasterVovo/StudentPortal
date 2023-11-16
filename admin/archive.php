<?php
  if(isset($_GET['tab'])) {
    $tab = $_GET['tab'];
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
          <a href="database.php">
            <span class="material-icons-sharp"> storage </span>
            <h3>Database</h3>
          </a>
          <a href="archive.php" class="active">
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
          <h1>Archive</h1>
        </div>

        <!-- Nav -->
        <div class="db-nav">
            <!-- <a href="database.php?tab=stdAdd">Add Student</a> -->
            <a href="database.php?tab=stdList">Student List</a>
            <!-- <a href="database.php?tab=fctList">Faculty List</a> -->
        </div>

        <!-- Table -->
        <div class="ann-container">
        <div class="grid-table-container">
            <div id="grid-table"></div>
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
      <!-- AdminLTE for table widget card -->
      <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

      <script>
        let grid = $('#grid-table').jsGrid({
            width: "100%",
            height: "auto",

            // filtering: true,
            // inserting: true,
            // editing: false,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            // deleteConfirm: "Do you really want to delete data?",

            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "POST",
                        url: "includes/fetch-archive-stdList.inc.php",
                        data: filter,
                        dataType: "json"
                    });
                }
            },

            fields: [
                {
                    name: "stdID",
                    title: "Student ID",
                    type: "text",
                    validate: "required"
                },
                {
                    name: "stdFName",
                    title: "First Name",
                    type: "text",
                    validate: "required"
                },
                {
                    name: "stdMName",
                    title: "Middle Name",
                    type: "text"
                },
                {
                    name: "stdLName",
                    title: "Last Name",
                    type: "text",
                    validate: "required"
                },
                {
                    name: "stdBirth",
                    title: "Birthday",
                    type: "text",
                    validate: "required"
                },
                {
                    name: "stdGender",
                    title: "Gender",
                    type: "text",
                    validate: "required"
                },
                {
                    name: "stdCourse",
                    title: "Course",
                    type: "text",
                    validate: "required"
                },
                {
                    name: "stdImage",
                    title: "Image",
                    type: "text"
                },
                {
                    name: "stdEmail",
                    title: "Email",
                    type: "text",
                    validate: "required"
                }
            ]
        }).data("JSGrid");

        // The minimum width of the table for responsiveness
        $('.jsgrid-table').css('min-width', '1800px');
        

        
        $(document).ready(function () {

          // $(".db-nav a").click(function(e) {
          //   e.preventDefault();

          //   var newTab = $(this).data('tab');

          //   $.ajax({
          //       url: 'includes/dbpage_tab_content.inc.php',
          //       method: 'POST',
          //       data: { newTab: newTab },
          //       success: function (response) {
          //           console.log(response);
          //           //location.reload();
          //       },
          //       error: function (error) {
          //           console.error('Error:', error);
          //       }
          //   });
          // });


          // This will run if the upload button is clicked
          $("#uploadBtn").click(function (e) {
            e.preventDefault();

            grid.loadData();
          });


          $('#uploadToDB').click(function(e) {
                e.preventDefault();

                let allData = grid.data;
                let jsonData = JSON.stringify(allData);
                
                // var formData = new FormData();
                // formData.append('excelFile', $('#excelFile')[0].files[0]);

                // $.ajax({
                //     url: 'includes/uploadStdToDB.inc.php',
                //     type: 'POST',
                //     data: formData,
                //     processData: false,  // tell jQuery not to process the data
                //     contentType: false,  // tell jQuery not to set contentType
                //     success: function(data) {
                //         // Hide the loader
                //         document.getElementById('loaderContainer').style.display = 'none';

                //         // Show a success message
                //         alert('Data inserted successfully!');
                //     }
                // });

                $.ajax({
                    url: "includes/add_std.inc.php",
                    type: "POST",
                    data: { jsonData: jsonData, },
                    dataType: "json",
                    success: function (response) {
                        console.log("Data inserted successfully:", response);
                    },
                    error: function (error) {
                        console.error("Error inserting data:", error);
                    }
                });
            });

            
        });
      </script>
  </body>

</html>