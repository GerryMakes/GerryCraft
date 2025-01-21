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
    <link rel="stylesheet" href="styles.css?v=1.0">
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
                    <a href="loginsignup.php" class="button">Sign Up</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1>Welcome to the User Panel, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Here you can view your profile and access user-specific content.</p>
    <p>go check out my youtube channel <a href="https://www.youtube.com/@GerryCraftEZ">YoutubeChannel</a> please subscribe</p>
    <h3>latest video</h3>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/K-dDdVsMn7E?si=r-t_z24OM7dHxXiG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    <br>
    <h3>second latest video</h3>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/wYOC0kwuhbY?si=GWJnBsmdl7j-cWn6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    <br>
    <h2>Send a Webhook</h2>
    <form action="send_webhook.php" method="POST">
        <label for="webhook_url">Webhook URL:</label>
        <input type="url" id="webhook_url" name="webhook_url" required>
        <br><br>
        <label for="webhook_payload">Payload (JSON format):</label>
        <textarea id="webhook_payload" name="webhook_payload" rows="5" cols="50" required></textarea>
        <br><br>
        <button type="submit">Send Webhook</button>
    </form>
        
    <a href="logout.php">Logout</a>
</body>
</html>