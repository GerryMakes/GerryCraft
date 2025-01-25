<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: signin.php");
            exit;
        } else {
            die("Something went wrong. Please try again later.");
        }
    } else {
        die("Something went wrong. Please try again later.");
    }
    $stmt->close();
}
$link->close();
?>
