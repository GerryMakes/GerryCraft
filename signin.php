<?php
require 'db.php'; // Database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = trim($_POST['identifier']); // Can be username or email
    $password = trim($_POST['password']);

    // Validate input
    if (empty($identifier) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    // Check the database for the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Login successful! Welcome, " . htmlspecialchars($user['username']) . ".";
    } else {
        echo "Invalid username/email or password.";
    }
}
?>