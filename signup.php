<?php
require 'db.php';

echo'made it to line 4';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    echo'made it to line 15';

    $stmt->bind_param('sss', $username, $email, $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        die('Execute failed: ' . $stmt->error);
    }
    echo'made it to line 24';

    $stmt->close();
    $conn->close();
}
?>
