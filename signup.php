<?php
session_start();
require 'db.php'; // Database connection
require 'PHPMailer/PHPMailer.php'; // Include PHPMailer for email sending

use PHPMailer\PHPMailer\PHPMailer;

// Function to send verification email
function sendVerificationEmail($email, $verificationCode) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com'; // SMTP username
    $mail->Password = 'your_password'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your_email@example.com', 'Your Website');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email';
    $mail->Body = "Click the link to verify your email: <a href='https://yourwebsite.com/verify.php?code=$verificationCode'>Verify Email</a>";

    return $mail->send();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $verificationCode = bin2hex(random_bytes(16));

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email already exists!";
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, verification_code, is_verified) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("ssss", $username, $email, $password, $verificationCode);

        if ($stmt->execute()) {
            if (sendVerificationEmail($email, $verificationCode)) {
                echo "Registration successful! Check your email to verify your account.";
            } else {
                echo "Failed to send verification email.";
            }
        } else {
            echo "Registration failed. Please try again.";
        }
    }

    $stmt->close();
}
?>