<?php
session_start();
require_once "db.php";  // Assumes $conn is your MySQLi connection

// Only allow admins to delete messages
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message_id'])) {
    $message_id = intval($_POST['message_id']);

    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $message_id);
    if ($stmt->execute()) {
        echo "Message deleted";
    } else {
        echo "Error deleting message: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>
