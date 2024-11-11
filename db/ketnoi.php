<?php
$server = "localhost";
$user = "root";
$pass = "";
$db_name = "elecs";

$conn = new mysqli($server, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Lỗi kết nối" . $conn->connect_error);
}
?>