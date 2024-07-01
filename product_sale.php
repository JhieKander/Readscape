<!DOCTYPE html>
<html>
<?php require_once("function/book-class.php");?>
<?php require_once("function/user-session.php");?>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("assets/inc/navbar.php"); ?>
  <?php $product = $book->productlist(); ?>
  <?php $category = $book->getCategory(); ?>

   <div class="container" id="my-order">
       <div id="mini_user_nav">
       <span class="d-flex">
        <a href="index.php" class="me-1 text-dark home"> Home / </a>
        <a href="#" class="account">Sale</a>
       </span> 
    </div>
     <div class="row mt-5">
    <div class="col-md-4">
        <div id="account_sidebar">
            <nav class="navbar">
                <ul>
                    <form id="filterForm">
                        <h6>Price</h6>
                        <div class="prices">
                            <label class="mt-2">
                                <input type="checkbox" name="price" value="300-500">
                                <span>From ₱300.00 to ₱500</span>
                            </label>
                            <label class="mt-2">
                                <input type="checkbox" name="price" value="500-5000">
                                <span>From ₱500.00 to ₱5,000</span>
                            </label>
                            <label class="mt-2">
                                <input type="checkbox" name="price" value="900-20000">
                                <span>From ₱900.00 to ₱20,000</span>
                            </label>
                        </div>
                        <h6 class="mt-2">Category</h6>
                        <div class="category">
                            <?php if (!is_array($category) && !is_object($category)) { ?>
                                <span>No data available</span>
                            <?php } elseif (empty($category)) { ?>
                                <span>No data available</span>
                            <?php } else { ?>
                                <?php foreach ($category as $bookCat) { ?>
                                    <div>
                                        <label class="mt-2">
                                            <input type="checkbox" name="category" value="<?= $bookCat['category_id'] ?>">
                                            <span><?= $bookCat['category_name'] ?></span>
                                        </label>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </form>
                </ul>
            </nav>
        </div>
    </div>

    <div class="col-md-8" id="product_displaySale">
        <h6>SALE</h6>
        <!-- Products -->
        <section class="py-2">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-3 justify-content-center" id="productsContainer">
                <!-- Product card -->
                <?php if (!is_array($product) && !is_object($product)) { ?>
                    <!-- If $category is not an array or object, output a message indicating an error -->
                    <p>No data available</p>
                <?php } elseif (empty($product)) { ?>
                    <p>No data available</p>
                <?php } else { ?>
                    <?php foreach ($product as $lisproduct) { 
                        $inputDateTime = $lisproduct['date_added'];
                        $dateTime = new DateTime($inputDateTime);
                        $formattedDateTime = $dateTime->format('F j, Y');
                        $formattedtime = $dateTime->format('g:i A');
                    ?>
                    <div class="col-md-4 mb-5 product-card" data-price="<?= $lisproduct['price'] ?>" data-category="<?= $lisproduct['category'] ?>">
                        <div class="card h-100">
                            <!-- "Sale"/"new" badge -->
                            <?php if ($lisproduct['stock'] <= 1) { ?>
                                <div class="badge bg-secondary text-white position-absolute mt-1 text-uppercase">Out of Stock</div>
                            <?php } else { ?>
                                <div class="badge bg-primary text-white position-absolute mt-1 text-uppercase">Sales</div>
                            <?php } ?>
                            <!-- Product image -->
                            <img class="card-img-top" src="assets/images/products/<?= $lisproduct['image'] ?>" alt="...">
                            <!-- Product details  p-4 -->
                            <div class="card-body text-center">
                                <!-- Product name -->
                                <a href="view_product.php?product_id=<?= base64_encode($lisproduct['product_id']) ?>" class="text-dark text-decoration-none"><?= $lisproduct['book_name'] ?></a>
                                <p><?= $lisproduct['book_author'] ?></p>
                                <!-- Product rating -->
                                <div class="d-flex justify-content-center small text-warning my-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-half"></div>
                                    <div class="bi-star"></div>
                                </div>
                                <!-- Product price -->
                                <div class="product-price text-start">
                                    <span class="price ms-2">₱ <?= number_format($lisproduct['price'], 2); ?></span>
                                </div>
                            </div>
                            <!-- Product actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <?php if ($lisproduct['stock'] <= 1) { ?>
                                        <a class="btn btn-outline-dark btn-addtocart mt-auto fw-bold" href="#" role="button"><span class="bi bi-cart4"></span> NOTIFY ME</a>
                                    <?php } else { ?>
                                        <form method="post">
                                            <input type="hidden" name="customer_id" value="<?= $userinfo['user_id']; ?>">
                                            <input type="hidden" name="product_id" value="<?= $lisproduct['product_id']; ?>">
                                            <input type="hidden" name="customerName" value="<?= $userinfo['firstname']; ?> <?= $userinfo['lastname']; ?>">
                                            <input type="hidden" name="transaction" value="<?= $userinfo['user_id']; ?><?= $book->randomcode(10); ?>">
                                            <input type="hidden" name="bookname" value="<?= $lisproduct['book_name']; ?>">
                                            <input type="hidden" name="image" value="<?= $lisproduct['image']; ?>">
                                            <input type="hidden" name="qty" value="1">
                                            <input type="hidden" name="price" value="<?= $lisproduct['price']; ?>">
                                            <input type="hidden" name="total" value="<?= $lisproduct['price']; ?>">
                                            <button type="submit" class="btn btn-outline-dark btn-addtocart mt-auto" name="addOrder" role="button"><span class="bi bi-cart4"></span> Add to cart</button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>
    </div>
</div>

</div>
<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
