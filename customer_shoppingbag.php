<!DOCTYPE html>
<html>
<?php 
require_once("function/book-class.php");
require_once("function/user-session.php");
require_once("assets/parts/user-head.php");

ob_start(); // Start output buffering for session handling
?>

<body>
<?php require_once("assets/inc/navbar.php"); ?>

<div class="container" id="my-order">
    <div id="mini_user_nav">
        <span class="d-flex">
            <a href="index.php" class="me-1 text-dark home"> Home / </a>
            <a href="#" class="account"> My Shopping Bag</a>
        </span>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <?php require_once("assets/inc/user_sidebar.php"); ?>
        </div>

        <div class="col-md-8 mt-5">
            <h5>My Shopping Bag</h5>

            <table class="table mt-5" id="myTable" style="border: 1px solid lightgray; box-shadow: 5px 10px lightgray; border-radius: 10px;">
                <thead style="border: 1px solid lightgray; border-radius: 10px;">
                    <tr style="border: 1px solid lightgray; border-radius: 10px;">
                        <td class="fw-bold"></td>
                        <td class="fw-bold">Image</td>
                        <td class="fw-bold">Book Name</td>
                        <td class="fw-bold">Quantity</td>
                        <td class="fw-bold">Price</td>
                        <td class="fw-bold">Subtotal</td>
                        <td class="fw-bold">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $customer_id = $userinfo['user_id'];
                    $order = $book->getCart($customer_id);
                    $products = $book->productlist();

                    if (!is_array($order) && !is_object($order)) {
                        echo "No data available";
                    } elseif (empty($order)) {
                        ?>
                        <tr>
                            <td colspan="7">No order</td>
                        </tr>
                        <?php
                    } else {
                        foreach ($order as $index => $myorder) {
                            $productDetails = array_filter($products, function ($product) use ($myorder) {
                                return $product['book_name'] == $myorder['item'] && $product['book_author'] == $myorder['author'] && $product['price'] == $myorder['price'] && $product['image'] == $myorder['image'] && $product['product_id'] == $myorder['product_id'];
                            });

                            // Assuming $productDetails contains one matching product (adjust based on your data structure)
                            $productDetail = reset($productDetails);
                         ?>
                            <tr>
                                <td style="text-align: center;">
                                    <input style="margin-top: 30px; margin-left: 10px;" type="checkbox" name="selectedItem[]" onchange="handleCheckboxClick(this)" value="<?= $index ?>" data-title="<?= $myorder['item'] ?>" data-author="<?= $myorder['author'] ?>" data-price="<?= $myorder['price'] ?>" data-image="<?= $myorder['image'] ?>" data-id="<?= $myorder['product_id']?>" >
                                </td>
                                <td>
                                    <a href="#" class="text-decoration-none text-dark" style="color: #735844;">
                                        <img class="img-fluid" src="assets/images/products/<?=$myorder['image']?>" alt="..." width="50">
                                    </a>
                                </td>
                                <td style="width: 150px; text-align: center;">
                                    <a href="#" class="text-decoration-none text-dark" style="color: #735844;"><?=$myorder['item']?></a>
                                </td>
                                <td style="width: 125px; text-align: center;">
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <button style="margin: 0 5px; font-size: 12px;" type="button" class="btn value-button" onclick="changeQuantity(this, -1)" value="Decrease Value"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                        <input value="<?=$myorder['qty']?>" style="text-align: center; width: 40px; font-size: 12px;" type="text" name="qty[]" class="form-control" min="1" onchange="updateSubtotal(this)" />
                                        <button style="margin: 0 5px; font-size: 12px;" type="button" class="btn value-button" onclick="changeQuantity(this, 1)" value="Increase Value"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    </div>
                                </td>
                                <td>₱ <?= number_format($myorder['price'], 2);?></td>
                                <td class="subtotal">₱ <?= number_format($myorder['qty'] * $myorder['price'], 2); ?></td>
                                <td>
                                    <form method="POST" onsubmit="return removeItem(this);">
                                        <input type="hidden" name="item_id" value="<?= $myorder['product_id']; ?>">
                                        <button type="submit" name="remove_item" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    }
                    ?>
                </tbody>
            </table>

            <div id="order-summary" style="border: 1px solid lightgray; box-shadow: 5px 10px lightgray; border-radius: 10px; padding: 25px 50px; width: 350px; margin-left: 385px; margin-top: 20px;">
                <h5>Cart Summary</h5>
                <br>
                <h6>Subtotal:</h6>
                <h6 style="margin-left: 150px;" id="subtotal">₱ 0.00</h6>

                <h6>Shipping Fee:</h6>
                <h6 style="margin-left: 150px;">₱ 50.00</h6>

                <h6>Total Fee:</h6>
                <h6 style="margin-left: 150px; color: green;" id="total">₱ 0.00</h6>
                <br>
                <form action="process_checkout.php" method="POST" id="checkoutForm">
                    <div id="hiddenInputs"></div>
                    <button type="button" onclick="prepareCheckout()" style="margin-left: 175px;" class="btn btn-success">Checkout</button>
                </form>
            </div>

            <script>
            function changeQuantity(button, delta) {
                var quantityInput = button.parentNode.querySelector('input[name="qty[]"]');
                var newQuantity = parseInt(quantityInput.value) + delta;
                if (newQuantity < 1) newQuantity = 1;
                quantityInput.value = newQuantity;

                // Update subtotal in UI
                updateSubtotal(quantityInput);

                // Save quantity change to database via AJAX
                var productId = button.closest('tr').querySelector('input[name="item_id"]').value;
                saveQuantityToDatabase(productId, newQuantity);
            }

            function saveQuantityToDatabase(productId, newQuantity) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_quantity.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log("Quantity updated successfully in database.");
                        } else {
                            console.error("Error updating quantity in database.");
                        }
                    }
                };
                xhr.send("product_id=" + productId + "&quantity=" + newQuantity);
            }

            function updateSubtotal(input) {
                var tr = input.closest('tr');
                var price = parseFloat(tr.cells[4].textContent.replace('₱', '').replace(',', ''));
                var quantity = parseInt(input.value);
                var subtotal = price * quantity;
                tr.querySelector('.subtotal').textContent = '₱ ' + subtotal.toFixed(2);
                updateOrderSummary();
            }

            function handleCheckboxClick(checkbox) {
                var hiddenInputs = document.getElementById('hiddenInputs');
                hiddenInputs.innerHTML = ''; // Clear previous inputs

                var checkboxes = document.querySelectorAll('input[name="selectedItem[]"]:checked');
                checkboxes.forEach(function(checkbox) {
                    var title = checkbox.getAttribute('data-title');
                    var author = checkbox.getAttribute('data-author');
                    var price = checkbox.getAttribute('data-price');
                    var image = checkbox.getAttribute('data-image');
                    var product_id = checkbox.getAttribute('data-id');
                    var qtyInput = checkbox.closest('tr').querySelector('input[name="qty[]"]').value;

                    // Create hidden inputs for each selected item
                    var inputProductID = document.createElement('input');
                    inputProductID.type = 'hidden';
                    inputProductID.name = 'pids[]';
                    inputProductID.value = product_id;
                    hiddenInputs.appendChild(inputProductID);
                    
                    var inputTitle = document.createElement('input');
                    inputTitle.type = 'hidden';
                    inputTitle.name = 'titles[]';
                    inputTitle.value = title;
                    hiddenInputs.appendChild(inputTitle);

                    var inputAuthor = document.createElement('input');
                    inputAuthor.type = 'hidden';
                    inputAuthor.name = 'authors[]';
                    inputAuthor.value = author;
                    hiddenInputs.appendChild(inputAuthor);

                    // Fetch the current price from the table instead of using the data-price attribute
                    var priceFromTable = checkbox.closest('tr').cells[4].textContent.replace('₱', '').trim();
                    var inputPrice = document.createElement('input');
                    inputPrice.type = 'hidden';
                    inputPrice.name = 'prices[]';
                    inputPrice.value = priceFromTable;
                    hiddenInputs.appendChild(inputPrice);

                    var inputImage = document.createElement('input');
                    inputImage.type = 'hidden';
                    inputImage.name = 'images[]';
                    inputImage.value = image;
                    hiddenInputs.appendChild(inputImage);

                    var inputQty = document.createElement('input');
                    inputQty.type = 'hidden';
                    inputQty.name = 'qtys[]';
                    inputQty.value = qtyInput;
                    hiddenInputs.appendChild(inputQty);
                });

                // After updating hidden inputs, update the order summary
                updateOrderSummary();
            }

            function prepareCheckout() {
                var checkboxes = document.querySelectorAll('input[name="selectedItem[]"]:checked');
                if (checkboxes.length === 0) {
                    alert("Please select at least one item before proceeding to checkout.");
                    return;
                }

                // Call handleCheckboxClick to update hiddenInputs before submitting
                handleCheckboxClick();

                // Submit the form after updating hiddenInputs
                document.getElementById('checkoutForm').submit();
            }

            function updateOrderSummary() {
                var checkboxes = document.querySelectorAll('input[name="selectedItem[]"]:checked');
                var subtotal = 0;

                checkboxes.forEach(function(checkbox) {
                    var tr = checkbox.closest('tr');
                    var subtotalValue = parseFloat(tr.querySelector('.subtotal').textContent.replace('₱', '').replace(',', ''));
                    subtotal += subtotalValue;
                });

                var subtotalElement = document.getElementById('subtotal');
                subtotalElement.textContent = '₱ ' + subtotal.toFixed(2);

                var shippingFee = 50; // Example shipping fee
                var total = subtotal + shippingFee;

                var totalElement = document.getElementById('total');
                totalElement.textContent = '₱ ' + total.toFixed(2);
            }

            window.onload = updateOrderSummary;

            function removeItem(form) {
                if (confirm('Are you sure you want to remove this item?')) {
                    var formData = new FormData(form); // Gather form data
                    var xhr = new XMLHttpRequest();

                    xhr.open('POST', 'remove_from_cart.php', true);
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
</body>
</html>

<?php ob_end_flush(); ?>
