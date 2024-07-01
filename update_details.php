<?php
session_start();
require_once("function/book-class.php");

$user_id = $_SESSION['user_id'];
$book = new mybookShop();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $middle_name = $_POST['middle_name'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $formatted_birthday = date('Y-m-d', strtotime($birthday));

    $connection = $book->openConnection();
    $stmt = $connection->prepare("UPDATE tbl_users SET firstname = ?, middle_name = ?, lastname = ?, birthdate = ?, phone_number = ?, email = ? WHERE user_id = ?");
    $stmt->execute([$firstname, $middle_name, $lastname, $formatted_birthday, $phone_number, $email, $user_id]);
    $book->closeConnection();

    echo "<script>alert('Details updated successfully!'); window.location.href='account.php';</script>";
}
?>
