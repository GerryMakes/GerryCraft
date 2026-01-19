<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginsignup.php?error=not_logged_in");
    exit();
}

// Get user role from session
$user_role = $_SESSION['role'] ?? 'user';

// Directory where files are stored
$download_dir = 'downloads/';

// Handle file upload (only for admins)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_role === 'admin') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $target_file = $download_dir . basename($file['name']);

        // Validate file
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $upload_message = "File uploaded successfully!";
        } else {
            $upload_message = "Failed to upload file.";
        }
    }
}

// Fetch files for download
$files = array_diff(scandir($download_dir), array('.', '..'));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloads</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="Gaming_Body">
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
                    <a href="logout.php" class="button">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <h1>Welcome to the Downloads Page</h1>
        <p>Do you want to download my game? Here it is!</p>

        <!-- Display files for download -->
        <div class="download">
            <h2>Available Downloads</h2>
            <ul>
                <?php foreach ($files as $file): ?>
                    <li>
                        <a href="<?php echo $download_dir . htmlspecialchars($file); ?>" download>
                            <?php echo htmlspecialchars($file); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Admin-only section -->
        <?php if ($user_role === 'admin'): ?>
            <div class="upload">
                <h2>Upload a New File</h2>
                <?php if (isset($upload_message)): ?>
                    <p><?php echo htmlspecialchars($upload_message); ?></p>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <label for="file">Select a file to upload:</label>
                    <input type="file" name="file" id="file" required>
                    <button type="submit">Upload</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
