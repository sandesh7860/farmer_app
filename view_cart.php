<?php
session_start();
include_once 'db_config.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
} else {
    $cartItems = $_SESSION['cart'];
    
    echo "<h2>Your Cart</h2>";
    echo "<ul>";
    foreach ($cartItems as $productId) {
        $sql = "SELECT * FROM products WHERE id = '$productId'";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            echo "<li>{$row['name']} - {$row['price']}</li>";
        }
    }
    echo "</ul>";
}
?>
