<?php
 $pagetitle = "Welcome to Relux Store";
 include_once "Assets/header.php";


$passwordError = "";
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $password = htmlspecialchars(trim($_POST['password']));
  $cpassword = htmlspecialchars(trim($_POST['cpassword']));

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

 }
?>

<main class="contain_fluid">
  <h1>Hello Guys</h1>
          <form action="" method="post">
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
                   <span class="text-danger"><?= $passwordError?></span>
                <div class="d-flex justify-content-end pt-3">
                  <input  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" value="Register"/>
                </div>
          </form>
</main>


