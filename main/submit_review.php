<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = "";    
$dbname = "elecs";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];  // Giả sử người dùng đã đăng nhập
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
    
    if ($stmt->execute()) {
        header("Location: itemdetail.php?product_id=" . $product_id);
        exit();
    } else {
        echo "Có lỗi xảy ra. Vui lòng thử lại.";
    }
}
?>
