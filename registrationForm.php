<?php
session_start();
$stdId = $_SESSION['stdID'] ?? '';

include "sqlConnection/db_connect.php";

$sql = "SELECT stdEmail FROM stdinfo WHERE id ='" . $_SESSION['stdID'] . "'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$email = $row['emailadd'];

if (isset($_POST["btnSubmit"])) {
    if (
        !empty($_POST["stdId"]) &&
        !empty($_POST["Firstname"]) &&
        !empty($_POST["Lastname"]) &&
        !empty($_POST["gender"]) &&
        !empty($_POST["emailadd"]) &&
        !empty($_POST["phonenum"]) &&
        !empty($_POST["birthdate"]) &&
        !empty($_POST["address"]) &&
        !empty($_POST["city"]) &&
        !empty($_POST["region"]) &&
        !empty($_POST["barangay"]) &&
        !empty($_POST["father_name"]) &&
        !empty($_POST["mother_name"]) &&
        !empty($_POST["fatherNum"]) &&
        !empty($_POST["motherNum"]) &&
        !empty($_POST["fatherJob"]) &&
        !empty($_POST["motherJob"]) &&
        !empty($_POST["parentAdd"]) &&
        !empty($_POST["EmerName"]) &&
        !empty($_POST["EmerRel"]) &&
        !empty($_POST["EmergencyNum"])
        )
     {
      if (preg_match("/^\d{11}$/", $_POST["phonenum"]) &&
      preg_match("/^\d{11}$/", $_POST["fatherNum"]) &&
      preg_match("/^\d{11}$/", $_POST["motherNum"]) &&
      preg_match("/^\d{11}$/", $_POST["EmergencyNum"]))

            $inputId = mysqli_real_escape_string($conn, $_POST["stdId"]);
            $checkId = mysqli_query(
                $conn,
                "SELECT stdID FROM stdinfo WHERE stdID = '$inputId'"
            );
            $numberOfUser = mysqli_num_rows($checkId);

            $saveRecord = $conn->prepare("INSERT INTO stdinfo (stdID, stdFName, stdMName, stdLName, 
        stdBirth, stdGender, stdImage, stdEmail, stdPhoneNum, stdStreet, stdCity, stdProvince, stdBrgy,
        stdFatherName, stdFatherPhone, stdFatherJob, stdMotherName, stdMotherPhone, stdMotherJob, 
        stdParentAddr, stdEmerName, stdEmerRel, stdEmerPhone, stdEmerBlood) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $saveRecord->bind_param(
                "ssssssssssssssssssssssss",
                $inputId,
                $inputFirstname,
                $inputMiddlename,
                $inputLastname,
                $inputBirthdate,
                $inputGender,
                $inputImage,
                $inputEmail,
                $inputPhonenumber,
                $inputAddress,
                $inputCity,
                $inputRegion,
                $inputBarangay,
                $inputFathername,
                $inputFathernumber,
                $inputFatherJob,
                $inputMothername,
                $inputMothernumber,
                $inputMotherJob,
                $inputParentsnumber,
                $inputFullname,
                $inputRelationship,
                $inputEmergencynumber,
                $inputBloodType
            );

            $saveRecord->execute();
            $saveRecord->close();
            $conn->close();

            header("Location: dashboard.php");
        }
        else {
          $notif = "Please make sure that phone numbers are exactly 11 digits long.";
      }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link rel="stylesheet" href="styles/registrationForm.css">
</head>

<body>
  <!-- REGISTRATION PAGE  -->
  <div class="container">
    <form action="registrationForm.php" class = "form" method = "POST"> 
      <header>REGISTRATION FORM</header>
      <span class = "primary"></span>
      <h2>Personal Information</h2>

      <div class="input-box">
        <span class="details">ID Number</span>
        <input type="text" name="stdId" id="stdId" placeholder="KLD-00-000000" value="<?php echo $stdId; ?>" readonly>
        <script>console.log(document.getElementById("stdID").value);</script>
      </div>

      <div class="column">
        <div class="input-box">
          <label>First Name<span class = "required">*</span></label>
          <input type="text" id=firstname name=Firstname placeholder="Enter first name" required/>
        </div>

       <div class="input-box">
          <label>Middle Name</label>
          <input type="text" name=Middlename placeholder="Enter middle name"  />
        </div>

        <div class="input-box">
          <label>Last Name<span class = "required">*</span></label>
          <input type="text" name=Lastname placeholder="Enter last name" required/>
        </div>
      </div>

      <!-- GENDER -->
      <div class="gender-box">
        <h3>Gender<span class = "required">*</span></h3>
        <div class="gender-option">
          <div class="gender">
            <input type="radio" id="check-male" name="gender" value="Male" required/>
            <label for="check-male">Male</label>
          </div>
          <div class="gender">
            <input type="radio" id="check-female" name="gender" value="Female" required/>
            <label for="check-female">Female</label>
          </div>
          <div class="gender">
            <input type="radio" id="check-other" name="gender" value="PNS" required/>
            <label for="check-other">Prefer not to say</label>
          </div>
        </div>
      </div>

      <!--  UPLOAD IMAGE -->
      <div class="hero">
        <div class="card">
          <h2>UPLOAD IMAGE</h2>
          <p>Attach Image</p>
          <img src="images/profile.png" id="profile-pic">
          <label for="input-file">Update Image</label>
          <input type="file" accept="images/jpeg, image/png, image/jpg" id="input-file" name = "image">
        </div>
      </div>

   

      <!--CONTACT INFORMATION-->
      <h2>Contact Information</h2>
      <div class="input-box">
        <label>Email Address<span class = "required">*</span></label>
        <input type="text" name=emailadd placeholder="Enter email address" value="<?php echo $email; ?>"  required/>
      </div>

      <div class="column">
        <div class="input-box">
          <label>Phone Number<span class = "required">*</span></label>
          <input type="number" name=phonenum placeholder="Enter phone number" required/>
        </div>
        <div class="input-box">
          <label>Birth Date<span class = "required">*</span></label>
          <input type="date" name=birthdate placeholder="Enter birth date"  required/>
        </div>
      </div>
      <div class="input-box address">
        <label>Address<span class = "required">*</span></label>
        <input type="text" name=address placeholder="Enter street address"  required/>
        <div class="column">
          <input type="text" name=city placeholder="Enter your city" />
        </div>
        <div class="column">
          <input type="text" name=region placeholder="Enter your region"  required/>
          <input type="text" name=barangay placeholder="Enter your barangay"  required/>
          </select>
        </div>
    

        <!--FAMILY INFORMATION-->
        <br>
        <h2>Family Information</h2>
        <div class="column">
          <div class="input-box">
            <label>Father<span class = "required">*</span></label>
            <input type="text" name=father_name placeholder="father's name"  required/>
          </div>

          <div class="input-box">
            <label>Mother<span class = "required">*</span></label>
            <input type="text" name=mother_name placeholder="Mother's name" required/>
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Contact Number<span class = "required">*</span></label>
            <input type="text" name=fatherNum placeholder="Emergency contact" required/>
          </div>

          <div class="input-box">
            <label>Contact Number<span class = "required">*</span></label>
            <input type="text" name=motherNum placeholder="Emergency contact"  required/>
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Occupation<span class = "required">*</span></label>
            <input type="text" name=fatherJob placeholder="Occupation"  required/>
          </div>

          <div class="input-box">
            <label>Occupation<span class = "required">*</span></label>
            <input type="text" name=motherJob placeholder="Occupation" required/>
          </div>
        </div>

        <div class="input-box">
          <label>Parents Home Address<span class = "required">*</span></label>
          <input type="text" name=parentAdd placeholder="Enter Address"  required/>
        </div>
        <br>


        <!--EMERGENCY INFORMATIOn-->
        <h2>Emergency Information</h2>
        <div class="column">
          <div class="input-box">
            <label>Name<span class = "required">*</span></label>
            <input type="text" name="EmerName" placeholder="Full name" required/>
          </div>
          <div class="input-box">
            <label>Relationship<span class ="required">*</span></label>
            <div class="select-box" required>
              <select name ="EmerRel">
                <option hidden>Relationship</option>
                <option>Parent</option>
                <option>Spouse</option>
                <option>Child</option>
                <option>Sibling</option>
                <option>Grand Parent</option>
                <option>Other Family Member</option>
              </select>
            </div>
          </div>
        </div>
        <div class="input-box">
          <label>Contact Number<span class = "required">*</span></label>
          <input type="text" name="EmergencyNum" placeholder="Emergency contact"  required/>
        </div>
        <div class="input-box">
          <label>Blood Type</label>
          <div class="select-box">
            <select name="Bloodtype">
              <option hidden>Blood Type</option>
              <option value="A+">A Positive (A+)</option>
              <option value="A-">A Negative (A-)</option>
              <option value="B+">B Positive (B+)</option>
              <option value="B-">B Negative (B-)</option>
              <option value="AB+">AB Positive (AB+)</option>
              <option value="AB-">AB Negative (AB-)</option>
              <option value="O+">O Positive (O+)</option>
              <option value="O-">O Negative (O-)</option>
            </select>
          </div>
        </div>
      </div>
     
      <!-- SUBMIT BUTTON -->
      <div class="Submit-button">
        <input type="submit" name="btnSubmit" value="Submit">
        <input type="reset" name="btnClear" value="Clear">
      </div>
    </div>
    </form>
    </section>

    <!-- FOR UPDATE IMAGE -->
    <script>
      let profilePic = document.getElementById("profile-pic");
      let inputFile = document.getElementById("input-file");

      inputFile.onchange = function () {
        profilePic.src = URL.createObjectURL(inputFile.files[0])
      }
    </script>
  </div>
</body>
</html>