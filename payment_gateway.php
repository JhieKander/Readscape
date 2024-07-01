<?php
require_once("function/book-class.php");
require_once("function/user-session.php");
require_once("assets/parts/user-head.php");

$customer_id = $userinfo['user_id'];

$cart = $book->getCart($customer_id);
$addresses = $book->getAddresses($customer_id);

$total_amount = $_POST['total_amount'] ?? 0;
$titles = json_decode($_POST['titles'] ?? '[]');
$authors = json_decode($_POST['authors'] ?? '[]');
$prices = json_decode($_POST['prices'] ?? '[]');
$qtys = json_decode($_POST['qtys'] ?? '[]');
$pids = json_decode($_POST['pids'] ?? '[]');
$images = json_decode($_POST['images'] ?? '[]');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid access.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ReadScape: Payment Page</title>
    <style>
        #info {
            margin-top: 15px;
            margin-left: 0px;
            border: 1px solid #BF9270;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 40px;
        }
        #gcash-paymaya-info {
            display: none;
            margin-top: 15px;
            margin-left: 30px;
            border: 1px solid #BF9270;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 40px;
        }
        label { font-weight: bold; }
        input { text-align: center; }
        #order-placed-btn {
            position: absolute;
            bottom: 20px;
            right: 165px;
            background-color: #BF9270;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
    <script>
        function showPaymentInfo() {
            var paymentMethod = document.getElementById("payment-method").value;
            var infoDiv = document.getElementById("gcash-paymaya-info");

            if (paymentMethod === "GCash" || paymentMethod === "PayMaya") {
                infoDiv.style.display = "block";
            } else {
                infoDiv.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <?php require_once("assets/inc/navbar.php"); ?>

    <div class="container" id="my-order">
        <div id="mini_user_nav">
            <span class="d-flex">
                <a href="index.php" class="me-1 text-dark home"> Home / </a>
                <a href="#" class="me-1 text-dark home"> My Shopping Bag /</a>
                <a href="process_checkout.php" class="me-1 text-dark home"> Checkout /</a>
                <a href="#" class="checkout"> Payment </a>
            </span>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <?php require_once("assets/inc/user_sidebar.php"); ?>
        </div>

        <div class="col-md-8" style="position: relative;">
            <h5>Payment</h5>
            <p style="margin-left: 50px;">Choose your payment method to proceed.</p>
            <br>
            <div id="order-summary" style="border: 1px solid #BF9270; box-shadow: 5px 10px #BF9270; border-radius: 10px; padding: 25px 50px; width: 750px; display: flex;">
                
                <div class="col-md-6">
                    <div class="col-md-12" style="border-right: 1px solid #BF9270; padding: 10px 15px;">
                        <h6 style="text-align: center; font-weight: bolder;">For GCash or PayMaya Payment only</h6>
                        <hr>
                        <div id="info">
                            <div class="form-group">
                                <label for="account-name">Account Name:</label>
                                <input type="text" id="account-name" name="account-name" class="form-control" style="border: 1px solid #BF9270; border-radius: 10px; padding: 5px;" value="ReadScape" readonly>
                            </div>
                            <div class="form-group">
                                <label for="account-number">Account Number:</label>
                                <input type="text" id="account-number" name="account-number" class="form-control" style="border: 1px solid #BF9270; border-radius: 10px; padding: 5px;" value="09123456789" readonly>
                            </div>
                            <div class="form-group">
                                <label for="total-amount">Total Amount:</label>
                                <input type="text" id="total-amount" name="total-amount" class="form-control" style="border: 1px solid #BF9270; border-radius: 10px; padding: 5px; color: green; font-weight: bold;" value="₱ <?= $total_amount; ?>.00" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="col-md-12" style="padding: 10px 15px;">
                        <h6 style="text-align: center; font-weight: bolder;">Payment Method</h6>
                        <hr>
                        <form id="payment-form" method="POST" enctype="multipart/form-data" action="finalize_payment.php">
                            <select id="payment-method" name="payment_method" onchange="showPaymentInfo()" style="margin-left: 50px; width: 75%; border: 1px solid #BF9270; border-radius: 10px; padding: 10px 15px; text-align: center;">
                                <option value="COD">Cash on Delivery</option>
                                <option value="GCash">GCash</option>
                                <option value="PayMaya">PayMaya</option>
                            </select>

                            <div id="gcash-paymaya-info">
                                <div class="form-group">
                                    <label for="account-name">Account Name:</label>
                                    <input type="text" id="account-name" name="account_name" class="form-control" style="border: 1px solid #BF9270; border-radius: 10px; padding: 5px;">
                                </div>
                                <div class="form-group">
                                    <label for="account-number">Account Number:</label>
                                    <input type="text" id="account-number" name="account_number" class="form-control" style="border: 1px solid #BF9270; border-radius: 10px; padding: 5px;">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="total-amount" name="total_amount" class="form-control" style="border: 1px solid #BF9270; border-radius: 10px; padding: 5px;" value="<?= $total_amount; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="payment-proof">Attach Proof of Payment:</label>
                                    <input type="file" id="payment-proof" name="payment_proof" class="form-control" style="border: 1px solid #BF9270; border-radius: 10px; padding: 5px;">
                                </div>
                            </div>

                            <input type="hidden" name="customer_id" value="<?= $customer_id; ?>">
                            <input type="hidden" name="pids" value='<?= json_encode($pids); ?>'>
                            <input type="hidden" name="total_amount" value="<?= $total; ?>">
                            <input type="hidden" name="titles" value='<?= json_encode($titles); ?>'>
                            <input type="hidden" name="authors" value='<?= json_encode($authors); ?>'>
                            <input type="hidden" name="prices" value='<?= json_encode($prices); ?>'>
                            <input type="hidden" name="qtys" value='<?= json_encode($qtys); ?>'>
                            <input type="hidden" name="images" value='<?= json_encode($images); ?>'>

                            <!-- Hidden fields to include address details in the form submission -->
                            <?php if (!empty($addresses)) { 
                                $address = $addresses[0]; // Get the first address
                            ?>
                                <input type="hidden" name="customer_name" value="<?= $address['customer_name'] ?>">
                                <input type="hidden" name="phone_number" value="<?= $address['phone_number'] ?>">
                                <input type="hidden" name="block_lot" value="<?= $address['block_lot'] ?>">
                                <input type="hidden" name="street" value="<?= $address['street'] ?>">
                                <input type="hidden" name="barangay" value="<?= $address['barangay'] ?>">
                                <input type="hidden" name="city" value="<?= $address['city'] ?>">
                                <input type="hidden" name="province" value="<?= $address['province'] ?>">
                                <input type="hidden" name="country" value="<?= $address['country'] ?>">
                                <input type="hidden" name="postal_code" value="<?= $address['postal_code'] ?>">
                            <?php } else { ?>
                                <p>No address information available.</p>
                            <?php } ?>

                        <a href="customer_shoppingbag.php" style="margin-left: 385px;" class="btn btn-secondary">Back</a>

                            <button id="order-placed-btn" type="submit">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once("assets/inc/footer.php"); ?>
    <?php require_once("assets/parts/user-bottom.php"); ?>
</body>
</html>
