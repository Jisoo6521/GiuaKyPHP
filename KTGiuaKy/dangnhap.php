<?php

$servername = "localhost";
$username = "sa";
$password = "123456";
$database = "ql_nhansu";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form đăng nhập
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    // Tạo kết nối đến cơ sở dữ liệu
    $conn = new mysqli($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    // SQL để kiểm tra tên người dùng và mật khẩu trong cơ sở dữ liệu
    $sql = "SELECT * FROM nguoidung WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Đăng nhập thành công
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: main.php");
        echo "Đăng nhập thành công!";
    } else {
        // Đăng nhập thất bại
        echo "Tên người dùng hoặc mật khẩu không đúng!";
    }

    // Đóng kết nối
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
</body>
</html>