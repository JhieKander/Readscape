<!DOCTYPE html>
<html>
<?php 
require_once("function/book-class.php");
require_once("function/user-session.php");
require_once("assets/parts/user-head.php");
?>
<body>
<?php 
require_once("assets/inc/navbar.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the form data has been validated before reaching here
    // Retrieve selected items from the form
    $titles = $_POST['titles'] ?? [];
    $authors = $_POST['authors'] ?? [];
    $prices = $_POST['prices'] ?? [];
    $qtys = $_POST['qtys'] ?? [];

    // Validate and sanitize inputs (not shown here for brevity)

    // Example shipping fee
    $shippingFee = 50;

    // Calculate subtotal and total
    $subtotal = 0;
    foreach ($prices as $index => $price) {
        $subtotal += $price * $qtys[$index];
    }
    $total = $subtotal + $shippingFee;
}
?>

<div class="container" id="my-order">
    <div id="mini_user_nav">
        <span class="d-flex">
            <a href="index.php" class="me-1 text-dark home"> Home / </a>
            <a href="cart.php" class="me-1 text-dark home"> My Shopping Bag /</a>
            <a href="#" class="checkout"> Checkout </a>
        </span>
    </div>
     
    <div class="row mt-5">
        <div class="col-md-4">
            <?php require_once("assets/inc/user_sidebar.php"); ?>
        </div>
        
        <div class="col-md-8">
            <h5>Checkout</h5>
            <br>

            <?php

            if (empty($cart)) {
                echo "<p>Your shopping bag is empty.</p>";
            } else {
                $subtotal = 0;
                foreach ($cart as $item) {
                    $subtotal += $item['price'] * $item['qty'];
                }
                $shippingFee = 50.00;
                $total = $subtotal + $shippingFee;
            ?>
            <div id="order-summary" style="border: 1px solid lightgray; box-shadow: 5px 10px lightgray; border-radius: 10px; padding: 25px 50px;">
                <h5>Order Summary</h5>

                <!-- Display item names and authors -->
                <h6>Items:</h6>
                <br>
                <ul>
                    <?php foreach ($titles as $index => $title): ?>
                        <li style="margin-bottom: 25px;"><?php echo "{$title} by {$authors[$index]} - {$qtys[$index]} x ₱{$prices[$index]}"; ?></li>
                    <?php endforeach; ?>
                </ul>

                <h6>Subtotal: ₱ <span id="subtotal"><?= number_format($subtotal, 2); ?></span></h6>
                <h6>Shipping Fee: ₱ <span id="shippingFee"><?= number_format($shippingFee, 2); ?></span></h6>
                <h6 style="color: green;">Total: ₱ <span id="total"><?= number_format($total, 2); ?></span></h6>

                <br>
                <h6>Shipping Address <i>(Click the address if you want to change it.)</i></h6>
                <select class="form-control" id="shippingAddress">
                    <?php foreach ($addresses as $address): ?>
                        <option value="<?= $address['address_id']; ?>">
                            <?= "{$address['block_lot']}, {$address['street']}, {$address['barangay']}, {$address['city']}, {$address['province']}, {$address['country']}, {$address['postal_code']}" ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>
                <button class="btn btn-success" onclick="showPaymentModal()">Proceed to Payment</button>
            </div>
            

            <!-- Payment Method Modal -->
            <div class="modal" id="paymentModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #FEF8F2;">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: #BF9270;">Payment Method</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Select Payment Method</h6>
                            <select class="form-control" id="paymentMethod">
                                <option value="paypal">PayPal</option>
                                <option value="paypal">Maya</option>
                                <option value="paypal">GCash</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="submitOrder()">Submit Order</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function showPaymentModal() {
                $('#paymentModal').modal('show');
            }

            function submitOrder() {
                // Add your order submission logic here
                alert('Order submitted successfully!');
                $('#paymentModal').modal('hide');
            }
            </script>

            <?php } ?>
        </div>
    </div>
</div>

<?php require_once("assets/inc/footer.php"); ?>
<?php require_once("assets/parts/user-bottom.php"); ?>
</body>
</html>
