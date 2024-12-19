<?php

// //Define connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$thirdparty = 'thirdparty';

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $thirdparty);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database!";
}
?>