<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KLD Student Portal Login</title>
  <link rel="stylesheet" href="styles/Loginpage.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <!-- LOGIN PAGE-->
  <div class="wrapper">
    <form action="includes\loginPage.inc.php" method="POST">
      <center>
        <img src="images/KLD LOGO.png" alt="KLD LOGO" />
      </center>
      <h1>KLD STUDENT PORTAL</h1>
      <div class="input-box">
        <input type="text" name="stdId" id="stdId" placeholder="ID Number" required />
        <i class="bx bxs-user"></i>
      </div>

      <div class="input-box">
        <input type="password" name="stdPass" id="stdPass" placeholder="Password" required />
        <i class="bx bxs-lock-alt"></i>
      </div>

      <div class="remember-forgot">
        <label><input type="checkbox" /> Remember me</label>
        <a href="resetPass.html">Forgot password?</a>
      </div>
      <button type="submit" class="btn" onclick="showToast()">Login</button>
      <br />
    </form>
  </div>
  

  <div id="toast" class="toast">
    <?php
    if ($_SESSION['errorMessage']) { // Check if there is an error message
      echo '<script>
            var toast = document.getElementById("toast");
            toast.classList.add("show");
            toast.innerHTML = "' . $_SESSION['errorMessage'] . '"; 
      
            setTimeout(function() {
              toast.classList.remove("show");
            }, 3000); // 3 seconds
          </script>'; // Display the error message
    }
    ?>
  </div>
</body>

</html>

<?php unset($_SESSION['errorMessage']); // Clear the error message ?>