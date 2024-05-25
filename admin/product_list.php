<!DOCTYPE html>
<html>
  <?php require_once("../assets/parts/admin-head.php"); ?>
<body>
<?php require_once("../assets/inc/admin-nav.php"); ?>
<hr>
<?php require_once("../function/admin-session.php"); ?>

<?php require_once("../assets/inc/admin-sidebar.php"); ?>

<div class="container col py-3">
        <div class="container-fluid content" id="category">
            <h5>Product Listings</h5>
            <?php $product = $book->productlist(); ?>
    <div class="card-body">
      <form class="mb-3" id="searchData">
        <label for="searchBox">Search table</label>
        <input type="text" id="searchBox" name="searchBox" class="form-control" required>
        <small class="form-text feedback"></small>
      </form>
      <table class="table table-searchable table-striped table-bordered table-hover table-responsive">
        <thead>
          <tr>
            <th>#</th>
            <th>Product Code</th>
            <th>Image</th>
            <th>Book Name</th>
            <th>Type Book</th>
            <th>Price</th>
            <th>Ecoded By</th>
            <th>Date</th>
            <th>Time</th>

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
                      <td><?= $lisproduct['product_id'] ?></td>
                      <td><?= $lisproduct['bookcode'] ?></td>
                      <td><img src="../assets/images/products/<?= $lisproduct['image']?>" width="90"></td>
                      <td><?= $lisproduct['book_name'] ?></td>
                      <td><?= $lisproduct['type_book'] ?></td>
                      <td><?= $lisproduct['price'] ?></td>
                      <td><?= $lisproduct['added_by'] ?></td>

                      <td><?= $formattedDateTime ?></td>
                      <td><?= $formattedtime ?></td>
                      <td data-searchable="false">
                          <div class="btn-group btn-group-sm" role="group">
                              <button type="button" class="btn btn-outline-primary me-2"><i class="fas fa-pen"></i></button>
                              <button type="button" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                          </div>
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
