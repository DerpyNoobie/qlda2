<?php
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

$sql = "SELECT name, description, price, image_url FROM products WHERE category_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sản phẩm theo danh mục</title>
    <link rel="stylesheet" href="public/assets/styles.css">
</head>
<body>
    <h2>Sản phẩm trong danh mục</h2>
    <div class="product-list">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' width='100'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p>Giá: " . number_format($row['price'], 0, ',', '.') . " VND</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Không có sản phẩm nào trong danh mục này.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
