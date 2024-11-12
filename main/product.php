<?php
// Bắt đầu phiên làm việc và kết nối cơ sở dữ liệu
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elecs";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Biến để lưu trữ sản phẩm và kiểm tra sản phẩm có hợp lệ
$product = null;

// Kiểm tra nếu có từ khóa tìm kiếm hoặc product_id
if (isset($_GET['query']) || isset($_GET['product_id'])) {
    if (isset($_GET['query'])) {
        // Truy vấn tìm kiếm sản phẩm theo tên
        $query = $_GET['query'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("s", $searchTerm);
    } else {
        // Truy vấn tìm kiếm theo product_id
        $product_id = $_GET['product_id'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Lấy sản phẩm đầu tiên tìm được (nếu có)
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_id = $product['product_id'];
    } else {
        echo "<p>Không tìm thấy sản phẩm.</p>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm - <?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'Không tìm thấy sản phẩm'; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="comment.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f0f0f0; }
        .container { width: 80%; margin: 20px auto; padding: 20px; background-color: white; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .product-image { width: 100%; max-width: 400px; }
        .product-details { display: flex; gap: 20px; }
        .product-info { flex: 1; }
        .product-info h1 { font-size: 24px; color: #333; }
        .product-info p { color: #666; line-height: 1.6; }
        .product-price { font-size: 20px; color: #ff4081; font-weight: bold; }
        .old-price { text-decoration: line-through; color: #999; margin-left: 10px; }
        .buy-now { display: inline-block; padding: 10px 20px; background-color: #007aff; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($product): ?>
                <!-- Form tìm kiếm -->
            <form action="product.php" method="GET" class="search-bar">
                <input type="text" name="query" placeholder="Nhập tên sản phẩm" required>
                <button type="submit">Tìm kiếm</button>
            </form>
            <div class="product-details">
                <div>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                </div>
                <div class="product-info">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="product-price">
                        <?php echo number_format($product['price'], 0, ',', '.'); ?> VND
                        <?php if (!empty($product['old_price'])): ?>
                            <span class="old-price"><?php echo number_format($product['old_price'], 0, ',', '.'); ?> VND</span>
                        <?php endif; ?>
                    </p>
                    <a href="main/add_to_cart.php?product_id=<?php echo $product['product_id']; ?>" class="buy-now">Mua ngay</a>
                </div>
            </div>
            <div class="review-section">
                <h3>Đánh giá sản phẩm</h3>
                <form action="submit_review.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <label for="rating">Đánh giá:</label>
                    <select id="rating" name="rating" required>
                        <option value="1">1 Sao</option>
                        <option value="2">2 Sao</option>
                        <option value="3">3 Sao</option>
                        <option value="4">4 Sao</option>
                        <option value="5">5 Sao</option>
                    </select>
                    <label for="comment">Bình luận:</label>
                    <textarea id="comment" name="comment" required></textarea>
                    <button type="submit">Gửi đánh giá</button>
                </form>

                <?php
                // Hiển thị đánh giá sản phẩm
                $stmt = $conn->prepare("SELECT users.username, reviews.rating, reviews.comment, reviews.created_at 
                                        FROM reviews 
                                        JOIN users ON reviews.user_id = users.user_id 
                                        WHERE reviews.product_id = ?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $reviews = $stmt->get_result();

                if ($reviews->num_rows > 0) {
                    while ($review = $reviews->fetch_assoc()) {
                        echo "<div class='review'>";
                        echo "<strong>{$review['username']} - {$review['rating']} Sao</strong>";
                        echo "<p>{$review['comment']}</p>";
                        echo "<small>Ngày: {$review['created_at']}</small>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Chưa có đánh giá cho sản phẩm này.</p>";
                }
                $stmt->close();
                ?>
            </div>
        <?php else: ?>
            <p>Vui lòng tìm kiếm một sản phẩm hoặc chọn một sản phẩm hợp lệ.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
