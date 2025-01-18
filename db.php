<?php
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "Database$99";  // Your MySQL password
$db = "user_auth";  // Your database name

$conn=new mysqli($servername,$username,$password,$db);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}
?>