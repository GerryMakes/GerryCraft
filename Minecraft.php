<?php
session_start();

// Check if the user is logged in and is a regular user
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    header("Location: loginsignup.php");
    exit();
}

// Fetch user details from the session
$username = htmlspecialchars($_SESSION['username']);
?>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="app.js"></script>
    <link rel="stylesheet" href="Minecraft.css">
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
                    <a href="downloads.php" class="navbar-links">downloads</a>
                </li>
                <li class="navbar-item">
                    <a href="Links.html" class="navbar-links">Links</a>
                </li>
                <li class="navbar-btn">
                    <a href="logout.php" class="button">Sign Out <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <main>
            <h1>Welcome to the Minecraft Panel, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <div class="minecraft">
                <h3>skins mc minecraft page</h3>
                <iframe src="https://skinmc.net/profile/MC_Demi_God.1" frameborder="0" width="500px" height="500px"></iframe>
            </div>
        </main>
    </div>
</body>
