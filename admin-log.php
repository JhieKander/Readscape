<!DOCTYPE html>
<html>
<?php require_once("function/book-class.php"); ?>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("assets/inc/admin-nav.php"); ?>
<hr>
<?php $book->adminlogin();?>
<div class="container mt-5" id="admin-log">
  <div class="row">
    <div class="col-4"></div>
    <div class="col-4" id="form">
       <h6>ADMIN LOGIN</h6>
      <form action="" method="POST">
          <div class="row">
            <div class="col-md-12">
              <label for="">Email</label>
              <input type="email" name="email" class="form-control mt-1" required>
            </div>
            <div class="col-md-12 mt-4">
              <label for="">Password</label>
              <input type="password" name="passlog" class="form-control mt-1" required>
            </div>
            <div class="col-md-12 text-center">
               <button type="submit" name="admin-log" class="btn login mt-3 fw-bold text-light">LOGIN</button>
            </div>
            <div class="col-md-12 text-center">
               <a href="#" class="nav-link fw-bold">Forgot Password?</a>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>


<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
