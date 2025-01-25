<?php
// Start session
session_start();

// Include database configuration
require_once "db.php";  // Make sure this is included

// Define variables and initialize with empty values
$identifier = $password = "";
$identifier_err = $password_err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $identifier = trim($_POST['identifier']);
    $password = trim($_POST['password']);

    // Check if both fields are filled
    if (empty($identifier) || empty($password)) {
        echo "Both fields are required.";
    } else {
        // Prepare the SQL query to check if the identifier (username or email) exists
        $sql = "SELECT id, username, email, password, role FROM users WHERE username = ? OR email = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {  // Use $conn instead of $link
            // Bind parameters to the statement
            $stmt->bind_param("ss", $identifier, $identifier);

            // Execute the statement
            $stmt->execute();

            // Store the result
            $stmt->store_result();

            // Check if a matching user was found
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($id, $username, $email, $hashed_password, $role);

                // Fetch the result
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, store session variables
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    // Debugging: Check if session variables are set
                    echo "Session variables: ";
                    print_r($_SESSION);  // Print session variables to verify they are set

                    // Redirect based on user role
                    if ($role == 'admin') {
                        echo "Redirecting to admin panel...";  // Debugging line
                        header("Location: admin_panel.php");
                        exit;  // Ensure script stops after redirect
                    } else {
                        echo "Redirecting to user homepage...";  // Debugging line
                        header("Location: index.php");
                        exit;  // Ensure script stops after redirect
                    }
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No account found with this username or email.";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the query.";
        }
    }
}
?>
