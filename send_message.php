<?php
session_start();
require_once "db.php"; // Assumes $conn is your MySQLi connection

header('Content-Type: application/json'); // Set response type to JSON

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if sender is logged in
    if (!isset($_SESSION['id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit();
    }

    $sender_id = $_SESSION['id'];
    $receiver_id = isset($_POST['receiver_id']) ? intval($_POST['receiver_id']) : 0;
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validate inputs
    if ($receiver_id === 0 || empty($message)) {
        echo json_encode(["error" => "Missing or invalid parameters"]);
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo json_encode(["error" => "Database error: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => "Message sent!"]);
    } else {
        echo json_encode(["error" => "Error sending message: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
