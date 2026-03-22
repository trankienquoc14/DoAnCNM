<?php
require_once __DIR__ . '/../config/database.php';

class ReviewController {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Kiểm tra đăng nhập
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?action=login");
                exit;
            }

            // 2. Lấy và làm sạch dữ liệu
            $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];
            $tour_id = $_POST['tour_id'] ?? 0;
            $booking_id = $_POST['booking_id'] ?? 0; // Thêm booking_id
            $rating = $_POST['rating'] ?? 5;
            $comment = trim($_POST['comment'] ?? '');

            // Chốt chặn 1: Chống lỗi CSDL nếu mất ID
            if (empty($tour_id) || empty($booking_id)) {
                echo "<script>alert('Lỗi dữ liệu: Không tìm thấy mã Tour hoặc mã Đơn hàng.'); history.back();</script>";
                exit;
            }

            // Chốt chặn 2: Kiểm tra xem đơn hàng này đã đánh giá chưa (Tránh spam)
            $checkStmt = $this->db->prepare("SELECT review_id FROM reviews WHERE booking_id = ?");
            $checkStmt->execute([$booking_id]);
            if ($checkStmt->rowCount() > 0) {
                echo "<script>alert('Bạn đã đánh giá chuyến đi này rồi. Xin cảm ơn!'); window.location.href='index.php?action=myBookings';</script>";
                exit;
            }

            // 3. Lưu vào bảng reviews
            $stmt = $this->db->prepare("
                INSERT INTO reviews (user_id, booking_id, tour_id, rating, comment, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            if ($stmt->execute([$user_id, $booking_id, $tour_id, $rating, $comment])) {
                // Đổi từ "true" thành một câu thông báo hoàn chỉnh để Popup hiển thị đẹp
                $_SESSION['review_success'] = 'Đánh giá của bạn đã được ghi nhận. Chúc bạn có thêm nhiều chuyến đi tuyệt vời!';
                header("Location: index.php?action=myBookings");
                exit();
            } else {
                echo "<script>alert('Có lỗi xảy ra khi lưu đánh giá. Vui lòng thử lại!'); history.back();</script>";
            }
        }
    }
}