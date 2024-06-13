<?php
// Database Connection Details
$host = "localhost";         // e.g., "localhost" or your server's IP address
$user = "root";    // Your MySQL username
$password = ""; // Your MySQL password
$database = "nkosinathitavern";     // The name of your database

// Create a Connection
$mysqli = new mysqli($host, $user, $password, $database);

// Check for Errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 

?>
