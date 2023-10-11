<?php

// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "music";

// Create a database connection
$conn = mysqli_connect($host, $user, $password, $database);


// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
