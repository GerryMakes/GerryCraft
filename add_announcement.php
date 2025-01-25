<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginsignup.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db.php'; // Include the database connection

    $announcement = trim($_POST['announcement']); // Get and trim the input

    // Validate the announcement
    if (empty($announcement)) {
        echo "Error: Announcement cannot be empty.";
        exit();
    }

    try {
        // Fetch all user emails
        $query = "SELECT email FROM users";
        $result = $conn->query($query); // Use $conn for mysqli

        if (!$result) {
            throw new Exception("Error fetching emails: " . $conn->error);
        }

        // Loop through each email and send the announcement
        while ($row = $result->fetch_assoc()) {
            $email = $row['email'];
            $subject = "New Announcement from GerryCraft";
            $headers = "From: admin@gerrycraft.org\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (!mail($email, $subject, $announcement, $headers)) {
                error_log("Failed to send email to $email");
            }
        }

        echo "Announcement sent successfully.";
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "An error occurred while sending the announcement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css?v=1.0">
    <title>Send Announcement</title>
</head>
<body>
    <h1>Add Announcement</h1>
    <form action="add_announcement.php" method="POST">
        <label for="announcement">Announcement:</label><br>
        <textarea id="announcement" name="announcement" rows="4" cols="50" required></textarea><br><br>
        <button type="submit">Send Announcement</button>
    </form>
    <footer class="footer">
        <p>&copy; 2025 GerryCraft. All Rights Reserved.</p>
    </footer>
</body>
</html>
