<?php
$servername = "localhost";
$username = "root";       // Default XAMPP MySQL username
$password = "";           // Default XAMPP MySQL password is empty
$dbname = "book_exchange";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

