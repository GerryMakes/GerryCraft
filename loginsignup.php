<?php
// Start session
session_start();

// Include database configuration
require_once "db.php";  // Make sure this is included

// Define variables and initialize with empty values
$identifier = $password = $username = $email = "";
$identifier_err = $password_err = $username_err = $email_err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $identifier = trim($_POST['identifier']);
    $password = trim($_POST['password']);

    // Check if both fields are filled
    if (empty($identifier) || empty($password)) {
        echo "Both fields are required.";
    } else {
        // Prepare the SQL query to check if the identifier (username or email) exists
        $sql = "SELECT id, username, email, password, role FROM users WHERE username = ? OR email = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {  // Use $conn instead of $link
            // Bind parameters to the statement
            $stmt->bind_param("ss", $identifier, $identifier);

            // Execute the statement
            $stmt->execute();

            // Store the result
            $stmt->store_result();

            // Check if a matching user was found
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($id, $username, $email, $hashed_password, $role);

                // Fetch the result
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, store session variables
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    // Redirect based on user role
                    if ($role == 'admin') {
                        header("Location: admin_panel.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No account found with this username or email.";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the query.";
        }
    }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GerryCraft</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="form-body">
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
    <div class="form-container">
        <div class="form-header">
            <h1>Welcome to GerryCraft</h1>
            <p>Please log in or sign up to continue</p>
        </div>
        <div class="form-wrapper">
            <!-- Login Form -->
            <form action="signin.php" method="POST" class="form">
                <h2>Login</h2>
                <div class="form-group">
                    <label for="login-username">Username or Email</label>
                    <input type="text" name="identifier" id="login-username" placeholder="Username or Email" required>
                    <span class="error"><?php echo $identifier_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                    <span class="error"><?php echo $password_err; ?></span>
                </div>
                <button type="submit" name="login" class="form-btn">Login</button>
            </form>

            <!-- Signup Form -->
            <form action="signup.php" method="POST" class="form">
                <h2>Sign Up</h2>
                <div class="form-group">
                    <label for="signup-username">Username</label>
                    <input type="text" id="signup-username" name="username" placeholder="Create a username" required>
                    <span class="error"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="signup-email">Email</label>
                    <input type="email" id="signup-email" name="email" placeholder="Enter your email" required>
                    <span class="error"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" id="signup-password" name="password" placeholder="Create a password" required>
                    <span class="error"><?php echo $password_err; ?></span>
                </div>
                <button type="submit" name="signup" class="form-btn">Sign Up</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 GerryCraft. All Rights Reserved.</p>
    </footer>
</body>
</html>
