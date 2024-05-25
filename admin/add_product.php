<!DOCTYPE html>
<html>
  <?php require_once("../assets/parts/admin-head.php"); ?>
<body>
<?php require_once("../assets/inc/admin-nav.php"); ?>
<hr>
<?php require_once("../function/admin-session.php"); ?>
<?php require_once("../assets/inc/admin-sidebar.php"); ?>
<?php 
$code = $book->randomcode(8);
$category = $book->getCategory();
$book->product();
$book->addtionalImageProduct();
?>
<div class="col py-3">
             <div class="container-fluid content">
               <h5>Add Products</h5>
                 <div class="row">
                  <div class="col-md-1"></div>
                  <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-12">
                        <input type="hidden" name="encodeby" value="<?=$admininfo['firstname']?> <?=$admininfo['lastname']?> ">
                         <label>Product Code</label>
                         <input type="text" name="productcode" class="text-danger fw-bold form-control input-fill" required value="<?=$code?>">
                       </div>

                       <div class="col-md-6">
                         <label>Product Name</label>
                         <input type="text" name="productname" class="form-control input-fill" required>
                       </div>

                       <div class="col-md-6">
                         <label>Categories</label>
                         <select name="category" class="form-control input-fill">
                           <?php foreach ($category as $bookCat) { ?>
                           <option value="<?=$bookCat['category_id']?>"><?= $bookCat['category_name'];?></option>
                          <?php } ?>
                         </select>
                       </div>

                      <div class="col-md-6">
                         <label>Types of Book</label>
                         <select name="typebook" class="form-control input-fill">
                           <option value="trending">Trending</option>
                           <option value="NR">New Releases</option>
                           <option value="NA">New Arrivals</option>
                         </select>
                       </div>
                          <div class="col-md-6">
                          <label>Price</label>
                            <input type="number" name="price" class="form-control input-fill">
                          </div>

                        <div class="col-md-12 mt-2">
                          <label>Product Description</label>
                          <textarea name="description" class="form-control input-fill">
                          </textarea>
                        </div>

                        <div class="col-md-12">
                          <label>Product Image</label>
                          <div id="inputs">
                              <div class="input-group">
                                
                                <input type="file" name="displayimage" class="form-control input-fill" required>
                            
                            </div>
                          </div>
                            <button type="button"  id="addImage" class="btn-success mt-2" ><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>

                        <div class="col-md-12 text-center mt-2">
                             <button type="submit" name="productadd" class="text-light btn btn-submit" style="width: 300px">Add
                             </button>
                        </div>
                    </div>
                    <hr>
                  </form>
                 </div>
             </div>
        </div>
    </div>
</div>



  <?php require_once("../assets/inc/footer.php"); ?>

 <?php require_once("../assets/parts/admin-bottom.php"); ?>
