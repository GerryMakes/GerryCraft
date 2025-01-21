<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginsignup.php");
    exit();
}

require 'db.php';

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = $_POST['delete_user'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Fetch all users
$result = $conn->query("SELECT id, username, email, role FROM users");

// Fetch total users
$total_users = 0;
$active_users = 0;
$total_admins = 0;

$query_total_users = "SELECT COUNT(*) AS total_users FROM users";
$query_active_users = "SELECT COUNT(*) AS active_users FROM users WHERE last_login >= NOW() - INTERVAL 7 DAY";
$query_total_admins = "SELECT COUNT(*) AS total_admins FROM users WHERE role = 'admin'";

if ($res = $conn->query($query_total_users)) {
    $total_users = $res->fetch_assoc()['total_users'];
}

if ($res = $conn->query($query_active_users)) {
    $active_users = $res->fetch_assoc()['active_users'];
}

if ($res = $conn->query($query_total_admins)) {
    $total_admins = $res->fetch_assoc()['total_admins'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
                    <a href="game.html" class="navbar-links">Game</a>
                </li>
                <li class="navbar-item">
                    <a href="Links.html" class="navbar-links">Links</a>
                </li>
                <li class="navbar-item dropdown">
                    <button class="dropdown-btn">
                        <?php echo htmlspecialchars($_SESSION['username']); ?> ▼
                    </button>
                    <div class="dropdown-content">
                        <a href="index.html">Home</a>
                        <a href="logout.php">Sign Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        <h1>Welcome to the Admin Panel, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Here you can manage users and site content.</p>

        <!-- User Management Section -->
        <section>
            <h2>Manage Users</h2>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <button type="submit" name="delete_user" value="<?php echo $row['id']; ?>">Delete</button>
                            </form>
                            <form method="post" action="edit_user.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Edit</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Announcement Section -->
        <section>
            <div class="admin-actions">
                <button onclick="window.location.href='add_announcement.php'" class="action-btn">Send Announcement</button>
            </div>
        </section>

        <!-- Site Statistics Section -->
        <section>
            <div class="admin-stats">
                <h2>Site Statistics</h2>
                <ul>
                    <li>Total Users: <?php echo $total_users; ?></li>
                    <li>Active Users (Last 7 Days): <?php echo $active_users; ?></li>
                    <li>Number of Admins: <?php echo $total_admins; ?></li>
                </ul>
            </div>
        </section>

        <!-- Site Analytics Section -->
        <section>
            <h2>Site Analytics</h2>
            <p>More features coming soon...</p>
        </section>
    </main>
</body>
</html>
