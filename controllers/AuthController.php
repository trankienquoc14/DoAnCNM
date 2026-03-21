<?php
require_once "../config/database.php";
require_once "../models/User.php";

session_start();

$db = (new Database())->connect();
$user = new User($db);

# ================= REGISTER =================
if (isset($_POST['action']) && $_POST['action'] == "register") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 🔥 Validate
    if (empty($name) || empty($email) || empty($password)) {
        die("Vui lòng nhập đầy đủ thông tin");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email không hợp lệ");
    }

    if (strlen($password) < 6) {
        die("Mật khẩu phải >= 6 ký tự");
    }

    // 🔥 Gọi model (model phải hash password)
    $userModel->register(
    $_POST['name'],
    $_POST['email'],
    $_POST['password'],
    $_POST['phone'] // ✅ thêm dòng này
);

    if ($result) {
        header("Location: ../views/login.php?success=1");
        exit();
    } else {
        die("Đăng ký thất bại (có thể email đã tồn tại)");
    }
}

# ================= LOGIN =================
if (isset($_POST['action']) && $_POST['action'] == "login") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 🔥 Validate
    if (empty($email) || empty($password)) {
        die("Thiếu thông tin đăng nhập");
    }

    // 🔥 Lấy user
    $data = $user->login($email);

    if (!$data) {
        die("Email không tồn tại");
    }

    // 🔥 So sánh password chuẩn
    if (password_verify($password, $data['password'])) {

        // 🔥 Session chuẩn hơn
        $_SESSION['user'] = [
            'id' => $data['user_id'],
            'name' => $data['name'] ?? $data['full_name'] ?? 'User',
            'role' => $data['role']
        ];
       
        header("Location: ../views/tours.php");

    } else {
        die("Sai mật khẩu");
    }
}
?>