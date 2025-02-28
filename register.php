<?php
 $pagetitle = "Sign Up";
 include_once "Assets/header.php";
 include_once "Assets/db_connect.php";

//  Initializing Variables Values
$msg = "Registration";
$filename = $lastname = $email = $tel="";
$emailError = $passwordError = $phoneError =  "";


//  Capturing your entries

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $file = $_FILES['user_image'];
  $firstname = htmlspecialchars(trim($_POST['firstname']));
  $lastname = htmlspecialchars(trim($_POST['lastname']));
  $email = htmlspecialchars(trim($_POST['email']));
  $password = htmlspecialchars(trim($_POST['password']));
  $cpassword = htmlspecialchars(trim($_POST['cpassword']));
  $tel = htmlspecialchars(trim($_POST['tel']));
  $gender = htmlspecialchars(trim($_POST['gender']));
  $role = htmlspecialchars(trim($_POST['role']));

  // User Image Validation
  $filesize = 3 * 1024 * 1024;
  if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/jpg') {
    if($file['size'] <= $filesize) {
      $filename = uniqid('user_image_') . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
      $fileLocation = "users_pictures/" .$filename;
      move_uploaded_file($file['tmp_name'], $fileLocation);
      echo "Upload Successfully";
    } else {
      $fileLocation = "";
    }
  } else {
    $fileLocation = "";
  }

  //  Validating Email Address
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = 'Email address not valid';
  }

  // Password and Confirm Password Validation
  if($password == $cpassword) {
    if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}$/', $password)) {
      $hashpassword = password_hash( $password, PASSWORD_DEFAULT );
    } else {
      $passwordError = "Password must contain at least one uppercase, lowercase, and number with at least 8 character long";
    }
  } else {
    $passwordError = "Passwords do not match";
  }

  //  Validating Phone Number
  if(!preg_match ('/^0[789][01]\d{8}$|\^+234[789][01]\d{8}$/', $tel)) {
    $phoneError = "Invalid Phone Number";
  }
 
  // Database Population
  if($emailError == "" && $phoneError == "" && $passwordError == "") {
    $verification_token = bin2hex(random_bytes(32));
    $query = "INSERT INTO `users`(firstname, lastname, email, password, phone_number, gender, user_level, user_image, verification_code) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssss", $firstname, $lastname, $email, $hashpassword, $tel, $gender, $role, $fileLocation, $verification_token);
    if($stmt->execute()) {
     move_uploaded_file($file['tmp_name'], $fileLocation);
     $firstname = $lastname = $email = $tel = "";
     $msg ="<span class='text-succes'> Registration Successful </span>";
    } else{
      $msg= "<span class='text-danger'>Registration Failed </span>";
    }

    }else {
      $msg= "<span class='text-danger'>Registration Failed </span>";
    }
}

?>

<section class="h-100 bg-dark">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card card-registration my-4">
          <div class="row g-0">
            <div class="col-xl-6 d-none d-xl-block">
              <img src="b.jpg"
                alt="Sample photo" class="img-fluid"
                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
            </div>
            <div class="col-xl-6">
             <form action="" method="post" enctype="multipart/form-data">
              <div class="card-body p-md-5 text-black">
                <h3 class="mb-5 text-uppercase"> <?= $msg ?> </h3>

                 <!-- User Image Preview -->
                  <div class="form-outline-mb-4">
                    <img class="form-control form-control-lg" alt=" User Image" src="users_pictures/avatar.jpg" id="imagePreview"/>
                    <label  class="form-label" id="upload_label">Upload User Image</label>
                    <input type="file" id="user_upload" class="form-control form-control-lg" name="user_image"/>

                  </div>

                <!-- Firstname & Lastname Capturing -->
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" id="form3Example1m" class="form-control form-control-lg" name="firstname"  required/>
                      <label class="form-label" for="form3Example1m">First name</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" id="form3Example1n" class="form-control form-control-lg" name="lastname" required/>
                      <label class="form-label" for="form3Example1n">Last name</label>
                    </div>
                  </div>
                </div>

                  <!-- E-mail Capturing -->
                  <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" id="form3Example9" class="form-control form-control-lg"
                  name="email"  />
                  <label class="form-label" for="form3Example9">Email ID</label>
                </div>

                  <!-- Password & Confirm Password Capturing-->
                  <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="password" id="form3Example1m" class="form-control form-control-lg" name="password" required/>
                      <label class="form-label" for="form3Example1m">Password</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="password" id="form3Example1n" class="form-control form-control-lg" name="cpassword" required/>
                      <label class="form-label" for="form3Example1n">Confirm Password</label>
                    </div>
                  </div>
                </div>

                  <!--Phone Number Capturing -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="tel" id="form3Example9" class="form-control form-control-lg" name="tel"  required/>
                  <label class="form-label" for="form3Example9">Phone Number</label>
                </div>

                  <!-- Gender Capturing -->
                <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                  <h6 class="mb-0 me-4">Gender: </h6>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="form-check-input" type="radio" id="femaleGender"
                      value="Female" name="gender" />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="form-check-input" type="radio"  id="maleGender"
                      value="Male" name="gender" />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>

                  <div class="form-check form-check-inline mb-0">
                    <input class="form-check-input" type="radio" id="otherGender"
                      value="Other" name="gender" />
                    <label class="form-check-label" for="otherGender">Other</label>
                  </div>

                </div>

                  <!-- User Role Capturing -->
                <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                  <h6 class="mb-0 me-4">Role: </h6>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="form-check-input" type="radio" id="user"
                      value="user" name="role" />
                    <label class="form-check-label" for="user">User</label>
                  </div>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="form-check-input" type="radio"  id="vendor"
                      value="vendor" name="role" />
                    <label class="form-check-label" for="vendor">Vendor</label>
                  </div>
                </div>
                  
               

                

                

                <div class="d-flex justify-content-end pt-3">
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-light btn-lg">Reset all</button>
                  <input  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" value="Register"/>
                </div>

              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>