<?php
session_start();
require_once "db.php";

header("Content-Type: application/json");

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);
    $username = $conn->real_escape_string($username);

    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id);
        $stmt->fetch();
        echo json_encode(['success' => true, 'id' => $id]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}
$conn->close();
?>
