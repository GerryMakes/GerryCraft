<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: loginsignup.php");
    exit();
}

// Debugging session variables
error_log("Session username: " . ($_SESSION['username'] ?? 'Not set'));

$username = $_SESSION['username'] ?? 'Guest';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
        <a href="#" id="navbar-logo">GerryCraft</a>
               <ul class="navbar-menu">
                <li class="navbar-item">
                    <a href="Geometrydash.html" class="navbar-links">Gaming</a>
                </li>
                <li class="navbar-item">
                    <a href="game.html" class="navbar-links">Game</a>
                </li>
                <li class="navbar-item">
                    <a href="Links.html" class="navbar-links">Links</a>
                </li>
                 <li class="navbar-btn">
                    <a href="loginsignup.php" class="button">Sign Up</a>
                 </li>
            </ul>
        </div>
    </nav>    
    <div style="text-align:center; padding:15%;">
      <p  style="font-size:50px; font-weight:bold;"> Hello <h1><?php echo htmlspecialchars($username); ?>!</h1></p>
      <a href="logout.php">Logout</a>
    </div>
</body>
</html>