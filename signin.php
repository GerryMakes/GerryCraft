<?php
require 'db.php';
session_start();
header("Location: index.php");
exit;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = trim($_POST['identifier']);
    $password = trim($_POST['password']);

    if (empty($identifier) || empty($password)) {
        // Redirect with error message
        header("Location: index.html?error=All fields are required");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to index.php
        header("Location: index.php");
        exit;
    } else {
        header("Location: index.html?error=Invalid username/email or password");
        exit;
    }
}
?>
