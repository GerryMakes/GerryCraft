<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $passcode = $_POST['passcode'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, passcode) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $passcode]);
        echo "User registered successfully!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry error
            echo "Username or email already exists.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

