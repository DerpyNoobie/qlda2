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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];
    $inputEmail = $_POST['email'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Username đã có sẵn. Hãy nhập một username khác.";
    } else {
        $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, email, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $inputUsername, $hashedPassword, $inputEmail);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Lỗi: Không thể đăng ký người dùng.";
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="public\assets\user.css">
</head>
<body>
    <h2>Đăng ký</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($_SESSION['message'])) echo "<p style='color:green;'>{$_SESSION['message']}</p>"; unset($_SESSION['message']); ?>

    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
