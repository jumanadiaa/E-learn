<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elearning_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Remove or comment out the next line to stop displaying "Connected successfully"
// echo "Connected successfully";
?>
