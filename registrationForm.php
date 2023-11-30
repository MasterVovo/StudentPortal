<?php
session_start();
$stdId = $_SESSION["stdID"] ?? '';

include "sqlConnection/db_connect.php";

//Notification
$notif = "";

$sql = "SELECT stdFName, stdMName, stdLName, stdEmail FROM stdinfo WHERE stdId = '" . $stdId . "'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$fname = $row["stdFName"];
$mname = $row["stdMName"];
$lname = $row["stdLName"];
$email = $row["stdEmail"];

//Check if the user click the submit button
if (isset($_POST["btnSubmit"])) {
  //Check if all fields have been filled up
    if (
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
        !empty($_POST["EmergencyNum"]))
        {
          //Check for special characters
        if (!preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["Firstname"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["Middlename"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["Lastname"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["address"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["city"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["region"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["barangay"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["father_name"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["mother_name"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["fatherJob"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["motherJob"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["parentAdd"]) &&
        !preg_match("/[\^$&{}<>;=!+%#?]/", $_POST["EmerName"]))
        {
          //Check for phone numbers length
           if (preg_match("/^\d{11}$/", $_POST["phonenum"]) &&
            preg_match("/^\d{11}$/", $_POST["fatherNum"]) &&
            preg_match("/^\d{11}$/", $_POST["motherNum"]) &&
            preg_match("/^\d{11}$/", $_POST["EmergencyNum"]))
            {
              $inputId = mysqli_real_escape_string($conn, $_POST["stdId"]);
              $checkId = mysqli_query(
                  $conn,
                  "SELECT stdID FROM stdinfo WHERE stdID = '$inputId'"
              );
              $numberOfUser = mysqli_num_rows($checkId);

              if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
              }
  
              $saveRecord = $conn->prepare("UPDATE stdinfo SET stdFName = ?, stdMName = ?, stdLName = ?, 
          stdBirth = ?, stdGender = ?, stdImage = ?, stdEmail = ?, stdPhoneNum = ?, stdStreet = ?, stdCity = ?, stdProvince = ?, stdBrgy = ?,
          stdFatherName = ?, stdFatherPhone = ?, stdFatherJob = ?, stdMotherName = ?, stdMotherPhone = ?, stdMotherJob = ?, 
          stdParentAddr = ?, stdEmerName = ?, stdEmerRel = ?, stdEmerPhone = ?, stdEmerBlood = ? WHERE stdID = ?");
  
              $saveRecord->bind_param(
                  "ssssssssssssssssssssssss",
                  $_POST["Firstname"],
                  $_POST["Middlename"],
                  $_POST["Lastname"],
                  $_POST["birthdate"],
                  $_POST["gender"],
                  $imageData, 
                  $_POST["emailadd"],
                  $_POST["phonenum"],
                  $_POST["address"],
                  $_POST["city"],
                  $_POST["region"],
                  $_POST["barangay"],
                  $_POST["father_name"],
                  $_POST["fatherNum"],
                  $_POST["fatherJob"],
                  $_POST["mother_name"],
                  $_POST["motherNum"],
                  $_POST["motherJob"],
                  $_POST["parentAdd"],
                  $_POST["EmerName"],
                  $_POST["EmerRel"],
                  $_POST["EmergencyNum"],
                  $_POST["Bloodtype"],
                  $stdId
              );
  
              $saveRecord->execute();
              $saveRecord->close();

              $stmt = $conn->prepare("UPDATE userinfo SET userStatus = 'active' WHERE schoolID = ?");
              $stmt->bind_param("s", $stdId);
              $stmt->execute();
              $stmt->close();
              $conn->close();
  
              header("Location: dashboard.php");

            }
            else{
              $notif = "Please make sure that the phone numbers are exactly 11 digits long.";
            }
          }

        else{
          $notif = "No special characters allowed. Please try again";
        }
        }

      else{
        $notif = "Please fill out the required fields.";
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
    <form action="registrationForm.php" class = "form" id="registrationForm" method = "POST" enctype="multipart/form-data"> 
      <header>REGISTRATION FORM</header>
      <center style = "color: red">
      <?php echo $notif?></center>
      <span class = "primary"></span>
      <h2>Personal Information</h2>
      <p style = "color : red">Please fill out all required fields marked with *</p>

      <div class="input-box">
        <span class="details">ID Number</span>
        <input type="text" name="stdId" id="stdId" placeholder="KLD-##-######" value="<?php echo $stdId; ?>" readonly>
        <script>console.log(document.getElementById("stdID").value);</script>
      </div>

      <div class="column">
        <div class="input-box">
          <label>First Name<span class = "required">*</span></label>
          <input type="text" id=firstname name=Firstname placeholder="Enter first name" value="<?php echo $fname; ?>" required/>
        </div>

       <div class="input-box">
          <label>Middle Name</label>
          <input type="text" name=Middlename placeholder="Enter middle name" value="<?php echo $mname; ?>" />
        </div>

        <div class="input-box">
          <label>Last Name<span class = "required">*</span></label>
          <input type="text" name=Lastname placeholder="Enter last name" value="<?php echo $lname; ?>" required/>
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
          <input type="file" accept=".jpeg, .png, .jpg" id="input-file" name = "image">
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
          <input type="text" name=phonenum id="phoneNum"placeholder="Enter phone number" required/>
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
            <input type="text" name=fatherNum id="fatherNum" placeholder="Emergency contact" required/>
          </div>

          <div class="input-box">
            <label>Contact Number<span class = "required">*</span></label>
            <input type="text" name=motherNum id="motherNum" placeholder="Emergency contact"  required/>
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
          <input type="text" name="EmergencyNum" id="emerNum" placeholder="Emergency contact"  required/>
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


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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