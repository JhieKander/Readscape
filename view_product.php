<!DOCTYPE html>
<html>
<?php require_once("function/book-class.php");?>
<?php require_once("function/user-session.php");?>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("assets/inc/navbar.php"); ?>

<?php require_once("assets/inc/script.php"); ?>
<?php 
$product_id = base64_decode($_GET['product_id']);
$productInfo = $book->prouductInfo($product_id);
$book->addToCart();
$book->cartAdd();
$code = $book->randomcode(10);

 ?>
<div class="container" id="viewProducts">
<?php   foreach ($productInfo as $getSingleProduct) {  ?>
	<div id="mini_user_nav">
   <span class="d-flex">
    <a href="index.php" class="me-1 text-dark home"> Home / </a>
    
    <a href="#" class="account"><?=$getSingleProduct['book_name'];?></a>
   </span>
</div>
   
   <div class="row mt-5">
     <div class="col-6">
       <div class="d-flex">
          <div class="product-image">
             <img style="margin-left: 20px; margin-right: 100px; width: 300px; height: 175px;" src="assets/images/products/<?=$getSingleProduct['image']?>" class="img-fluid">
          </div>
          <div class="product-info" style="margin-left: 50px;">
           
             <div class="product_info">
                 <h4 class="fw-bold"><?=$getSingleProduct['book_name'];?></h4>
                 <p class="fw-bold">By <?=$getSingleProduct['book_author'];?></p>
                 <p> <i class="fa fa-star text-warning" aria-hidden="true"></i> <i class="fa fa-star text-warning" aria-hidden="true"></i> <i class="fa fa-star text-warning" aria-hidden="true"></i> <i class="fa fa-star text-warning" aria-hidden="true"></i> <span>0.0</span></p>
                 <h4 class="fw-bold">₱ <?= number_format($getSingleProduct['price'],2);?></h4>
          
             </div>

            <form method="POST" class="d-flex">
             <div class="d-flex mt-5">
              <button type="button" class="btn value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
              <input style="width: 50px;" type="number" id="number" name="qty" value="1" class="form-control" />
              <button type="button" class="btn value-button" id="increase" onclick="increaseValue()" value="Increase Value"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
               
               <!-- user information -->
               <input type="hidden" name="customer_id" value="<?=$userinfo['user_id']?>">
               <input type="hidden" name="customerName" value="<?=$userinfo['firstname'];?> <?=$userinfo['lastname'];?>">
               <input type="hidden" name="transaction" value="<?=$userinfo['user_id'];?><?=$code?>">
              <!-- product info -->
               <input type="hidden" name="product_id" value="<?=$getSingleProduct['product_id'];?>">
               <input type="hidden" name="bookname" value="<?=$getSingleProduct['book_name'];?>">
               <input type="hidden" name="bookauthor" value="<?=$getSingleProduct['book_author'];?>">
               <input type="hidden" name="image" value="<?=$getSingleProduct['image'];?>">
               <input type="hidden" name="price" value="<?=$getSingleProduct['price'];?>">
                <input type="hidden" name="total" value="0"> 

              </div>


              <button type="submit" name="addCart" class="btn btn-submit mt-5 text-light" style="width: 150px; height: 35px; border: 1px solid #C9A292;">ADD TO CART</button>
              <button type="submit" name="addOrder" class="btn btn-submit mt-5 text-light" style="width: 135px; height: 35px; margin-left: 15px; ">BUY NOW</button>
            </form>

          </div>
       </div>
     </div>

     <div class="col-6" style="margin-left: 80px; width: 490px; text-align: justify;">
         <h6 class="fw-bold">Synopsis:</h6>
        <p><?=$getSingleProduct['story_summary'];?></p>
     </div>
      
   </div>
  <hr style="color: #D7B9A9; font-weight: bold;">
  <?php } ?>
  <div class="row" id="reviews">
    <h4>Reviews</h4>
    <label>Customer Name | <i class="fa fa-star text-warning" aria-hidden="true"></i>  <i class="fa fa-star text-warning" aria-hidden="true"></i>  <i class="fa fa-star text-warning" aria-hidden="true"></i>
 mm/dd/yy</label>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
  </div>
</div>

<script>
 function increaseValue() {
  var value = parseInt(document.getElementById('number').value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById('number').value = value;
}

function decreaseValue() {
  var value = parseInt(document.getElementById('number').value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById('number').value = value;
}
</script>

<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
