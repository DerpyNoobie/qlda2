<html>
 <head>
  <title>
   Điện máy XANH
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .header {
            background-color: #007aff;
            padding: 10px 0;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .logo {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }
        .header .logo img {
            height: 40px;
        }
        .header .logo span {
            font-size: 24px;
            font-weight: bold;
            margin-left: 10px;
        }
        .header .search-bar {
            display: flex;
            align-items: center;
        }
        .header .search-bar input {
            padding: 5px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            width: 300px;
        }
        .header .search-bar button {
            padding: 5px 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #ffcc00;
            margin-left: 5px;
        }
        .header .user-options {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }
        .header .user-options a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
        }
        .header .user-options a i {
            margin-right: 5px;
        }
        .nav-bar {
            background-color: #f8f8f8;
            padding: 10px 0;
            display: flex;
            justify-content: center;
        }
        .nav-bar a {
            color: #007aff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 16px;
        }
        .banner {
            background-color: #ff4081;
            padding: 20px;
            text-align: center;
            color: white;
            position: relative;
        }
        .banner img {
            max-width: 100%;
            height: auto;
        }
        .banner .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: white;
            color: #ff4081;
            border: none;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
        }
        .product-categories {
            display: flex;
            justify-content: space-around;
            background-color: white;
            padding: 20px 0;
            margin: 20px 0;
        }
        .product-categories div {
            text-align: center;
        }
        .product-categories img {
            width: 50px;
            height: 50px;
        }
        .product-categories span {
            display: block;
            margin-top: 10px;
            font-size: 14px;
        }
        .promotions {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
        }
        .promotions h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .promotions .promotion-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .promotions .promotion-item img {
            width: 100px;
            height: 100px;
        }
        .promotions .promotion-item .details {
            flex: 1;
            margin-left: 20px;
        }
        .promotions .promotion-item .details h3 {
            font-size: 16px;
            margin: 0;
        }
        .promotions .promotion-item .details p {
            margin: 5px 0;
        }
        .promotions .promotion-item .details .price {
            color: #ff4081;
            font-size: 18px;
            font-weight: bold;
        }
        .promotions .promotion-item .details .old-price {
            text-decoration: line-through;
            color: #999;
        }
  </style>
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
        $sobg_moitrang = 6;
        $pages = ceil($ts_banghi / $sobg_moitrang);
        $offset = 0;
        if (isset($_GET["page"])) {
            $offset = ($_GET["page"] - 1) * $sobg_moitrang;
        }

        $sql = "SELECT * FROM products LIMIT $sobg_moitrang OFFSET $offset";
        $result = $conn->query($sql);
    ?>
  <div class="header">
   <div class="logo">
    <img alt="Logo" height="40" src="https://storage.googleapis.com/a1aa/image/mylyLKCkYlrtGdtPhUwBwsGK28OTaoRR5MajXoUeZJUQ5D4JA.jpg" width="40"/>
    <span>
     ElecS Store
    </span>
   </div>
   <div class="search-bar">
        <form action="main\product.php" method="GET" class="search-bar">
        <input type="text" name="query" placeholder="Nhập tên sản phẩm" required>
        <button type="submit">Tìm kiếm</button>
   </div>
   <div class="user-options">
        <div class="login">
            <a href = "main/login.php"> Đăng nhập </a>
        </div>
        <div class="sign-up">
            <a href = "main/register.php"> Đăng ký </a> 
        </div>
     <div class="sign-up">
         <i class="fas fa-shopping-cart">
            <a href = "main/cart.php"> Giỏ hàng </a> 
        </i>
    </div>
   </div>
  </div>
  <div class="nav-bar">
    <?php
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<a href='main/product.php?product_id={$row['product_id']}'>{$row['name']}</a>";
            $i++;
        }
    ?>
  </div>
  <div class="banner">
   <img alt="Banner" height="300" src="https://storage.googleapis.com/a1aa/image/PelelF7G8Vlm10vnUeQ1ujlj5aBb9Fnhwwg2FMwPiAafIfAeE.jpg" width="1200"/>
   <button class="close-btn">
    ×
   </button>
  </div>
  <div class="product-categories">
   <div>
    <img alt="Máy giặt" height="50" src="https://storage.googleapis.com/a1aa/image/Y9R7hmRFUh5HOhfaceoQinsHIlY7radMNWh0h7nGf1bwkPgnA.jpg" width="50"/>
    <span>
     Máy giặt
    </span>
   </div>
   <div>
    <img alt="Máy lọc nước" height="50" src="https://storage.googleapis.com/a1aa/image/fFHZDcfCShoA40GdC8q3fOEnq4FvXFHRkGBgrLpzHIvYkPgnA.jpg" width="50"/>
    <span>
     Máy lọc nước
    </span>
   </div>
   <div>
    <img alt="Tủ lạnh" height="50" src="https://storage.googleapis.com/a1aa/image/GyeEV8H9loQiQqStEfQJvOggCg9crn13rXYFLLILRw3ekPgnA.jpg" width="50"/>
    <span>
     Tủ lạnh
    </span>
   </div>
   <div>
    <img alt="Nồi cơm điện" height="50" src="https://storage.googleapis.com/a1aa/image/tUzHjRLuqJLhN1Xixij4oaLG6TFjXXivt5bFg1DLtY7m8B8E.jpg" width="50"/>
    <span>
     Nồi cơm điện
    </span>
   </div>
   <div>
    <img alt="Máy lạnh" height="50" src="https://storage.googleapis.com/a1aa/image/CVOxMxHCXb5YEZgdVyauRyA9x1LJkLgHCQFBseB51wrI5D4JA.jpg" width="50"/>
    <span>
     Máy lạnh
    </span>
   </div>
   <div>
    <img alt="Bếp từ" height="50" src="https://storage.googleapis.com/a1aa/image/bw5qdhBVusb6MR6r5GdWTf50NgasfDVt3hKPDQqkTRenkPgnA.jpg" width="50"/>
    <span>
     Bếp từ
    </span>
   </div>
   <div>
    <img alt="Tủ đông mát" height="50" src="https://storage.googleapis.com/a1aa/image/YjpKINAmYe3zSCpCqxuJP1ACx9QmfJ70CyjTUsrfEXokkPgnA.jpg" width="50"/>
    <span>
     Tủ đông mát
    </span>
   </div>
   <div>
    <img alt="Nồi chiên không dầu" height="50" src="https://storage.googleapis.com/a1aa/image/tvdVZ72ifh3SbSjgd4za9RGa3sbxI7Bz2m1re6mf43LVkPgnA.jpg" width="50"/>
    <span>
     Nồi chiên không dầu
    </span>
   </div>
   <div>
    <img alt="Loa" height="50" src="https://storage.googleapis.com/a1aa/image/WIm6AQXK9QbVFB6SyRs3uyWew9EZKfzRXz9oTVgniLVcyHwTA.jpg" width="50"/>
    <span>
     Loa
    </span>
   </div>
   <div>
    <img alt="Tất cả danh mục" height="50" src="https://storage.googleapis.com/a1aa/image/GSGdghihCg4cI1XwSwm83qsk72syM3n5BalTeFEZ7djD5D4JA.jpg" width="50"/>
    <span>
     Tất cả danh mục
    </span>
   </div>
  </div>
  <div class="promotions">
   <h2>
    Khuyến mãi Online
   </h2>
   <div class="promotion-item">
    <img alt="Flash Sale" height="100" src="https://storage.googleapis.com/a1aa/image/fFnEiVPg5cQCH6nGnJzYcj8UHjDV6Qcwofcrc91HleTrkPgnA.jpg" width="100"/>
    <div class="details">
     <h3>
      Flash Sale
     </h3>
     <p>
      Giá sốc
     </p>
     <p class="price">
      1.990.000đ
     </p>
     <p class="old-price">
      2.490.000đ
     </p>
    </div>
   </div>
   <div class="promotion-item">
    <img alt="Gia dụng Sale 11.11" height="100" src="https://storage.googleapis.com/a1aa/image/dbS7zJqGFEJTGtbMR5fvwzf8MuZMxnfiFalFUAsGID6skPgnA.jpg" width="100"/>
    <div class="details">
     <h3>
      Gia dụng Sale 11.11
     </h3>
     <p>
      Giảm ngay 1.500.000đ
     </p>
     <p class="price">
      5.490.000đ
     </p>
     <p class="old-price">
      7.390.000đ
     </p>
    </div>
   </div>
   <div class="promotion-item">
    <img alt="Toshiba giảm đến 5 triệu" height="100" src="https://storage.googleapis.com/a1aa/image/9ffnHIDgYzt1QUebXIQVJR2injYkqeOYpAvpsXEDejssReB8E.jpg" width="100"/>
    <div class="details">
     <h3>
      Toshiba giảm đến 5 triệu
     </h3>
     <p>
      Giảm 8%
     </p>
     <p class="price">
      5.190.000đ
     </p>
     <p class="old-price">
      5.690.000đ
     </p>
    </div>
   </div>
   <div class="promotion-item">
    <img alt="Hàng cao cấp" height="100" src="https://storage.googleapis.com/a1aa/image/CifFlhIFCwyedkwmHIcCtAeMZoP7lMBe6qVsQKfxpPa6SeB8E.jpg" width="100"/>
    <div class="details">
     <h3>
      Hàng cao cấp
     </h3>
     <p>
      Giảm 16%
     </p>
     <p class="price">
      11.190.000đ
     </p>
     <p class="old-price">
      13.400.000đ
     </p>
    </div>
   </div>
  </div>
 </body>
</html>
