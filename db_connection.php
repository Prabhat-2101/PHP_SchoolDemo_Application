<?php
$servername = "localhost"; 
$username = "root"; 
$database = "school_db";

$conn = new mysqli($servername, $username, "", $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>