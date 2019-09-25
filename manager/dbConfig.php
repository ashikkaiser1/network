<?php
$servername = "localhost";
$username = "clickoffer";
$password = "clickoffer";
$dbname = "clickoffer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>