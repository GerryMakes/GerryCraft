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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="indexuser.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="indexcss.css">
    <style>
        a {
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
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
    <h1>Welcome to the User Panel, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Here you can view your profile and access user-specific content.</p>
    <p>You are now logged in.</p>
    <p>Explore the features of your account:</p>
    <ul>
        <li><a href="downloads.php">Download Files</a></li>
        <li><a href="profile.php">Edit Profile</a></li>
        <li><a href="settings.php">Account Settings</a></li>
    </ul>
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
    <br>
    <div class="bio">
        <div class="bio_inard">
            <form class="bioform">
                <label>Bio:</label>
                <textarea id="bio" name="bio" rows="4" cols="50">Your bio goes here.</textarea>
                <button type="submit">Save Bio</button>
            </form>
        </div>
    </div>
    <br>
    <div>
        <div class="download_text">
            <h2>Downloads</h2>
            <p>Download the GerryCraft tools java app</p>
        </div>
        <div class="main_download">
            <a href="" class="download_link">Download the gerrycraft tools app</a>
        </div>
    </div>
    <div>
        <h1>Calculator</h1>
        <input type="number" id="num1" name="number" placeholder="Enter a number">
        <input type="number" id="num2" name="number" placeholder="Enter another number">
        <button onclick="math(document.getElementById('num1').value, document.getElementById('num2').value)">Calculate</button>
        <h3 id="Sum">answer</h3>
    </div>
    <section>
        <div>
            <div>
                <h2>Minecraft links</h2>
                <a href="https://skinmc.net/profile/MC_Demi_God.1">Links to my mc page (skinsMC)</a>
                <a href="Minecraft.php">Links to my minecraft page (this website)</a>
            </div>
        </div>
    </section>
        
    <a href="logout.php">Logout</a>
    </main>
    <aside id="aside">
        <button id="close-btn" class="close-btn">X</button>
        <h1>Youtube Channel</h1>
        <p>go check out my youtube channel <a href="https://www.youtube.com/@GerryCraftEZ" class="link">YoutubeChannel</a> please subscribe</p>
        <h3>latest video</h3>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/K-dDdVsMn7E?si=r-t_z24OM7dHxXiG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <br>
        <h3>second latest video</h3>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/wYOC0kwuhbY?si=GWJnBsmdl7j-cWn6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </aside>

    <button id="open-btn" class="open-btn">Aside</button>
    </div>
    <footer class="footer">
        <p>&copy; 2025 GerryCraft. All Rights Reserved.</p>
    </footer>
</body>
</html>