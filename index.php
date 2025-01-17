<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GerryCraft</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="index_Body">
    <nav class="navbar">
        <div class="navbar__container">
            <a href="" id="navbar__logo">GerryCraft</a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="Geometrydash.html" class="navbar__links">Gaming</a>
                </li>
                <li class="navbar__item">
                    <a href="game.html" class="navbar__links">Game</a>
                </li>
                <li class="navbar__item">
                    <a href="Links.html" class="navbar__links">Links</a>
                </li>
                <li class="navbar__btn">
                    <a href="getstarted.html" class="button">Sign up</a>
                </li>
            </ul>
        </div>
    </nav>
    <section>
        <div>
            <a href="signup.php">Signup</a>
            <a href="signin.php">Signin</a>
        </div>
    </section>
    <!--Hero section-->
    <section>
        <div class="main">
            <div class="main__container">
                <div class="main__content">
                    <h1>NEXT GENERATION</h1>
                    <h2>Gaming</h2>
                    <p>See what makes us different.</p>
                    <br>
                    <button class="main__btn" class="scroll-btn"><a href="getstarted.html" class="link">Get Started</a></button>
                </div>
                <div class="main__img__container">
                    <img src="videogame.svg" alt="" id="main__img">
                </div>
            </div>
        </div>
    </section>
    <section class="section3">
        <form method="POST" action="signup.php">
            <input type="text" name="username" placeholder="Username" action="signup.php" required>
            <input type="email" name="email" placeholder="Email" action="signup.php" required>
            <input type="password" name="password" placeholder="Password" action="signup.php" required>
            <input type="text" name="passcode" placeholder="Passcode" action="signup.php" required>
            <button type="submit">Sign Up</button>
        </form>
        
    </section>
    <script scr="app.js"></script>
</body>
</html>