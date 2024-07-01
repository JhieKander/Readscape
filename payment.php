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

    $shippingFee = 50;
    $subtotal = 0;
    foreach ($prices as $index => $price) {
        $subtotal += $price * $qtys[$index];
    }
    $total = $subtotal + $shippingFee;

    // Generate transaction ID (15-digit alphanumeric code)
    $transaction = generateTransactionID();

    // Prepare data for insertion into tbl_order
    $customer_name = "{$addresses[0]['customer_name']}";
    $phone_number = "{$addresses[0]['phone_number']}";
    $ship_address = "{$addresses[0]['block_lot']}, {$addresses[0]['street']}, {$addresses[0]['barangay']}, {$addresses[0]['city']}, {$addresses[0]['province']}, {$addresses[0]['country']}, {$addresses[0]['postal_code']}";
    $transaction = generateTransactionID();
    $date_time_order = date('Y-m-d H:i:s'); // Current date and time

    $connection = $book->openConnection(); // Adjust as per your connection method
    $stmt = $connection->prepare("INSERT INTO tbl_order (customer_id, product_id, customer_name, ship_address, contact_number, transaction, image, item, qty, price, total, account_name, account_number, pay_method, proof_paid, status, date_time_order) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($titles as $index => $title) {
        $stmt->execute([
            $customer_id,
            $index + 1, // Assuming product_id starts from 1
            $customer_name,
            $ship_address,
            $phone_number,
            $transaction,
            $images[$index], // Assuming images is an array of URLs
            $title,
            $qtys[$index],
            $prices[$index],
            number_format($total, 2),
            '', // Assuming this is from form input
            '', // Assuming this is from form input
            '', // Assuming this is from form input
            '', // proof_paid will be updated after payment proof is uploaded
            'Order Placed', // Initial status
            $date_time_order
        ]);
    }

    // Clear the cart after successful order placement
    $book->removeFromCart($index, $customer_id);

    // Redirect to a thank you page or any other page
    header("Location: process_checkout.php");
    exit();
} else {
    echo "Invalid access.";
    exit;
}

// Function to generate a 15-character alphanumeric transaction ID
function generateTransactionID() {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $transactionID = '';
    $length = 15;
    for ($i = 0; $i < $length; $i++) {
        $transactionID .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $transactionID;
}
?>