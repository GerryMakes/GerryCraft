<?php
session_start();
require 'db.php'; // Ensure this connects to your database

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginsignup.php");
    exit();
}

// Fetch all unique DM conversations
$sql = "SELECT DISTINCT 
            LEAST(sender_id, receiver_id) AS user1, 
            GREATEST(sender_id, receiver_id) AS user2
        FROM messages";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result(); // MySQLi method to get results

$conversations = [];
while ($row = $result->fetch_assoc()) {
    $conversations[] = $row;
}

// Fetch usernames for each user ID
$usernames = [];
foreach ($conversations as $conv) {
    $user1 = $conv['user1'];
    $user2 = $conv['user2'];
    
    if (!isset($usernames[$user1])) {
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$user1]);
        $usernames[$user1] = $stmt->fetchColumn();
    }
    if (!isset($usernames[$user2])) {
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$user2]);
        $usernames[$user2] = $stmt->fetchColumn();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Chat Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            height: 100vh;
        }
        .chat-list {
            list-style: none;
            padding: 0;
        }
        .chat-list li {
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 5px;
            cursor: pointer;
            background: #f8f9fa;
        }
        #chat-container {
            display: none;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            height: 300px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 8px;
            padding: 6px;
            border-radius: 4px;
        }
        .sent { background: #d1e7dd; text-align: right; }
        .received { background: #f8d7da; text-align: left; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Admin Chat Panel</h2>
    <ul class="chat-list">
        <?php foreach ($conversations as $conv): ?>
            <li onclick="loadChat(<?php echo $conv['user1']; ?>, <?php echo $conv['user2']; ?>)">
                <?php echo htmlspecialchars($usernames[$conv['user1']]) . " → " . htmlspecialchars($usernames[$conv['user2']]); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <div id="chat-container">
        <h3>Chat with <span id="chat-user"></span></h3>
        <div id="messages"></div>
        <form id="message-form">
            <input type="text" id="message-input" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
    
    <script>
        let currentUser1, currentUser2;
        function loadChat(user1, user2) {
            currentUser1 = user1;
            currentUser2 = user2;
            $("#chat-user").text(user1 + " ↔ " + user2);
            $("#chat-container").show();
            fetchMessages();
        }
        function fetchMessages() {
            $.ajax({
                url: 'get_messages.php',
                method: 'GET',
                data: { user1: currentUser1, user2: currentUser2 },
                dataType: 'json',
                success: function(messages) {
                    let container = $('#messages');
                    container.empty();
                    messages.forEach(msg => {
                        let messageClass = (msg.sender_id == currentUser1) ? 'sent' : 'received';
                        container.append(`<div class="message ${messageClass}">
                                            <p>${msg.message}</p>
                                            <small>${msg.sent_at}</small>
                                            <button onclick="deleteMessage(${msg.id})">Delete</button>
                                          </div>`);
                    });
                    container.scrollTop(container[0].scrollHeight);
                }
            });
        }
        $('#message-form').submit(function(e) {
            e.preventDefault();
            let message = $('#message-input').val();
    
            $.post('send_message.php', { 
                sender_id: currentUser1, 
                receiver_id: currentUser2, 
                message: message 
            }, function(response) {
                $('#message-input').val('');
                fetchMessages();
            }, 'json');
        });
        function deleteMessage(id) {
            if (confirm("Delete this message?")) {
                $.post('delete_message.php', { message_id: id }, function() {
                    fetchMessages();
                });
            }
        }
    </script>
</body>
</html>
