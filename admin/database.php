<?php
// Database credentials
$host = 'localhost';
$username = 'u423358681_huhadmin';
$password = '@?Huhadmin254';
$database = 'u423358681_huh';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}