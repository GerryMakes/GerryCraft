<?php
session_start();
require_once "db.php";

header("Content-Type: application/json");

// Logged-in user
$user_id = $_SESSION['id'] ?? 0;
// The conversation partner's user id (sent via GET)
$other_id = intval($_GET['other_id'] ?? 0);

if ($user_id && $other_id) {
    // Get all messages where sender and receiver match (both directions)
    $sql = "SELECT sender_id, receiver_id, message, sent_at 
            FROM messages 
            WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
            ORDER BY sent_at ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $user_id, $other_id, $other_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
    $stmt->close();
} else {
    echo json_encode([]);
}
?>
