<?php
require_once("function/book-class.php");
require_once("function/user-session.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $product_id = json_decode($_POST['pids'] ?? '[]');
    $titles = json_decode($_POST['titles'] ?? '[]');
    $authors = json_decode($_POST['authors'] ?? '[]');
    $prices = json_decode($_POST['prices'] ?? '[]');
    $qtys = json_decode($_POST['qtys'] ?? '[]');

    $shippingFee = 50;
    $subtotal = 0;
    foreach ($prices as $index => $price) {
        $subtotal += $price * $qtys[$index];
    }
    $total = $subtotal + $shippingFee;

    $payment_method = $_POST['payment_method'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $proof_paid = $_FILES['payment_proof'];
    $customer_name = $_POST['customer_name'];
    $ship_address = $_POST['block_lot'] . ', ' . $_POST['street'] . ', ' . $_POST['barangay'] . ', ' . $_POST['city'] . ', ' . $_POST['province'] . ', ' . $_POST['country'] . ', ' . $_POST['postal_code'];
    $contact_number = $_POST['phone_number'];
    $images = json_decode($_POST['images'] ?? '[]');

    // Generate a 15-digit alphanumeric transaction code
    $transaction = substr(str_shuffle(MD5(microtime())), 0, 15);

    // Connect to the database
    $db = new mysqli("localhost", "root", "", "db_book_shop");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Assuming `proof_paid` is a file upload, handle the file upload first
    $proof_paid_path = '';
    if ($proof_paid['error'] == 0) {
        $proof_paid_path = 'assets/images/proof_payment/' . basename($proof_paid['name']);
        move_uploaded_file($proof_paid['tmp_name'], $proof_paid_path);
    }

    // Insert the order into the database
    $query = "INSERT INTO tbl_order (customer_id, product_id, customer_name, ship_address, contact_number, transaction, image, item, qty, price, total, account_name, account_number, pay_method, proof_paid, status, date_time_order) VALUES ";

    foreach ($titles as $index => $title) {
        $image_url = isset($images[$index]) ? $images[$index] : ''; // Fetch the image URL
        $query .= "('{$customer_id}', '{$product_id[$index]}', '{$customer_name}', '{$ship_address}', '{$contact_number}', '{$transaction}', '{$image_url}', '{$title}', '{$qtys[$index]}', '{$prices[$index]}', '{$total}', '{$account_name}', '{$account_number}', '{$payment_method}', '{$proof_paid_path}', 'Order Placed', NOW()),";
    }

    $query = rtrim($query, ",");

    if ($db->query($query) === TRUE) {
        // Close database connection
        $db->close();
        
        // Display JavaScript alert and redirect
        echo "<script>alert('Order placed successfully!'); window.location.href = 'index.php';</script>";
        exit; // Exit PHP script after redirect
    } else {
        echo "Error: " . $query . "<br>" . $db->error;
    }
}
?>
