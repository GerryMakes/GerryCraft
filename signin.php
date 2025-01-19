<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier']; // Could be username or email
    $password = $_POST['password'];

    if (empty($identifier) || empty($password)) {
        header("Location: loginsignup.php?error=all%20fields%20are%20required");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Store user info in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Debugging output
            error_log("User logged in: " . $_SESSION['username']);
            header("Location: index.php");
            exit();
        } else {
            header("Location: loginsignup.php?error=invalid%20credentials");
            exit();
        }
    } else {
        header("Location: loginsignup.php?error=user%20not%20found");
        exit();
    }
}
?>
