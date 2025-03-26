<?php
$host = 'localhost';
$username = 'root';
$password = ''; // sesuaikan dengan password MySQL Anda
$dbname = 'gereja_db';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
