<?php
$host = 'localhost';
$username = 'root';
$password = 'Database$99';
$database = 'user_auth';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>