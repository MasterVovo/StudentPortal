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
      <h2>Change your password</h2>
      <form class="form" autocomplete="off">
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
            <small><span id="length">>= 8 characters</span> &emsp;&emsp;&emsp;&emsp; <span id="lowercase">>= 1 Lowercase</span><br>
            <span id="uppercase">>= 1 Uppercase</span> &emsp;&emsp;&emsp;&emsp; <span id="special">>= 1 Special character</span><br>
            <span id="number">>= 1 Number</span></small>
          </div>

          <div class="input-box">
            <span class="details">Repeat Password</span>
            <input
              type="password"
              name="repeatPass"
              id="repeatPass"
              placeholder="Repeat password"
            />
            <small><span id="checkPass">&nbsp;</span></small>
          </div>

        <!-- SEND BUTTON-->
        <button type="submit">Reset Password</button>
      </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#newPass").on("input", function () {
          var pass = $(this).val();

          var passLen = pass.length >= 8 && pass.length <= 20;
          var hasUpper = /[A-Z]/.test(pass);
          var hasLower = /[a-z]/.test(pass);
          var hasNum = /\d/.test(pass);
          var hasSym = /\W/.test(pass);
          
          if (passLen) {
            document.getElementById("length").style.color = "green";
          } else {
            document.getElementById("length").style.color = "red";
          }

          if (hasUpper) {
            document.getElementById("uppercase").style.color = "green";
          } else {
            document.getElementById("uppercase").style.color = "red";
          }

          if (hasLower) {
            document.getElementById("lowercase").style.color = "green";
          } else {
            document.getElementById("lowercase").style.color = "red";
          }

          if (hasSym) {
            document.getElementById("special").style.color = "green";
          } else {
            document.getElementById("special").style.color = "red";
          }

          if (hasNum) {
            document.getElementById("number").style.color = "green";
          } else {
            document.getElementById("number").style.color = "red";
          }
        });

        $("#repeatPass").on("input", function () {
          var newPass = $("#newPass").val();
          var repeatPass = $("#repeatPass").val();

          if (newPass !== repeatPass) {
            document.getElementById("checkPass").style.color = "red";
            document.getElementById("checkPass").innerHTML = "Passwords do not match";
          } else {
            document.getElementById("checkPass").style.color = "green";
            document.getElementById("checkPass").innerHTML = "Passwords match";
          }
        });

        $("form").on("submit", function(e) {
          e.preventDefault();

          var newPass = $("#newPass").val();
          var repeatPass = $("#repeatPass").val();

          var passLen = newPass.length >= 8 && newPass.length <= 20;
          var hasUpper = /[A-Z]/.test(newPass);
          var hasLower = /[a-z]/.test(newPass);
          var hasNum = /\d/.test(newPass);
          var hasSym = /\W/.test(newPass);

          if (!passLen || !hasUpper || !hasLower || !hasNum || !hasSym) {
            alert("Password field doesn't meet the requirements");
            return;
          }

            if (newPass !== repeatPass) {
              alert("Passwords do not match");
              return;
            }

            $.ajax({
              url: 'includes/resetPass.inc.php',
              type: 'POST',
              data: { 
                newPass: newPass,
                repeatPass: repeatPass
              },
              success: function(response) {
                if (response.trim() === "success") {
                  alert("Password changed successfully");
                  window.location.href = "loginPage.php";
                } else if (response.trim() === "error") {
                  alert("Error changing password, make sure that all requirements are met");
                }
              },
              error: function(xhr, status, error) {
                alert("Error: " + error);
              }
            });
        });
      });
    </script>
  </body>
</html>
