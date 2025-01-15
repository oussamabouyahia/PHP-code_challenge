<?php

$host = 'localhost';
$username = 'root'; 
$password = 'root'; 
$database = 'event_booking_system';


$conn = new mysqli($host, $username, $password, $database);

// connection test
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
