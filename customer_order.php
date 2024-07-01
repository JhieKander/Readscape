<!DOCTYPE html>
<html>
<?php require_once("function/book-class.php");?>
<?php require_once("function/user-session.php");?>
  <?php require_once("assets/parts/user-head.php"); ?>
<body>
<?php require_once("assets/inc/navbar.php"); ?>

   <div class="container" id="my-order">
       <div id="mini_user_nav">
       <span class="d-flex">
        <a href="index.php" class="me-1 text-dark home"> Home / </a>
        <a href="#" class="account"> My Orders</a>
       </span> 
    </div>
     

<div class="row mt-5">
    <div class="col-md-4">
       <?php require_once("assets/inc/user_sidebar.php"); ?>
    </div>

    <div class="col-md-8 mt-5">
         <h5>My Orders</h5>
    <br>  

    <div class="row">
          <div class="col-6">
          
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for orders..">
      
          </div>

          <div class="col-6" >
              <button style="padding: 5px 10px; width: 125px; border-radius: 5px;" class=" btn-recieve">RECEIVED</button>
          </div>

    </div>


<table class="table mt-5" id="myTable">
    <thead>
        <tr>
            <td class="fw-bold">Image</td>
            <td class="fw-bold">Book Name</td>
            <td class="fw-bold">Price</td>
            <td class="fw-bold">Quantity</td>
            <td class="fw-bold">Total</td>
            <td class="fw-bold">Status</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
  <?php 
    $customer_id = $userinfo['user_id'];
     $order = $book->getOrder($customer_id);
   ?>


        <?php
        if (!is_array($order) && !is_object($order)) {
            echo "No data available";
        } elseif (empty($order)) {
            ?>
            <tr>
                <td colspan="6">No order</td>
            </tr>
            <?php
        } else {
            foreach ($order as $myorder) { ?>
                <?php if($myorder['status'] == "Order Placed"){ ?>
                <tr>
                    <td><a href="#" class="text-decoration-none text-dark" style="color: #735844;">
                       <img class="img-fluid" src="assets/images/products/<?=$myorder['image']?>" alt="..." width="50">
                    </a></td>
                    <td><a href="#" class="text-decoration-none text-dark" style="color: #735844;"><?=$myorder['item']?></a></td>
                    <td><a href="#" class="text-decoration-none" style="color: #735844;">₱ <?= number_format($myorder['price'], 2);?></a></td>
                    <td><a href="#" class="text-decoration-none text-dark" style="color: #735844;"><?=$myorder['qty']?></a></td>
                    <td><a href="#" class="text-decoration-none" style="color: #735844;"><?php $total = $myorder['qty'] * $myorder['price']; echo number_format($total,2); ?></a></td>
                    <td><a href="#" class="text-decoration-none" style="color: #936527;"><?=$myorder['status']?></a></td>
                    <td>
                      <form method="POST" onsubmit="return removeItem(this);">
                          <input type="hidden" name="item_id" value="<?= $myorder['product_id']; ?>">
                          <button type="submit" name="remove_item" class="btn btn-danger">Remove</button>
                      </form>
                    </td>
                </tr>
                <?php }?>
            <?php }
        }
        ?>
      <?php if($myorder['status'] == "Review"){ ?>  
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

      </tr>
      <?php } ?>
    </tbody>

</table>

<script>
function myFunction() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Start at 1 to skip the header row
        tr[i].style.display = "none"; // Initially hide the row
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break; // If a match is found in any cell, show the row and break the loop
                }
            }
        }
    }
}

function removeItem(form) {
                if (confirm('Are you sure you want to remove this item?')) {
                    var formData = new FormData(form); // Gather form data
                    var xhr = new XMLHttpRequest();

                    xhr.open('POST', 'remove_from_order.php', true);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            console.log('Item removed successfully');
                            // Optionally, update UI (remove table row, update summary, etc.)
                            window.location.reload(); // Example: Reload page after removal
                        } else {
                            console.error('Error removing item');
                        }
                    };
                    xhr.onerror = function () {
                        console.error('Network error occurred');
                    };
                    xhr.send(formData);

                    return false; // Prevent default form submission
                }
                return false; // If user cancels
            }

</script>
    </div>
</div>



   </div>


<?php require_once("assets/inc/footer.php"); ?>

 <?php require_once("assets/parts/user-bottom.php"); ?>
