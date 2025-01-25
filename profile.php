<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: loginsignup.php"); // Redirect to login if not logged in
    exit();
}

// Fetch user details from the session
$username = htmlspecialchars($_SESSION['username']);
$email = htmlspecialchars($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $username; ?>'s Profile</title>
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
                    <a href="logout.php" class="button">Sign Out</a>
                </li>
            </ul>
        </div>
    </nav>
    <header>
        <h1><?php echo $username; ?>'s Profile</h1>
        <p>Welcome, <?php echo $username; ?>! Here you can manage your profile.</p>
        <h1>Edit Profile</h1>
        <form action="edit_profile.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <button type="submit">Update Profile</button>
        </form>
    <a href="index.php">Back to Dashboard</a>
    </header>
    <footer class="footer">
        <p>&copy; 2025 GerryCraft. All Rights Reserved.</p>
    </footer>
    </body>
</html>