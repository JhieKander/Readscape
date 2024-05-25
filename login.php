<!DOCTYPE html>
<html>
<?php require_once("function/book-class.php"); ?>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("assets/inc/navbar.php"); ?>
<br>
<div class="container" id="login">
  <div id="mini_user_nav">
   <span class="d-flex">
    <a href="#" class="me-1 text-dark home"> Home / </a>
    <a href="login.php" class="account"> My Account</a>
   </span>
</div>
<div class="row mt-5">
      <div class="col-0"></div>
      <div class="col-md-5 me-5 login-form">
        <h5 class="text-center">Registered Customer</h5>
        <p class="text-center">If you have an account, sign  in with you email address.</p>
         <br>
         <form method="post" action="">
            <div class="row">
               <input type="hidden" name="access" value="customer">
              <div class="col-md-12">
               <label for="email">Email</label>
                  <input type="email" name="email" class="form-control input-fill">
               </div>
               
               <div class="col-md-12 mt-4">
               <label for="email">Password</label>
                  <input type="password" name="passlog" class="form-control input-fill">
               </div>

               <div class="col-md-12 text-center mt-3">
                 <button type="submi" name="user-log" 
                 class="user-log btn btn-submit text-uppercase text-light">
                  Login</button>
              </div>

              <div class="col-md-12 text-center mt-3">
                  <a href="#" class="nav-link">Forgot Password ?</a>
              </div>

            </div>
         </form>
      </div>
      <div class="col-md-5 text-center">
        <h5>New Customer?</h5> 
          <p>Creating an account has many benefits: check out faster, keep more than one address, track orders and more.</p>
            <a href="register.php" class="btn-createAccount btn btn-submit mt-3 text-light">CREATE AN ACCOUNT</a>
        </div>
   </div>
</div>


<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
