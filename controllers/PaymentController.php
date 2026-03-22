<?php
require_once __DIR__ . '/../config/database.php';

class PaymentController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    // Hàm tạo mã QR của bạn (Giữ nguyên vì rất chuẩn)
    public function createQR($amount, $info)
    {
        $bank = "MB"; // Tên viết tắt của ngân hàng hoặc BIN (MB Bank)
        $account = "8609012004009"; 
        $name = "CONG TY DU LICH TRAVELVN";

        $qr_url = "https://img.vietqr.io/image/"
            . $bank . "-" . $account . "-compact2.png"
            . "?amount=" . $amount
            . "&addInfo=" . urlencode($info)
            . "&accountName=" . urlencode($name)
            . "&t=" . time(); // 🔥 thêm dòng này để tránh cache ảnh QR

        return $qr_url;
    }

    // Hàm hiển thị trang thanh toán đã được nâng cấp!
    public function payment()
    {
        // 1. Nhận ID từ URL
        $payment_id = isset($_GET['payment_id']) ? (int)$_GET['payment_id'] : 0;
        $booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;

        // 2. CHÌA KHÓA Ở ĐÂY: Nếu payment_id = 0 nhưng có booking_id, ta đi tìm payment_id trong CSDL!
        if ($payment_id === 0 && $booking_id > 0) {
            $stmtFind = $this->db->prepare("SELECT payment_id FROM payments WHERE booking_id = ? LIMIT 1");
            $stmtFind->execute([$booking_id]);
            $row = $stmtFind->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $payment_id = $row['payment_id'];
            }
        }

        // Nếu tìm mọi cách vẫn bằng 0 thì mới báo lỗi
        if ($payment_id === 0) {
            die("<div class='text-center mt-5' style='font-family: Arial;'><h3>Thiếu thông tin thanh toán!</h3><a href='index.php?action=myBookings'>Quay lại đơn của tôi</a></div>");
        }

        // 3. Lấy thông tin thanh toán, tên khách hàng và tên Tour
        $stmt = $this->db->prepare("
            SELECT p.*, b.customer_name, t.tour_name
            FROM payments p
            JOIN bookings b ON p.booking_id = b.booking_id
            JOIN departures d ON b.departure_id = d.departure_id
            JOIN tours t ON d.tour_id = t.tour_id
            WHERE p.payment_id = ?
        ");

        $stmt->execute([$payment_id]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$payment) {
            die("<div class='text-center mt-5' style='font-family: Arial;'><h3>Không tìm thấy giao dịch thanh toán</h3><a href='index.php?action=myBookings'>Quay lại</a></div>");
        }

        // 4. Chuẩn bị dữ liệu cho View
        $amount = (int) $payment['amount'];
        $info = "THANHTOAN " . $payment_id;
        
        // 👇 THÊM DÒNG NÀY VÀO ĐỂ KHÔNG BỊ LỖI UNDEFINED VARIABLE
        $account_no = "8609012004009"; 
        
        // Gọi hàm createQR ở ngay trên để sinh link ảnh
        $qr_url = $this->createQR($amount, $info);

        // Gọi View hiển thị
        require __DIR__ . '/../views/payment.php';
        

    }

    public function confirmPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payment_id = $_POST['payment_id'] ?? 0;

            if ($payment_id) {
                // Khi khách bấm xác nhận chuyển khoản, ta đổi payment_status thành 'paid'
                $stmt = $this->db->prepare("UPDATE payments SET payment_status = 'paid' WHERE payment_id = ?");
                $stmt->execute([$payment_id]);
            }

            echo "<script>
                alert('Cảm ơn bạn! Hệ thống đã ghi nhận thông tin chuyển khoản.'); 
                window.location.href='index.php?action=myBookings';
            </script>";
            exit;
        }
    }
}