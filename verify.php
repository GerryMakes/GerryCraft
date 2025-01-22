<?php
require 'db.php';

if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_code = ? AND is_verified = 0");
    $stmt->bind_param("s", $verificationCode);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE verification_code = ?");
        $stmt->bind_param("s", $verificationCode);
        $stmt->execute();
        echo "Email verified successfully! You can now log in.";
    } else {
        echo "Invalid or expired verification code.";
    }

    $stmt->close();
}
?>
