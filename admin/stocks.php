<!DOCTYPE html>
<html>
  <?php require_once("../assets/parts/admin-head.php"); ?>
<body>
<?php require_once("../assets/inc/admin-nav.php"); ?>
<hr>
<?php require_once("../function/admin-session.php"); ?>

<?php require_once("../assets/inc/admin-sidebar.php"); ?>

<div class="container col py-3">
        <div class="container-fluid content stocks" id="category">
            <h5>Stocks Report</h5>
            <?php 
            $product = $book->productlist();
             $book->addStocks();
             ?>
    <div class="card-body">
     <div class="row">
          <div class="col-md-4">
             <form class="mb-3" id="searchData">
                <input type="text" id="searchBox" name="searchBox" class="form-control input-fill" required placeholder="Search Book Name">
                <small class="form-text feedback"></small>
             </form>
          </div>
          <div class="col-md-4"></div>
          <div class="col-md-4">
             <a href="stockReport.php" class="btn mt-3 fw-bold stocks_intory">Stocks Inventory</a>
          </div>
     </div>
      <table class="table table-searchable table-striped table-bordered table-hover table-responsive mt-2">
        <thead>
          <tr>
            <th>Product Code</th>
           <th>Book Name</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if (!is_array($product) && !is_object($product)) {
                          // If $category is not an array or object, output a message indicating an error
                          echo "No data available";
                      } elseif (empty($product)) {
                      ?>
                          <tr>
                  <td colspan="6">No data available</td>
              </tr>
          <?php
          } else {
              foreach ($product as $lisproduct) {
                  $inputDateTime = $lisproduct['date_added'];
                  $dateTime = new DateTime($inputDateTime);
                  $formattedDateTime = $dateTime->format('F j, Y');
                  $formattedtime = $dateTime->format('g:i A');
              ?>
                  <tr>
                      <td><?= $lisproduct['bookcode'] ?></td>
                      <td><?= $lisproduct['book_name'] ?></td>
                      <td>
                         <?php if($lisproduct['stock'] <= 1){ ?>
                              <label class="bg-danger rounded text-light fw-bold">Out of Stock</label>
                          <?php }else { ?>
                            <?= $lisproduct['stock'] ?>
                          <?php } ?>


                      </td>
 
                      <td data-searchable="false">
                          <form method="POST">
                           <input type="hidden" name="product_id" value="<?= $lisproduct['product_id']?>">
                           <div class="btn-group btn-group-sm d-flex" role="group">
                                  <input type="number" name="qty" class="form-control input-fill me-2" placeholder="qty" required style="width: 120px;">
                                    <button type="submit" name="add" class="btn btn-outline-success me-2"><i class="fas fa-plus"></i></button>


                                  </div>
                          </form>
                      </td>
                  </tr>
          <?php
              }
          }
          ?>

        </tbody>
      </table>
               
         </div>
   
                 </div>
             </div>
             <!-- end of contaier col py -->
        </div>
    </div>
</div>




 <?php require_once("../assets/inc/admin-footer.php"); ?>
 <?php require_once("../assets/parts/admin-bottom.php"); ?>
