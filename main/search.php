<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "elecs";

$conn = new mysqli($server, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Lỗi kết nối" . $conn->connect_error);
}

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $stmt = $conn->prepare("SELECT product_id, name, description, price, image_url FROM products WHERE name LIKE ? OR description LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Search Results for '$query'</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: " . $row['price'] . "</p>";
            echo "<img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' />";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Không tìm thấy sản phẩm nào.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
