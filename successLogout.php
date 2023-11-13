<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/KLD LOGO.png" type="image/x-icon">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <title>Successfully Logged Out</title>

    <!-- CSS MODIFY -->
    <style>
      body {
        background: #ececec;
      }
      .header-text {
        text-align: center;
      }
      /* RESPONSIVE */
      @media only screen and (min-width: 200px) {
        .container {
          text-align: center;
        }
        .header-text {
          text-align: center;
        }

        .button {
          align-items: center;
        }
      }
    </style>
  </head>
  <!-- SUCCESSFULLY LOGGED OUT -->
  <body>
    <div
      class="container d-flex justify-content-center align-items-center min-vh-100"
    >
      <div class="col-md-13">
        <div class="header-text text-left">
          <h3>You have successfully logged out.</h3>
          <p>login in again to continue working on awesome things!</p>
        </div>
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6 mb-3">
            <button class="btn btn-lg btn-success w-70 fs-6" onclick="location.href='includes/userLogout.inc.php'">
              Go back to Login
            </button>
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
  </body>
</html>