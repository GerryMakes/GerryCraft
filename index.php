<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to index.html if not logged in
    header("Location: index.html");
    exit;
}

// If logged in, show the page content
echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "!";
?>