<?php
$servername = "127.0.0.1";  // Use the same host as in phpMyAdmin config
$username = "root";
$password = "gcesitexpo2024";  // No password set
$dbname = "voting";  // Replace with your actual database name
$port = 3307;  // Use the same port as in phpMyAdmin config

// Create connection
$con = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($con->connect_error) {
    die("Connection to Database failed: " . $con->connect_error);
}
// echo "Connected successfully";
?>
