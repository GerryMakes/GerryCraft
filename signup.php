<?php
require 'db.php'; // Database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);

        // Log the user in
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;

        // Redirect to index.php
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry error
            echo "Username or email already exists.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>