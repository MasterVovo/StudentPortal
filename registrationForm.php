<?php
include("db_connect.php");

$notif = "";

if(isset($_POST["btnSubmit"])){
    $notif= "";
    if(!empty($_POST["stdId"]) AND!empty($_POST["Firstname"]) 
    AND !empty($_POST["Lastname"]) AND !empty($_POST["gender"]) 
    AND !empty($_POST["Occupation"]) AND !empty($_POST["emailadd"]) 
    AND !empty($_POST["phonenum"]) AND !empty($_POST["birthdate"]) 
    AND !empty($_POST[ "address"]) AND !empty($_POST["city"])
    AND !empty($_POST["region"]) AND !empty($_POST["barangay"]) 
    AND !empty($_POST["father_name"]) AND !empty($_POST["mother_name"]) 
    AND !empty($_POST["Emergencynum"]) AND !empty($_POST["Emergencynum"])
    AND !empty($_POST["Occupation"]) AND !empty($_POST["Occupation"]) 
    AND !empty($_POST["Parents_num"]) AND !empty($_POST["Fullname"]) 
    AND !empty($_POST["Emergencynum"]) )
    
    {
        if(!preg_match("/[\'^$&{}<>;=!]/", $_POST["Firstname"]))

        $inputId = $_POST["stdId"];
        $inputFirstname = $_POST["Firstname"];
        $inputMiddlename = $_POST["Middlename"];
        $inputLastname = $_POST["Lastname"];
        $inputGender = $_POST["gender"];
        $inputEmail = $_POST["emailadd"];
        $inputPhonenumber = $_POST["phonenum"];
        $inputBirthdate = $_POST["birthdate"];
        $inputAddress = $_POST["address"];
        $inputCity = $_POST["city"];
        $inputRegion = $_POST["region"];
        $inputBarangay = $_POST["barangay"];
        $inputFathername = $_POST["father_name"];
        $inputMothername = $_POST["mother_name"];
        $inputFathernumber = $_POST["Emergencynum"];
        $inputMothernumber = $_POST["Emergencynum"];
        $inputFatherJob = $_POST["Occupation"];
        $inputMotherJob = $_POST["Occupation"];
        $inputParentsnumber = $_POST["Parents_num"];
        $inputFullname = $_POST["Fullname"];
        $inputEmergencynumber = $_POST["Emergencynum"];

        $inputId = mysqli_real_escape_string($conn, $_POST["stdId"]);
        $checkId = mysqli_query($conn, "SELECT stdID FROM stdinfo WHERE stdID = '$inputId'");
        $numberOfUser = mysqli_num_rows($checkId);

        $saveRecord = $conn->prepare("INSERT INTO stdinfo (stdID, stdFName, stdMName, stdLName, 
        stdBirth, stdGender, stdImage, stdEmail, stdPhoneNum, stdStreet, stdCity, stdProvince, stdBrgy,
        stdFatherName, stdFatherPhone, stdFatherJob, stdMotherName, stdMotherPhone, stdMotherJob, 
        stdParentAddr, stdEmerName, stdEmerRel, stdEmerPhone, stdEmerBlood) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $saveRecord->bind_param("sssssbssssssssssssssssss", $inputId, $inputFirstname, $inputMiddlename, 
            $inputLastname, $inputBirthdate, $inputGender, $inputImage, $inputEmail, $inputPhonenumber, 
            $inputAddress, $inputCity, $inputRegion, $inputBarangay, $inputFathername, $inputFathernumber, 
            $inputFatherJob,$inputMothername, $inputMothernumber,  $inputMotherJob, $inputParentsnumber,
            $inputFullname, $inputRelationship, $inputEmergencynumber, $inputBloodType);

            $saveRecord->execute();
            $saveRecord->close();
            $conn->close();
    }

    }
else{
    $notif = "";
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
<div>
    <?php
    
    ?>
</div>
  <!-- REGISTRATION PAGE  -->
  <div class="container">
    <form action="registrationForm.php"  class= "form" method = "POST"> 
      <header>REGISTRATION FORM</header>
      <span class = "primary"><?php echo $notif;?></span>
      <h2>Personal Information</h2>

      <div class="input-box">
        <span class="details">ID Number</span>
        <input type="text" name="stdId" id="stdId" placeholder="KLD-00-000000" >
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
            <input type="radio" id="check-male" name="gender" required/>
            <label for="check-male">Male</label>
          </div>
          <div class="gender">
            <input type="radio" id="check-female" name="gender" required/>
            <label for="check-female">Female</label>
          </div>
          <div class="gender">
            <input type="radio" id="check-other" name="gender" required/>
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
        <input type="text" name=emailadd placeholder="Enter email address"  required/>
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
            <input type="text" name=Emergencynum placeholder="Emergency contact" required/>
          </div>

          <div class="input-box">
            <label>Contact Number<span class = "required">*</span></label>
            <input type="text" name=Emergencynum placeholder="Emergency contact"  required/>
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Occupation<span class = "required">*</span></label>
            <input type="text" name=Occupation placeholder="Occupation"  required/>
          </div>

          <div class="input-box">
            <label>Occupation<span class = "required">*</span></label>
            <input type="text" name=Occupation placeholder="Occupation" required/>
          </div>
        </div>

        <div class="input-box">
          <label>Parents Home Address<span class = "required">*</span></label>
          <input type="text" name=Parents_num placeholder="Enter Address"  required/>
        </div>
        <br>


        <!--EMERGENCY INFORMATIOn-->
        <h2>Emergency Information</h2>
        <div class="column">
          <div class="input-box">
            <label>Name<span class = "required">*</span></label>
            <input type="text" name=Fullname placeholder="Full name" required/>
          </div>
          <div class="input-box">
            <label>Relationship<span class = "required">*</span></label>
            <div class="select-box" required>
              <select name = Relationship>
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
          <input type="text" name=Emergencynum placeholder="Emergency contact"  required/>
        </div>
        <div class="input-box">
          <label>Blood Type</label>
          <div class="select-box">
            <select name =Bloodtype>
              <option hidden>Blood Type</option>
              <option>A Positive (A+)</option>
              <option>A Negative (A-)</option>
              <option>B Positive (B+)</option>
              <option>B Negative (B-)</option>
              <option>AB Positive (AB+)</option>
              <option>AB Negative (AB-)</option>
              <option>O Positive (O+)</option>
              <option>O Negative (O-)</option>
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