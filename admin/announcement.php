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

    <style>
        main .ann-container .form{
            width: 100%;
            display: grid;

            grid-template-columns: 0.7fr 1fr;
            gap: 1rem;

            grid-template-areas:
            "annTitle annTitle"
            "annImage annPreview"
            "annContent annContent";
        }

        .form input , .form textarea, .form img, .form button{
            padding: 0.5rem;
            border-radius: 10px;
            border: 1px solid gray;
        }

        .annTitle {
            grid-area: annTitle;
        }

        .annTitle input {
            width: 100%;
        }

        .annImage {
            grid-area: annImage;
            margin: auto;
            text-align: center;
        }

        .annPreview {
            grid-area: annPreview;
        }

        .annPreview img{
            padding: 0;
        }

        .annContent {
            grid-area: annContent;
        }

        .annContent textarea {
            width: 100%;
            height: 200px;
        }

        .annPost {
            width: 10rem;
            background-color: #065225;
            color: white;
        }
    </style>
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
          <a href="announcement.php" class="active">
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
          <h1>Post Announcements</h1>
        </div>

        <!-- Table -->
        <div class="ann-container">
            <form class="form">
                <div class="annTitle">
                    <h2>Announcement Title*</h2>
                    <input type="text" id="annTitle" name="annTitle" placeholder="Title">
                </div>
                <div class="annImage">
                    <h2>Announcement Image*</h2>
                    <input type="file" accept=".jpeg, .png, .jpg" id="image-input" name ="image">
                </div>
                <div class="annPreview">
                    <img src="../images/Placeholder.jpg" id="preview">
                </div>
                <div class="annContent">
                    <h2>Announcement Content*</h2>
                    <textarea name="annContent" id="annContent"></textarea>
                </div>

                <button class="annPost" type="submit">Post</button>
            </form>
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

      <script> //Update Image
        let preview = document.getElementById("preview");
        let inputImage = document.getElementById("image-input");

        inputImage.onchange = function () {
            preview.src = URL.createObjectURL(inputImage.files[0])
        }
      </script>

      <script>
        $(document).ready(function () {
            $(".annPost").click(function(e) {
              e.preventDefault();
              // Check if the .annTitle, .image-input, and .annContent have a value
              if ($("#annTitle").val() && $("#image-input").val() && $("#annContent").val()) {
                // Proceed to run ajax to send the data to the db
                var formData = new FormData();
                formData.append("title", $("#annTitle").val());
                formData.append("image", $("#image-input")[0].files[0]);
                formData.append("content", $("#annContent").val());

                $.ajax({
                  url: "includes/post.inc.php",
                  method: "POST",
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response) {
                    if (response.trim() === "success") {
                        alert("Announcement posted successfully!");
                    } else {
                        alert("Announcement could not be posted.");
                    }
                    window.location.reload();
                  },
                  error: function(xhr, status, error) {
                    alert("Error: " + error);
                  }
                });
              } else {
                alert("Please fill in all the required fields.");
              }
            });
        });
      </script>
  </body>

</html>