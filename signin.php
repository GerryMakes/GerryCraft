<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $_POST['identifier']; // Can be username or email
    $password = $_POST['password'];
    $passcode = $_POST['passcode'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND passcode = ?");
    $stmt->execute([$identifier, $identifier, $passcode]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo "Sign-in successful!";
    } else {
        echo "Invalid username/email, passcode, or password.";
    }
}
?>

<form method="POST" action="signin.php">
    <input type="text" name="identifier" placeholder="Username or Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="passcode" placeholder="Passcode" required>
    <button type="submit">Sign In</button>
</form>
