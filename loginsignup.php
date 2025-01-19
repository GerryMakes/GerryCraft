<?php

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
                    <label for="login-username">Username</label>
                    <input type="text" name="identifier" id="login-username" placeholder="Username or Email" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="form-btn">Login</button>
            </form>

            <!-- Signup Form -->
            <form action="signup.php" method="POST" class="form">
                <h2>Sign Up</h2>
                <div class="form-group">
                    <label for="signup-username">Username</label>
                    <input type="text" id="signup-username" name="username" placeholder="Create a username" required>
                </div>
                <div class="form-group">
                    <label for="signup-email">Email</label>
                    <input type="email" id="signup-email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" id="signup-password" name="password" placeholder="Create a password" required>
                </div>
                <button type="submit" class="form-btn">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>