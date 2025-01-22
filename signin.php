<?php
session_start();
require 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, username, password, is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashedPassword, $isVerified);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            if ($isVerified) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                echo "Login successful! Welcome, $username.";
                // Redirect to dashboard or home page
                header("Location: dashboard.php");
            } else {
                echo "Please verify your email to log in.";
            }
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with this email.";
    }

    $stmt->close();
}
?>