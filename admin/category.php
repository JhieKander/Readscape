<!DOCTYPE html>
<html>
  <?php require_once("../assets/parts/admin-head.php"); ?>
<body>
<?php require_once("../assets/inc/admin-nav.php"); ?>
<hr>
<?php require_once("../function/admin-session.php"); ?>

<?php require_once("../assets/inc/admin-sidebar.php"); ?>
   <?php
    $book->addCategory();
    $book->archiveCategory();
    ?>
  <?php $category = $book->getCategory();?>

<div class="container col py-3">
        <div class="container-fluid content" id="category">
            <h5>Categories</h5>
                <div class="row">
                  <div class="col-md-1"></div>
               
                  <form method="POST" action="">
                    <div class="row">
                       <div class="col-md-5">
                          <input type="hidden" name="encoder" value="<?=$admininfo['firstname']?> <?=$admininfo['lastname']?> ">
                          <input class="form-control" type="text" name="category" placeholder="Enter a Category" required>
                        </div>
                        <div class="col-md-5">
                            <button type="submit" name="add_cat" class=" text-light btn btncategory">Add Category</button>
                        </div>
                    </div>
                  </form>
                 </div>

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
            <th>Category Name</th>
            <th>Encoder</th>
            <th>Date</th>
            <th>Time</th>
    
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if (!is_array($category) && !is_object($category)) {
                          // If $category is not an array or object, output a message indicating an error
                          echo "No data available";
                      } elseif (empty($category)) {
                      ?>
                          <tr>
                  <td colspan="6">No data available</td>
              </tr>
          <?php
          } else {
              foreach ($category as $bookCat) {
                  $inputDateTime = $bookCat['date_add'];
                  $dateTime = new DateTime($inputDateTime);
                  $formattedDateTime = $dateTime->format('F j, Y');
                  $formattedtime = $dateTime->format('g:i A');
              ?>
                  <tr>
                      <td><?= $bookCat['category_id'] ?></td>
                      <td><?= $bookCat['category_name'] ?></td>
                      <td><?= $bookCat['encoded_by'] ?></td>
                      <td><?= $formattedDateTime ?></td>
                      <td><?= $formattedtime ?></td>
                      <td data-searchable="false">
                          <form method="POST">
                          <input type="hidden" name="category_id" value="<?=$bookCat['category_id']?>"> 
                          <div class="btn-group btn-group-sm" role="group">
                             <a href="category_edit.php?category_id=<?= base64_encode($bookCat['category_id'])?>" class="btn btn-outline-primary me-2"><i class="fas fa-pen"></i></a>

                              <button type="submit" name="archive" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
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
