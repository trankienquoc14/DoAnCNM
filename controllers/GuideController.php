<?php
require_once __DIR__ . '/../config/database.php';

class GuideController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();

        // Kiểm tra session an toàn để tránh lỗi Notice
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'guide') {
            header("Location: ../views/login.php");
            exit();
        }
    }

    // ================= LỊCH CÔNG TÁC =================
    public function schedule()
    {
        // Khắc phục triệt để lỗi thiếu key 'user_id' hay 'id'
        $guide_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? 0;

        if ($guide_id == 0) {
            die("Lỗi: Không tìm thấy ID Hướng dẫn viên trong Session.");
        }

        // ĐÃ SỬA LỖI DATABASE Ở ĐÂY: Sử dụng bảng trung gian `departure_guides` (dg)
        $stmt = $this->db->prepare("
            SELECT d.*, t.tour_name
            FROM departures d
            JOIN tours t ON d.tour_id = t.tour_id
            JOIN departure_guides dg ON d.departure_id = dg.departure_id
            WHERE dg.guide_id = ?
            ORDER BY d.start_date ASC
        ");
        $stmt->execute([$guide_id]);
        $departures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/guide/schedule.php';
    }

    // ================= XEM CHI TIẾT ĐOÀN =================
    public function viewDeparture()
    {
        $id = $_GET['id'] ?? 0;

        // Lấy thông tin Tour và Lịch trình khởi hành
        $stmt = $this->db->prepare("
            SELECT d.*, t.* FROM departures d
            JOIN tours t ON d.tour_id = t.tour_id
            WHERE d.departure_id = ?
        ");
        $stmt->execute([$id]);
        $departure = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lấy danh sách khách hàng
        // SQL FIXED: Lấy những người có trạng thái hợp lệ để đi tour
        $stmt = $this->db->prepare("
            SELECT * FROM bookings
            WHERE departure_id = ? 
            AND (status = 'confirmed') 
            ORDER BY status DESC
        ");
        $stmt->execute([$id]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/guide/view_departure.php';
    }

    // ================= CHECK-IN (ĐIỂM DANH) =================
    public function checkin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'];

            // Vì trong SQL của bạn chưa có giá trị 'checked_in', 
            // mình tạm chuyển sang 'completed' để dữ liệu được lưu thật.
            $stmt = $this->db->prepare("
                UPDATE bookings 
                SET status = 'checked_in'
                WHERE booking_id = ?
            ");

            if ($stmt->execute([$booking_id])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
    // ================= UPDATE TRẠNG THÁI TOUR =================
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $departure_id = $_POST['departure_id'];
            $status = $_POST['status'];

            // 1. Cập nhật trạng thái Tour trong Database
            $stmt = $this->db->prepare("UPDATE departures SET status = ? WHERE departure_id = ?");
            $stmt->execute([$status, $departure_id]);

            // 2. Nếu HDV chọn trạng thái là 'completed' (Đã hoàn thành)
            if ($status === 'completed') {
                // Tự động chuyển trạng thái những khách đã đi (checked_in) sang 'completed' để khách được đánh giá
                $stmtBooking = $this->db->prepare("
                UPDATE bookings 
                SET status = 'completed' 
                WHERE departure_id = ? AND status = 'checked_in'
            ");
                $stmtBooking->execute([$departure_id]);

                // TẠO TÍN HIỆU ĐỂ HIỆN THÔNG BÁO Ở VIEW
                $_SESSION['show_complete_alert'] = true;
            }

            // Điều hướng quay lại trang chi tiết đoàn
            header("Location: guide.php?action=viewDeparture&id=" . $departure_id);
            exit();
        }
    }
}
?>