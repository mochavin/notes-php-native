<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "fp_pweb";

// Create a new mysqli object
$mysqli = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($mysqli->connect_errno) {
  die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

?>