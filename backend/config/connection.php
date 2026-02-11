<?php
$servername = "localhost";
$username   = "root";      // Default for XAMPP/WAMP
$password   = "";          // Default is empty
$dbname     = "felamo";    // <--- IMPORTANT: CHANGE THIS TO YOUR DATABASE NAME

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>