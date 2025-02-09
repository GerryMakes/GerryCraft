<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "db.php"; // Make sure this file exists

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    if (!empty($username) && !empty($email) && !empty($password)) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect after successful signup
            exit();
        } else {
            echo "Signup failed. Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}
?>
