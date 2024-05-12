<?php
session_start();
include_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $userId = $_SESSION['user_id'];
    $cartItems = $_SESSION['cart'];

    // Insert order details into database
    foreach ($cartItems as $productId) {
        $sql = "INSERT INTO orders (user_id, product_id) VALUES ('$userId', '$productId')";
        $conn->query($sql);
    }

    // Clear cart after checkout
    $_SESSION['cart'] = [];

    echo "Order placed successfully!";
} else {
    echo "Error processing order.";
}
?>
