<?php
// 1. Phải có dòng này ở ĐẦU TIÊN để nhận diện người dùng đã đăng nhập hay chưa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Nhúng các file Controller
require_once '../controllers/TourController.php';
require_once '../controllers/PaymentController.php';
require_once '../controllers/AuthController.php';
// BỔ SUNG DÒNG NÀY ĐỂ HỆ THỐNG TÌM THẤY REVIEWCONTROLLER
require_once '../controllers/ReviewController.php';

// 3. Lấy hành động từ URL
$action = $_GET['action'] ?? 'home';

// 4. Phân luồng Controller
// Sửa thành: Bổ sung thêm 'webhook' và 'checkPaymentStatus'
if ($action === 'payment' || $action === 'confirmPayment' || $action === 'webhook' || $action === 'checkPaymentStatus') {
    $c = new PaymentController();
} elseif ($action === 'login' || $action === 'register' || $action === 'logout' || $action === 'profile' || $action === 'updateProfile' || $action === 'updatePassword') {
    $c = new AuthController();
} elseif ($action === 'submitReview') {
    $c = new ReviewController();
} else {
    // Các action: home, tours, detail, booking, confirmBooking, myBookings, bookingDetail
    $c = new TourController();
}

// 5. Kiểm tra hàm có tồn tại không
if (!method_exists($c, $action)) {
    // Debug nhỏ: Nếu lỗi 404, hãy kiểm tra xem tên hàm trong Controller có viết hoa đúng bookingDetail không
    die("404 - Không tìm thấy hành động: " . htmlspecialchars($action) . " trong " . get_class($c));
}

// 6. Chạy hàm
$c->$action();