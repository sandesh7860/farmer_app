<?php
session_start();
include_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch and display farmer's products
$sql = "SELECT * FROM products WHERE farmer_id = '$userId'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer Dashboard</title>
</head>
<body>
    <h2>Add Product</h2>
    <form action="add_product.php" method="POST">
        <input type="text" name="name" placeholder="Product Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="number" name="price" placeholder="Price" required><br>
        <input type="number" name="quantity" placeholder="Quantity" required><br>
        <button type="submit">Add Product</button>
    </form>

    <h2>My Products</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>{$row['name']} - {$row['price']}</p>";
        }
    } else {
        echo "No products found.";
    }
    ?>
</body>
</html>
