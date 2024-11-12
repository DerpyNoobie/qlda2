<?php
$servername = "localhost";
$username = "root"; 
$password = "";    
$dbname = "elecs";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "SELECT category_id, name FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh mục sản phẩm</title>
    <link rel="stylesheet" href="public/assets/styles.css">
</head>
<body>
    <h2>Danh mục loại sản phẩm</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li><a href='filtered_products.php?category_id=" . $row["category_id"] . "'>" . $row["name"] . "</a></li>";
            }
        } else {
            echo "Không có danh mục sản phẩm nào.";
        }
        ?>
    </ul>
</body>
</html>

<?php
$conn->close();
?>
