<?php
require_once("function/book-class.php");
require_once("function/user-session.php");
require_once("assets/parts/user-head.php");

$customer_id = $userinfo['user_id'];
$cart = $book->getCart($customer_id);
$addresses = $book->getAddresses($customer_id);

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titles = $_POST['titles'] ?? [];
    $authors = $_POST['authors'] ?? [];
    $prices = $_POST['prices'] ?? [];
    $images = $_POST['images'] ?? [];
    $qtys = $_POST['qtys'] ?? [];
    $pids = $_POST['pids'] ?? [];

    $shippingFee = 50;
    $subtotal = 0;
    foreach ($prices as $index => $price) {
        $subtotal += $price * $qtys[$index];
    }
    $total = $subtotal + $shippingFee;
} else {
    echo "Invalid access.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ReadScape: Checkout Page</title>
</head>
<body>
    <?php require_once("assets/inc/navbar.php"); ?>

    <div class="container" id="my-order">
        <div id="mini_user_nav">
            <span class="d-flex">
                <a href="index.php" class="me-1 text-dark home"> Home / </a>
                <a href="#" class="me-1 text-dark home"> My Shopping Bag /</a>
                <a href="#" class="checkout"> Checkout </a>
            </span>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4">
            <?php require_once("assets/inc/user_sidebar.php"); ?>
        </div>

        <div class="col-md-8">
            <h5>Checkout</h5>
            <br>

            <?php if (empty($cart)) { ?>
                <p>Your shopping bag is empty.</p>
            <?php } else { ?>
                <div id="order-summary" style="border: 1px solid #BF9270; box-shadow: 5px 10px #BF9270; border-radius: 10px; padding: 25px 50px; width: 750px;">
                    <div style="display: flex; justify-content: space-between;">
                        <h4>Shipping Information</h4>
                        <button class="btn btn-primary" onclick="showEditModal()" style="background-color: #BF9270; border: 1px solid #BF9270;">Change Shipping Info</button>
                    </div>

                    <p style="margin-top: 0px;"><b>Contact Details:</b></p>
                    <?php if (!empty($addresses)) { 
                        $address = $addresses[0]; // Get the first address
                    ?>
                        <p id="contactDetails" class="form-control" style="border: none;">
                            <?= "{$address['customer_name']} | {$address['phone_number']}" ?>
                        </p>

                        <p style="margin-top: 15px;"><b>Delivery Address:</b></p>
                        <p id="deliveryAddress" class="form-control" style="border: none;">
                            <?= "{$address['block_lot']}, {$address['street']}, {$address['barangay']}, {$address['city']}, {$address['province']}, {$address['country']}, {$address['postal_code']}" ?>
                        </p>
                    <?php } else { ?>
                        <p>No address information available.</p>
                    <?php } ?>

                    <br>
                    <hr>

                    <h5>Order Summary</h5>

                    <!-- Display item names and authors -->
                    <h6>Items:</h6>
                    <ol style="margin-top: 25px;">
                        <?php foreach ($titles as $index => $title) {
                            // Assuming $images[$index] contains the URL/path to the image
                            $image_url = isset($images[$index]) ? $images[$index] : ''; // Fetch the image URL
                            echo '<li style="margin-bottom: 25px;">';
                            if (!empty($image_url)) {
                                echo '<img src="assets/images/products/' . $image_url . '" alt="' . htmlspecialchars($title) . '" style="width: 50px; height: 50px; margin-right: 10px;">';
                            }
                            echo "{$title} by {$authors[$index]} - {$qtys[$index]} x ₱{$prices[$index]}</li>";
                        } ?>
                    </ol>

                    <hr>

                    <h6 style="margin-left: 475px;">Subtotal: ₱ <span id="subtotal"><?= number_format($subtotal, 2); ?></span></h6>
                    <h6 style="margin-left: 475px;">Shipping Fee: ₱ <span id="shippingFee"><?= number_format($shippingFee, 2); ?></span></h6>
                    <hr style="width: 175px; margin-left: 475px;">
                    <h6 style="color: green; margin-left: 475px;">Total: ₱ <span id="total"><?= number_format($total, 2); ?></span></h6>

                    <br>
                    <form action="payment_gateway.php" method="POST" enctype="multipart/form-data" style="display: flex;">
                        <input type="hidden" name="total_amount" value="<?= $total; ?>">
                        <input type="hidden" name="pids" value='<?= json_encode($pids); ?>'>
                        <input type="hidden" name="titles" value='<?= json_encode($titles); ?>'>
                        <input type="hidden" name="authors" value='<?= json_encode($authors); ?>'>
                        <input type="hidden" name="prices" value='<?= json_encode($prices); ?>'>
                        <input type="hidden" name="qtys" value='<?= json_encode($qtys); ?>'>
                        <input type="hidden" name="images" value='<?= json_encode($images); ?>'>

                        <!-- Hidden fields to include address details in the form submission -->
                        <input type="hidden" name="customer_name" value="<?= $address['customer_name'] ?>">
                        <input type="hidden" name="phone_number" value="<?= $address['phone_number'] ?>">
                        <input type="hidden" name="block_lot" value="<?= $address['block_lot'] ?>">
                        <input type="hidden" name="street" value="<?= $address['street'] ?>">
                        <input type="hidden" name="barangay" value="<?= $address['barangay'] ?>">
                        <input type="hidden" name="city" value="<?= $address['city'] ?>">
                        <input type="hidden" name="province" value="<?= $address['province'] ?>">
                        <input type="hidden" name="country" value="<?= $address['country'] ?>">
                        <input type="hidden" name="postal_code" value="<?= $address['postal_code'] ?>">

                        <a href="customer_shoppingbag.php" style="margin-left: 385px;" class="btn btn-secondary">Back</a>
                        <button style="margin-left: 15px;" class="btn btn-success" type="submit">Proceed to Payment</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Edit Shipping Info Modal -->
    <div class="modal" id="editShippingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #FEF8F2;">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: #BF9270;">Change Shipping Info</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h6>Select Shipping Address</h6>
                    <select class="form-control" id="shippingAddressDropdown">
                        <?php foreach ($addresses as $address) { ?>
                            <option value="<?= $address['address_id']; ?>">
                                <?= "{$address['customer_name']} | {$address['phone_number']} | {$address['block_lot']}, {$address['street']}, {$address['barangay']}, {$address['city']}, {$address['province']}, {$address['country']}, {$address['postal_code']}" ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="updateShippingInfo()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEditModal() {
            $('#editShippingModal').modal('show');
        }

        function updateShippingInfo() {
            const selectedAddress = document.getElementById('shippingAddressDropdown').selectedOptions[0].text;
            const details = selectedAddress.split(' | ');

            document.getElementById('contactDetails').innerText = details[0] + ' | ' + details[1];
            document.getElementById('deliveryAddress').innerText = details.slice(2).join(', ');

            $('#editShippingModal').modal('hide');
        }
    </script>

<?php require_once("assets/inc/footer.php"); ?>
<?php require_once("assets/parts/user-bottom.php"); ?>
</body>
</html>
