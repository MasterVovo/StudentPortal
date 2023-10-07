<?php
session_start();
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link rel="stylesheet" href="css\login.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <script type="text/javascript">
    window.onload = function() {
      var errorMessage = "<?php echo $_SESSION['errorMessage'] ?>";
      if (errorMessage) {
        alert(errorMessage);
      }
    }
  </script>

</head>

<body>
  <!-- LOGIN PAGE-->
  <div class="wrapper">
    <form action="loginValidation.php" method="POST">
      <center>
        <img src="css\images\kldLogo.png" alt="KLD LOGO" height="300px" width="300px" />
      </center>
      <h1>Kolehiyo ng Lungsod ng Dasmarinas Student Information System</h1>
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
        <a href="#">Forgot password?</a>
      </div>
      <button type="submit" class="btn">Login</button>
      <br />
      <br />
      <h4>OR</h4>
      <br />

      <div class="scan-code">
        <hr />
        <br />
        <i class="bx bx-qr-scan"></i><br />
        <label>Scan Me!</label>
      </div>
    </form>
  </div>
</body>

</html>


<?php unset($_SESSION['errorMessage']); ?>