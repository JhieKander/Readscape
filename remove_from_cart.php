<?php
require_once("function/book-class.php");
require_once("function/user-session.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['item_id'])) {
        $item_id = $_POST['item_id'];
        $customer_id = $userinfo['user_id']; // Assuming $userinfo['user_id'] contains the customer's ID

        // Call removeFromCart function
        $success = $book->removeFromCart($item_id, $customer_id);

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to remove item from cart']);
        }
        exit;
    } else {
        echo json_encode(['error' => 'Missing item_id']);
        exit;
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}
?>
