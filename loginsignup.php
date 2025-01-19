<?php

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GerryCraft</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="index_Body">
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

    <section class="signinandup">
        <div class="signup">
            <form method="POST" action="signup.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
            </form>            
        </div>
        <div class="signin">
            <form method="POST" action="signin.php">
                <input type="text" name="identifier" placeholder="Username or Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign In</button>
            </form>            
    </section>
</body>
</html>