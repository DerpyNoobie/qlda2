<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Electronics Store</title>
    <link rel="stylesheet" href="public\assets\main.css">
</head>
<body>
<?php

//kết nối sql
include("db/ketnoi.php");

//sql số trang
$sql_tong = "select count(product_id) as ts from products";

$result = $conn->query($sql_tong);
$result1 = $conn->query("SELECT*FROM categories");
$row = $result->fetch_assoc();
$row1 = $result1->fetch_assoc();

$ts_banghi = $row['ts'];
$sobg_moitrang = 10;
$pages = ceil($ts_banghi / $sobg_moitrang);
$offset = 0;
if (isset($_GET["page"])) {
    $offset = ($_GET["page"] - 1) * $sobg_moitrang;
}

$sql = "SELECT * FROM products LIMIT $sobg_moitrang OFFSET $offset";
$result = $conn->query($sql);
?>

<div class="header">
    <h2><i>Electronics Store</i></h2>
    <h2><i>Nhóm 2 - QLDA</i></h2>
    <div class="search">
        <form action="main\search.php" method="GET" class="search-bar">
        <input type="text" name="query" placeholder="Nhập tên sản phẩm" required>
        <button type="submit">Tìm kiếm</button>
    </div>
    <div class="login">
            <a href = "main/user/login.php"> Đăng nhập </a>
        </div>
        <div class="sign-up">
            <a href = "main/user/register.php"> Đăng ký </a> 
        </div>
</form>

</div>


<div class="container">
    <div class="sidebar">
        <div class="sidebar-header">
            <b><i>Danh mục loại sản phẩm</i></b>
        </div>
        <?php
        while ($row1 = $result1->fetch_assoc()) {
            echo '<div class="sidebar-content">';
            echo '<tr><td><a href="XlyPhantrang.php">' . $row1["Tenloai"] . '</a></td></tr>';
            echo '</div>';
        }
        ?>
    </div>
    </br>

    <div class="main">
        <h2 style="text-align:center;"><i>Danh mục sản phẩm</i></h2>
        <table>

            <tr>
                <th>STT</th>
                <th>Mã hàng</th>
                <th>Tên hàng</th>
                <th>Hình ảnh</th>
                <th> </th>
            </tr>


            <div class="danhmucsp">
                <?php
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style = 'text-align: center;'>{$i}</td>";
                    echo "<td style = 'text-align: center;'>{$row['categories']}</td>";
                    echo "<td >{$row['name']}</td>";
                    echo "<td><img src='image/'" . $row["image_url"] . " alt=" . $row["name"] . "></td>";
                    echo "<td>{$row['description']}</td>";
                    echo "</tr>";
                    $i++;
                }

                //Đóng kết nối
                $conn->close();

                ?>
            </div>
    </div>
    </table>

    <div class="pagination">
        <?php
        $p = 1;
        while ($p <= $pages) {
            echo "<a href='Sanpham.php?page={$p}'>$p</a>&nbsp";
            $p++;
        }
        ?>
    </div>
</body>
</html>
