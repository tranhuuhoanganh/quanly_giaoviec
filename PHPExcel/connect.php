<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ketnoi"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}
?>
