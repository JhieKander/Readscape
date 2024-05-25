<!DOCTYPE html>
<html>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("function/book-class.php");?>
<?php require_once("assets/inc/navbar.php"); ?>

<br><br>
<?php $book->registration();?>
<div class="container" id="registration">
   <div class="row">
     <div class="col-4"></div>
     <div class="col-5  bg-register">
       <h5 class="text-center fw-bold fs-5">Create New Account</h5>
        <form method="POST" id="registration" onsubmit="return validateForm()">
          <input type="hidden" name="access" value="user">    
        <div class="row">
              <p class="text-start">Fill Personal Information</p>
              <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control input-fill" required>
              </div>
              <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control input-fill" required>
              </div>
                <div class="col-md-12">
                <label>Birth Date</label>
                <input type="date" name="birthdate" class="form-control input-fill" required>
              </div>
              <div class="col-md-12">
                <label>Phone Number</label>
                <input type="text" name="phonenumber" class="form-control input-fill" required>
              </div>
              <div class="col-md-12">
                <label>Email</label>
                <input type="email" name="email" class="form-control input-fill" required>
              </div>
              <div class="col-md-12">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control input-fill" required>
              </div>
              <span class="text-danger" id="error"></span>
              <div class="col-md-12">
                <label>Confirm Password</label>
                <input type="password" name="cpass" id="cpass" class="form-control input-fill" required>
              </div>
            

              <div class="col-md-12 text-center mt-4">
                 <button type="submit" name="registration"  class="register-submit btn btn-submit fs-5 text-light">Register</button>
              </div>

            </div>
        </form>
        <hr>
     </div>
     <div class="col-2"></div>

   </div>
</div>
<script>
  function validateForm(){
    var password = document.getElementById("password").value;
    var cpassword = document.getElementById("cpass").value;

    if(password != cpassword){
       document.getElementById("error").innerHTML = "Password not match.";
       return false;
    }
    return true;


  }
</script>

<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
