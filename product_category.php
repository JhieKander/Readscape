<!DOCTYPE html>
<html>
<?php require_once("function/book-class.php");?>
<?php require_once("function/user-session.php");?>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("assets/inc/navbar.php"); ?>

<?php require_once("assets/inc/script.php"); ?>
<div class="container">
	<div id="mini_user_nav">
   <span class="d-flex">
    <a href="index.php" class="me-1 text-dark home"> Home / </a>
    <a href="#" class="account">Sale</a>
   </span>
</div>
</div>

<?php  
  $category_id = base64_decode($_GET['category_id']);
  $viewCategory = $book->getviewCatProudct($category_id);

 ?>

<!-- Products -->
<section class="py-2">
  <div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
      <!-- Product card -->
       <?php
     
     if (!is_array($viewCategory) && !is_object($viewCategory)) {
        echo "No data available";
      } elseif (empty($viewCategory)) {
    ?>
  <span colspan="6">No data available</span>
           <?php
    }else {
          foreach ($viewCategory as $productCat) { 
         ?>


      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <!-- "Sale"/"new" badge -->
          <?php if($productCat['stock'] <= 1){ ?>
          <div class="badge bg-secondary text-white position-absolute mt-1 text-uppercase">Out of Stock</div>
          <?php } else{ ?>
                <div class="badge bg-primary text-white position-absolute mt-1 text-uppercase">Sales</div>
           <?php } ?>
          <!-- Product image -->
          <img class="card-img-top" src="assets/images/products/<?=$productCat['image']?>" alt="...">
          <!-- Product details  p-4 -->
          <div class="card-body text-center">
            <!-- Product name -->
            <a href="view_product.php?product_id=<?=base64_encode($productCat['product_id'])?>" class="text-dark text-decoration-none"><?=$productCat['book_name']?></a>
            <p><?=$productCat['book_author']?></p>
            <!-- Product raiting -->
            <div class="d-flex justify-content-center small text-warning my-2">
              <div class="bi-star-fill"></div>
              <div class="bi-star-fill"></div>
              <div class="bi-star-fill"></div>
              <div class="bi-star-half"></div>
              <div class="bi-star"></div>
            </div>
            <!-- Product price -->
            <div class="product-price text-start">
<!--               <span class="text-muted text-decoration-line-through price-old">₱ 0,000.00</span>
 -->              <span class="price ms-2">₱ <?= number_format($productCat['price'],2);?></span>
            </div>
          </div>
          <!-- Product actions -->
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
             <?php if($productCat['stock'] <= 1){ ?>
              <a class="btn btn-outline-dark btn-addtocart mt-auto fw-bold" href="#" role="button" ><span class="bi bi-cart4"></span> NOTIFY ME</a>
              <?php }else { ?>
                   <?php 
                   $code = $book->randomcode(10);
                   $book->addToCart();
                   ?>

                   <form method="post">
                          <input type="hidden" name="customer_id" value="<?=$userinfo['user_id'];?>">
                          <input type="hidden" name="product_id" value="<?=$productCat['product_id'];?>">
                          <input type="hidden" name="customerName" value="<?=$userinfo['firstname'];?> <?=$userinfo['lastname'];?> ">
                          <input type="hidden" name="transaction" value="<?=$userinfo['user_id'];?><?=$code?>">
                          <input type="hidden" name="bookname" value="<?=$productCat['book_name'];?>">
                          <input type="hidden" name="image" value="<?=$productCat['image'];?>">
                          <input type="hidden" name="qty" value="1">
                          <input type="hidden" name="price" value="<?=$productCat['price'];?>">
                          <input type="hidden" name="total" value="<?=$productCat['price'];?>">   
                            
                          <button type="submit"  class="btn btn-outline-dark btn-addtocart mt-auto" name="addOrder" role="button" ><span class="bi bi-cart4"></span> Add to cart</button>

                   </form>

              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <?php } }?>
    </div>
  </div>
</section>


<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
