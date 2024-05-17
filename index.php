<!DOCTYPE html>
<html>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("assets/inc/navbar.php"); ?>

<?php require_once("assets/inc/banner.php"); ?>
<?php require_once("assets/inc/script.php"); ?>
<?php require_once("function/book-class.php");?>
<?php $category = $book->getCategory(); ?>
<div class="container mt-5" id="category">
	<h5 class="text-center">Top Selling Categories</h5>
  <div class="row mt-5">
  <?php
     
     if (!is_array($category) && !is_object($category)) {
        echo "No data available";
      } elseif (empty($category)) {
    ?>
  <span colspan="6">No data available</span>
           <?php
    } else {
foreach ($category as $bookCat) { ?>
     <div class="col-md-3 col-sm-2 text-center">
      <div class="box">
        <br><br>
        <h5 class="mt-4"><?=$bookCat['category_name']?></h5>
        <a href="#" class="btn mt-5 text-light fw-bold">Browse All</a>
      </div>
     </div>
<?php } }?>
  </div>
</div>
<br><br>
<?php require_once("assets/inc/product_display.php"); ?>

<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
