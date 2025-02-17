<?php
session_start();

// Ensure the user is logged in and has an allowed role (either user or admin)
if (!isset($_SESSION['id']) || (!in_array($_SESSION['role'], ['user', 'admin']))) {
    header("Location: loginsignup.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Direct Message Chat</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }
    /* Partner selection form */
    #partner-selection {
      margin-bottom: 20px;
    }
    #partner-selection input {
      padding: 5px;
      font-size: 16px;
    }
    #partner-selection button {
      padding: 6px 10px;
      font-size: 16px;
      cursor: pointer;
    }
    /* Chat heading */
    #chat-heading {
      margin-bottom: 10px;
    }
    /* Chat container */
    #chat-container {
      flex: 1;
      border: 1px solid #ccc;
      padding: 10px;
      overflow-y: auto;
      margin-bottom: 10px;
    }
    /* Message form */
    #message-form {
      display: flex;
    }
    #message-input {
      flex: 1;
      padding: 10px;
      font-size: 16px;
    }
    #send-btn {
      padding: 10px 20px;
      font-size: 16px;
    }
    /* Message styling */
    .message {
      margin-bottom: 8px;
      padding: 6px;
      border-radius: 4px;
    }
    .sent {
      background: #d1e7dd;
      text-align: right;
    }
    .received {
      background: #f8d7da;
      text-align: left;
    }
  </style>
  <!-- Include jQuery for simplicity -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h2>Direct Message Chat</h2>
  
  <!-- Partner Selection -->
  <div id="partner-selection">
      <label for="partner-username">Chat with (username): </label>
      <input type="text" id="partner-username" placeholder="Enter username" required>
      <button id="start-chat">Start Chat</button>
  </div>
  
  <!-- Chat heading (will show partner's username) -->
  <h3 id="chat-heading" style="display:none;"></h3>
  
  <!-- Chat container -->
  <div id="chat-container" style="display:none;">
      <!-- Messages will load here -->
  </div>
  
  <!-- Message form -->
  <form id="message-form" style="display:none;">
      <input type="text" id="message-input" placeholder="Type your message here..." autocomplete="off" required>
      <button type="submit" id="send-btn">Send</button>
  </form>
  
  <script>
    // Global variables to store conversation partner's info
    let other_id = null;        // Will store partner's user id
    let other_username = "";      // Will store partner's username

    // When the user clicks "Start Chat", get the partner's username and lookup the user id via AJAX
    $("#start-chat").on("click", function() {
        const partnerUsername = $("#partner-username").val().trim();
        if (partnerUsername === "") {
            alert("Please enter a username.");
            return;
        }
        // AJAX call to get partner user id from get_user_id.php
        $.ajax({
            url: "get_user_id.php",
            method: "GET",
            data: { username: partnerUsername },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    other_id = response.id;
                    other_username = partnerUsername;
                    $("#chat-heading").text("Chat with " + other_username).show();
                    $("#chat-container").show();
                    $("#message-form").show();
                    loadMessages();
                } else {
                    alert("User not found.");
                }
            },
            error: function(err) {
                console.error("Error retrieving user id:", err);
            }
        });
    });

    // Function to load messages via AJAX
    function loadMessages() {
        if (!other_id) return;
        $.ajax({
            url: 'get_messages.php',
            data: { other_id: other_id },
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const container = $('#chat-container');
                container.empty();
                data.forEach(msg => {
                    // Check if the message is sent by the logged-in user
                    const messageClass = (msg.sender_id == <?php echo $_SESSION['id'] ?? 0; ?>) ? 'sent' : 'received';
                    container.append(`<div class="message ${messageClass}">
                                          <p>${msg.message}</p>
                                          <small>${msg.sent_at}</small>
                                       </div>`);
                });
                // Scroll to the bottom of the chat container
                container.scrollTop(container[0].scrollHeight);
            },
            error: function(err) {
                console.error("Error loading messages:", err);
            }
        });
    }

    // Poll for new messages every 3 seconds
    setInterval(loadMessages, 3000);

    // Handle message send
    $('#message-form').submit(function(e) {
        e.preventDefault();
        const message = $('#message-input').val().trim();
        if (!message || !other_id) return;
        $.ajax({
            url: 'send_message.php',
            method: 'POST',
            data: { receiver_id: other_id, message: message },
            success: function(response) {
                $('#message-input').val('');
                loadMessages();
            },
            error: function(err) {
                console.error("Error sending message:", err);
            }
        });
    });
  </script>
</body>
</html>
