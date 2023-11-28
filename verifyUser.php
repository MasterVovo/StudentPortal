<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/KLD LOGO.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/resetPass.css" />
    <title>Reset Password</title>
  </head>

  <body>
    <!-- RESET PASSWORD FORM-->
    <section class="container">
      <h2>Verify your email</h2>
      <form class="form" autocomplete="off">
        <div class="input-box">
          <span class="details">KLD ID</span>
          <input
            type="text"
            name="userId"
            id="userId"
            placeholder="KLD-##-######"
            autocomplete="false"
            readonly
            onfocus="this.removeAttribute('readonly');"
          />
        </div>

        <div class="input-box">
          <span class="details">Email</span>
          <input
            type="email"
            name="stdEmail"
            id="stdEmail"
            placeholder="example@email.com"
            autocomplete="false"
            readonly
            onfocus="this.removeAttribute('readonly');"
          />
          <button id="sendOTP">Send OTP</button>
          <small id="countdown"></small>
        </div>

        <div class="input-box">
          <span class="details">OTP</span>
          <input
            type="text"
            name="otp"
            id="otp"
            placeholder="Enter OTP"
          />
        </div>

        <!-- SEND BUTTON-->
        <button type="submit">Verify Email</button>
      </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#sendOTP").on("click", function(e) {
          e.preventDefault();

          var otp = Math.floor(100000 + Math.random() * 900000);

          var userId = $("#userId").val();
          var email = $("#stdEmail").val();

          if(!userId){
            alert("Please enter your KLD ID");
            return;
          }

          var userIdPattern = /^KLD-\d{2}-\d{6}(T|A)?$/;
          if(!userIdPattern.test(userId)){
            alert("Please enter a valid KLD ID");
            return;
          }

          if(!email){
            alert("Please enter your email");
            return;
          }

          var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if(!emailPattern.test(email)){
            alert("Please enter a valid email address");
            return;
          }

          $.ajax({
            url: 'includes/sendOTP.inc.php',
            type: 'POST',
            data: {
              email: email,
              otp: otp,
              userId: userId
            },
            success: function(response) {
              if(response.trim() === "No ID found"){
                alert('No user found with that ID');
                return;
              } else if (response.trim() === "No email found"){
                alert('No user found with that email');
                return;
              }

              // Start the timer
              var timer = 60;
              var interval = setInterval(function() {
                timer--;
                document.getElementById("countdown").innerHTML = timer + " seconds remaining to resend OTP";
                if(timer === 0) {
                  clearInterval(interval);
                  document.getElementById("sendOTP").disabled = false;
                  document.getElementById("countdown").innerHTML = "";
                }
              }, 1000);

              // Disable the button
              document.getElementById("sendOTP").disabled = true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
          });
        });

        $("form").on("submit", function(e) {
          e.preventDefault();

          var otp = $("#otp").val();

          if(!otp){
            alert("Please enter OTP");
            return;
          }

          $.ajax({
            url: 'includes/verifyOTP.inc.php',
            type: 'POST',
            data: {
              otp: otp
            },
            success: function(response) {
              if(response.trim() === "Incorrect OTP"){
                alert("OTP doesn't match");
              } else {
                window.location.href = "resetPass.php";
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
          });
        });
      });
    </script>
  </body>
</html>
