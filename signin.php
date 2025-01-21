<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']); // Could be username or email
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($identifier) || empty($password)) {
        header("Location: loginsignup.php?error=All%20fields%20are%20required");
        exit();
    }

    // Prepare SQL query to fetch user
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? OR email = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        header("Location: loginsignup.php?error=Server%20error");
        exit();
    }

    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user info in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            // Invalid password
            header("Location: loginsignup.php?error=Invalid%20credentials");
            exit();
        }
    } else {
        // User not found
        header("Location: loginsignup.php?error=User%20not%20found");
        exit();
    }
}

// Redirect to login/signup page if accessed directly
header("Location: loginsignup.php");
exit();
?>
