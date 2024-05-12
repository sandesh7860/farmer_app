<?php
session_start();
include_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from database based on username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start a new session
            session_regenerate_id();
            $_SESSION['user_id'] = $row['id']; // Set user ID in session variable
            $_SESSION['username'] = $row['username']; // Set username in session variable
            header("Location: dashboard.php"); // Redirect to dashboard after successful login
            exit();
        } else {
            // Password is incorrect
            echo "Invalid username or password.";
        }
    } else {
        // User not found
        echo "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>
