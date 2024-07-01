<?php
require_once("function/book-class.php");

// Assuming an instance of BookClass is created
$book = new BookClass();

// Example usage in your application (update_quantity.php or similar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["product_id"]) && isset($_POST["quantity"])) {
        $productId = $_POST["product_id"];
        $newQuantity = $_POST["quantity"];

        // Update quantity in database
        $result = $book->updateQuantity($productId, $newQuantity);

        if ($result) {
            http_response_code(200);
            echo "Quantity updated successfully.";
        } else {
            http_response_code(500);
            echo "Failed to update quantity in database.";
        }
    } else {
        http_response_code(400);
        echo "Invalid request parameters.";
    }
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
?>