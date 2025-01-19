<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: loginsignup.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User panel</title>
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
    <h1>Welcome to the User Panel, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Here you can view your profile and access user-specific content.</p>
    <a href="logout.php">Logout</a>
</body>
</html>