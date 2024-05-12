<?php
session_start();
include_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input (check if fields are not empty, validate email format, etc.)
    // You can use more advanced validation techniques here

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
        // Redirect to login page or display a success message
        header("Location: login.html");
        exit();
    } else {
        // Registration failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
