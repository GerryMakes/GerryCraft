<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['id'])) {
    header("Location: loginsignup.php");
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = trim($_POST['verification_code']);

    // Retrieve the stored code
    $sql = "SELECT verification_code FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_code);
    $stmt->fetch();
    $stmt->close();

    if ($entered_code === $stored_code) {
        // Mark user as verified
        $update_sql = "UPDATE users SET is_verified = 1, verification_code = NULL WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $user_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo "Verification successful! Redirecting...";
        header("Refresh: 2; URL=index.php");
        exit();
    } else {
        echo "Invalid verification code.";
    }
}
?>

<form method="POST">
    <label for="verification_code">Enter Verification Code:</label>
    <input type="text" name="verification_code" required>
    <button type="submit">Verify</button>
</form>
