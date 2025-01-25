<?php
session_start();

// Ensure only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginsignup.php");
    exit();
}

require 'db.php';

// Check if user ID is provided
if (!isset($_POST['user_id'])) {
    header("Location: admin_panel.php");
    exit();
}

$userId = $_POST['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_panel.php?error=User%20not%20found");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (empty($username) || empty($email) || empty($role)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $userId);
        if ($stmt->execute()) {
            header("Location: admin_panel.php?success=User%20updated%20successfully");
            exit();
        } else {
            $error = "Failed to update user.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css?v=1.0">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" id="navbar-logo">GerryCraft</a>
            <ul class="navbar-menu">
                <li class="navbar-item">
                    <a href="admin_panel.php" class="navbar-links">Back to Admin Panel</a>
                </li>
                <li class="navbar-btn">
                    <a href="logout.php" class="button">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        <h1>Edit User</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <br>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <br><br>
            <button type="submit" name="update_user">Update User</button>
        </form>
    </main>
    <footer class="footer">
        <p>&copy; 2025 GerryCraft. All Rights Reserved.</p>
    </footer>
</body>
</html>
