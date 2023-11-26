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
      <h2>Change your password</h2>
      <form class="form" autocomplete="off">
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

        <div class="column">
          <div class="input-box">
            <span class="details">New Password</span>
            <input
              type="password"
              name="newPass"
              id="newPass"
              placeholder="Input new password"
            />
          </div>

          <div class="input-box">
            <span class="details">Repeat Password</span>
            <input
              type="password"
              name="repeatPass"
              id="repeatPass"
              placeholder="Repeat password"
            />
          </div>
        </div>

        <!-- SEND BUTTON-->
        <button type="submit">Reset Password</button>
      </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#sendOTP").on("click", function(e) {
          e.preventDefault();

          var otp = Math.floor(100000 + Math.random() * 900000);

          var email = $("#stdEmail").val();

          // Send the OTP
        $.ajax({
            url: 'includes/sendOTP.inc.php',
            type: 'POST',
            data: {
              email: email,
              otp: otp
            },
            success: function(response) {
              // Start the timer
              var timer = 60;
              var interval = setInterval(function() {
                timer--;
                document.getElementById("countdown").innerHTML = timer + " seconds remaining";
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
      });
    </script>
  </body>
</html>
