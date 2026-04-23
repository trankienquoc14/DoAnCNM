<?php
require_once __DIR__ . '/../config/database.php';

class TourController
{

    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        // --- THÊM DÒNG NÀY ---
        // Mỗi khi ai đó vào web xem tour, hệ thống sẽ tự động quét và dọn dẹp ghế bị treo
        $this->autoCancelExpiredBookings();
    }

    public function home()
    {
        $stmt = $this->db->query("SELECT * FROM tours LIMIT 8");
        require __DIR__ . '/../views/home.php';
    }

    public function detail()
    {
        // Nhận ID từ URL và đảm bảo nó là số
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;

        // 1. Lấy thông tin Tour + Tên đối tác (Partner)
        $stmtTour = $this->db->prepare("SELECT t.*, p.partner_name FROM tours t LEFT JOIN partners p ON t.partner_id = p.partner_id WHERE t.tour_id = ? AND t.status = 'active'");
        $stmtTour->execute([$id]);
        $detail = $stmtTour->fetch(PDO::FETCH_ASSOC);

        // 2. Lấy lịch trình chi tiết từng ngày
        $stmtSchedule = $this->db->prepare("SELECT * FROM tour_schedules WHERE tour_id = ? ORDER BY day_number ASC");
        $stmtSchedule->execute([$id]);
        $schedules = $stmtSchedule->fetchAll(PDO::FETCH_ASSOC);

        // 3. Lấy danh sách các ngày khởi hành (chỉ lấy ngày chưa qua)
        $stmtDepartures = $this->db->prepare("SELECT * FROM departures WHERE tour_id = ? AND start_date >= CURDATE() ORDER BY start_date ASC");
        $stmtDepartures->execute([$id]);
        $departures = $stmtDepartures->fetchAll(PDO::FETCH_ASSOC);

        // Gọi view hiển thị
        require __DIR__ . '/../views/tour_detail.php';
    }

    public function tours()
    {
        $location = isset($_GET['location']) && is_string($_GET['location']) ? $_GET['location'] : '';
        $keyword = isset($_GET['keyword']) && is_string($_GET['keyword']) ? $_GET['keyword'] : '';
        $departure_date = isset($_GET['departure_date']) && is_string($_GET['departure_date']) ? $_GET['departure_date'] : '';
        $max_price = isset($_GET['max_price']) && is_scalar($_GET['max_price']) ? $_GET['max_price'] : '';
        $category = isset($_GET['cat']) && is_string($_GET['cat']) ? $_GET['cat'] : '';

        $search_term = !empty($location) ? $location : $keyword;

        // Đổi DISTINCT thành GROUP BY t.tour_id để tương thích 100% với các cột kiểu TEXT trong MariaDB
        $query = "SELECT t.* FROM tours t 
                  LEFT JOIN departures d ON t.tour_id = d.tour_id 
                  WHERE t.status = 'active'";
        $params = [];

        if (!empty($search_term)) {
            $query .= " AND (t.destination LIKE ? OR t.tour_name LIKE ?)";
            $params[] = "%$search_term%";
            $params[] = "%$search_term%";
        }

        if (!empty($max_price)) {
            $query .= " AND t.price <= ?";
            $params[] = $max_price;
        }

        if (!empty($departure_date)) {
            $query .= " AND d.start_date >= ?";
            $params[] = $departure_date;
        }

        if ($category == 'sea') {
            $query .= " AND (t.tour_name LIKE '%biển%' OR t.destination IN ('Đà Nẵng','Nha Trang','Phú Quốc'))";
        } elseif ($category == 'mountain') {
            $query .= " AND (t.tour_name LIKE '%núi%' OR t.destination IN ('Sapa','Đà Lạt'))";
        }

        // Nhóm theo ID thay vì dùng DISTINCT
        $query .= " GROUP BY t.tour_id ORDER BY t.tour_id DESC";

        // Thêm bắt lỗi SQL để không bị lỗi ngầm
        $stmt = $this->db->prepare($query);
        $isSuccess = $stmt->execute($params);

        if (!$isSuccess) {
            $errorInfo = $stmt->errorInfo();
            die("<div style='color:red; padding:20px; font-weight:bold; text-align:center;'>LỖI SQL: " . $errorInfo[2] . "</div>");
        }

        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$tours) {
            $tours = [];
        }

        require __DIR__ . '/../views/tours.php';
    }

    // THÊM HÀM MỚI Ở ĐÂY ĐỂ TRẢ VỀ JSON CHO JAVASCRIPT
    public function getDepartures()
    {
        if (ob_get_length())
            ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        $tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;

        try {
            // Chỉ lấy những ngày khởi hành chưa qua (>= hôm nay) và trạng thái là 'upcoming'
            $stmt = $this->db->prepare("SELECT * FROM departures WHERE tour_id = ? AND start_date >= CURDATE() AND status = 'upcoming' ORDER BY start_date ASC");
            $stmt->execute([$tour_id]);
            $departures = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Trả về mảng (dù rỗng cũng vẫn là JSON chuẩn [])
            echo json_encode($departures);
        } catch (Exception $e) {
            // Chỉ khi có lỗi SQL thực sự mới trả về mã lỗi 500
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
        }
        exit();
    }
    public function booking()
    {
        // --- KIỂM TRA ĐĂNG NHẬP TRƯỚC KHI XEM TRANG ---
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            echo "<script>
                    alert('Bạn cần đăng nhập để có thể đặt tour!'); 
                    window.location.href='index.php?action=login';
                  </script>";
            exit;
        }
        $tour_id = $_GET['tour_id'] ?? 0;
        $departure_id = $_GET['departure_id'] ?? 0;

        // Lấy thông tin Tour
        $stmtTour = $this->db->prepare("SELECT * FROM tours WHERE tour_id = ? AND status = 'active'");
        $stmtTour->execute([$tour_id]);
        $detail = $stmtTour->fetch(PDO::FETCH_ASSOC);

        // Lấy thông tin Lịch khởi hành
        $stmtDep = $this->db->prepare("SELECT * FROM departures WHERE departure_id = ? AND tour_id = ?");
        $stmtDep->execute([$departure_id, $tour_id]);
        $departure = $stmtDep->fetch(PDO::FETCH_ASSOC);

        // Gọi View và truyền biến $detail, $departure sang
        require __DIR__ . '/../views/booking.php';
    }
    public function confirmBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận dữ liệu từ form
            $tour_id = $_POST['tour_id'] ?? 0;
            $departure_id = $_POST['departure_id'] ?? 0;
            $customer_name = $_POST['customer_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $people = $_POST['people'] ?? 1;
            $note = $_POST['note'] ?? '';
            $payment_method = $_POST['payment_method'] ?? 'cod';

            // --- BƯỚC QUAN TRỌNG: TRỪ SỐ CHỖ TRỐNG TRƯỚC ---
            // Câu lệnh này chỉ trừ khi available_seats >= số người đặt (đảm bảo không bị âm số ghế)
            $queryUpdateSeats = "UPDATE departures 
                                 SET available_seats = available_seats - ? 
                                 WHERE departure_id = ? AND available_seats >= ?";
            $stmtUpdateSeats = $this->db->prepare($queryUpdateSeats);
            $stmtUpdateSeats->execute([$people, $departure_id, $people]);

            // Kiểm tra xem việc trừ chỗ có thành công không
            if ($stmtUpdateSeats->rowCount() === 0) {
                // Nếu rowCount = 0 nghĩa là đã hết chỗ hoặc không đủ số lượng người yêu cầu
                echo "<script>alert('Rất tiếc, chuyến đi này đã hết chỗ hoặc không còn đủ số ghế trống!'); window.history.back();</script>";
                exit;
            }
            // ------------------------------------------------

            // Lấy giá tour để tính tổng tiền
            $stmt = $this->db->prepare("SELECT price FROM tours WHERE tour_id = ?");
            $stmt->execute([$tour_id]);
            $tour = $stmt->fetch(PDO::FETCH_ASSOC);

            $total_price = ($tour['price'] ?? 0) * $people;
            $user_id = $_SESSION['user']['user_id'] ?? 1; // Mặc định ID 1 nếu chưa đăng nhập

            // 1. Lưu đơn hàng vào bảng bookings
            $query = "INSERT INTO bookings (user_id, departure_id, customer_name, email, phone, number_of_people, total_price, note, status) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
            $stmtInsert = $this->db->prepare($query);
            $stmtInsert->execute([$user_id, $departure_id, $customer_name, $email, $phone, $people, $total_price, $note]);

            // Lấy ID của booking vừa tạo
            $booking_id = $this->db->lastInsertId();

            // 2. Xử lý thanh toán vào bảng payments
            if ($payment_method === 'qr') {
                $transaction_code = "TXN" . time() . rand(100, 999);
                $queryPay = "INSERT INTO payments (booking_id, amount, payment_method, payment_status, transaction_code) VALUES (?, ?, 'qr', 'pending', ?)";
                $stmtPay = $this->db->prepare($queryPay);
                $stmtPay->execute([$booking_id, $total_price, $transaction_code]);

                $payment_id = $this->db->lastInsertId();

                // Chuyển thẳng sang trang quét mã QR!
                header("Location: index.php?action=payment&payment_id=" . $payment_id);
                exit;
            } else {
                // Nếu chọn COD
                $queryPay = "INSERT INTO payments (booking_id, amount, payment_method, payment_status) VALUES (?, ?, 'cod', 'pending')";
                $stmtPay = $this->db->prepare($queryPay);
                $stmtPay->execute([$booking_id, $total_price]);

                echo "<script>alert('Đặt tour thành công! Vui lòng thanh toán bằng tiền mặt khi đi tour.'); window.location.href='index.php?action=tours';</script>";
                exit;
            }
        }
    }
    public function myBookings()
    {
        // 1. Kiểm tra đăng nhập
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        // 2. Lấy thông tin user
        $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];
        $user_name = $_SESSION['user']['full_name'] ?? $_SESSION['user']['name'] ?? 'Khách hàng';
        $user_email = $_SESSION['user']['email'] ?? 'Chưa cập nhật email';

        // 3. Truy vấn danh sách booking từ Database
        $stmt = $this->db->prepare("
            SELECT 
                b.booking_id, b.customer_name, b.number_of_people, b.total_price, b.status, b.booking_date,
                d.start_date, d.end_date,
                t.tour_id,t.tour_name, t.image,
                p.payment_method, p.payment_status, p.payment_id
            FROM bookings b
            JOIN departures d ON b.departure_id = d.departure_id
            JOIN tours t ON d.tour_id = t.tour_id
            LEFT JOIN payments p ON b.booking_id = p.booking_id
            WHERE b.user_id = ?
            ORDER BY b.booking_id DESC
        ");
        $stmt->execute([$user_id]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalBookings = count($bookings);

        // 4. Gọi View để hiển thị
        require __DIR__ . '/../views/my_booking.php';
    }
    public function bookingDetail()
    {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        // 2. Lấy booking_id từ URL
        $booking_id = $_GET['booking_id'] ?? 0;

        // 3. Truy vấn chi tiết đơn hàng, thông tin tour và thanh toán
        $stmt = $this->db->prepare("
            SELECT b.*, d.start_date, d.end_date, t.tour_name, t.image, t.destination, t.price as unit_price,
                   p.payment_method, p.payment_status, p.transaction_code, p.payment_date
            FROM bookings b
            JOIN departures d ON b.departure_id = d.departure_id
            JOIN tours t ON d.tour_id = t.tour_id
            LEFT JOIN payments p ON b.booking_id = p.booking_id
            WHERE b.booking_id = ? AND b.user_id = ?
        ");

        $user_id = $_SESSION['user']['user_id'] ?? 1;
        $stmt->execute([$booking_id, $user_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            die("<div class='text-center mt-5'><h3>Không tìm thấy thông tin đơn hàng!</h3></div>");
        }

        // 4. Gọi View hiển thị chi tiết (Bạn cần tạo file views/booking_detail.php)
        require __DIR__ . '/../views/success.php';
    }
    // --- HÀM XỬ LÝ HỦY TOUR ---
    public function cancelBooking()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $booking_id = isset($_GET['booking_id']) ? (int) $_GET['booking_id'] : 0;
        $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];

        // 1. ĐÃ SỬA LỖI SQL Ở ĐÂY: Xóa b.payment_method đi, chỉ giữ lại p.payment_status
        $stmt = $this->db->prepare("
            SELECT b.status, p.payment_status, d.start_date 
            FROM bookings b 
            JOIN departures d ON b.departure_id = d.departure_id 
            LEFT JOIN payments p ON b.booking_id = p.booking_id
            WHERE b.booking_id = ? AND b.user_id = ?
        ");
        $stmt->execute([$booking_id, $user_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            echo "<script>alert('Không tìm thấy đơn hàng hoặc bạn không có quyền thao tác!'); window.location.href='index.php?action=myBookings';</script>";
            exit;
        }

        if ($booking['status'] === 'cancelled') {
            echo "<script>alert('Đơn hàng này đã được hủy trước đó.'); window.location.href='index.php?action=myBookings';</script>";
            exit;
        }

        // 2. Ràng buộc thời gian: Chỉ cho hủy trước 3 ngày
        $days_until_start = (strtotime($booking['start_date']) - time()) / (60 * 60 * 24);

        if ($days_until_start < 3) {
            echo "<script>
                    alert('Đã qua thời hạn tự hủy tour (chỉ được hủy trước 3 ngày khởi hành). Vui lòng liên hệ Hotline 1900 1234 để được hỗ trợ.'); 
                    window.location.href='index.php?action=myBookings';
                  </script>";
            exit;
        }

        // 3. Tiến hành Hủy đơn hàng
        // 3. Tiến hành Hủy đơn hàng
        $stmtUpdate = $this->db->prepare("UPDATE bookings SET status = 'cancelled' WHERE booking_id = ?");

        if ($stmtUpdate->execute([$booking_id])) {

            // --- BẮT ĐẦU BỔ SUNG: HOÀN LẠI SỐ GHẾ VÀO BẢNG DEPARTURES ---
            $queryRestoreSeats = "UPDATE departures 
                                  SET available_seats = available_seats + (SELECT number_of_people FROM bookings WHERE booking_id = ?) 
                                  WHERE departure_id = (SELECT departure_id FROM bookings WHERE booking_id = ?)";
            $stmtRestore = $this->db->prepare($queryRestoreSeats);
            $stmtRestore->execute([$booking_id, $booking_id]);
            // --- KẾT THÚC BỔ SUNG ---

            // Nếu khách đã thanh toán, thông báo thêm vụ hoàn tiền
            if (isset($booking['payment_status']) && $booking['payment_status'] === 'paid') {
                echo "<script>alert('Hủy tour thành công. Vì bạn đã thanh toán, nhân viên sẽ liên hệ để hoàn tiền trong 3-5 ngày làm việc.'); window.location.href='index.php?action=myBookings';</script>";
            } else {
                echo "<script>alert('Hủy tour thành công.'); window.location.href='index.php?action=myBookings';</script>";
            }
        } else {
            echo "<script>alert('Có lỗi hệ thống, vui lòng thử lại sau.'); window.location.href='index.php?action=myBookings';</script>";
        }
    }
    // --- HÀM TỰ ĐỘNG HỦY ĐƠN VÀ HOÀN GHẾ SAU 15 PHÚT ---
    private function autoCancelExpiredBookings()
    {
        // 1. Tìm các booking 'pending' đã qua 15 phút (chỉ áp dụng cho thanh toán QR đang chờ)
        // Lưu ý: Cột booking_date trong DB của bạn phải là kiểu DATETIME hoặc TIMESTAMP
        $query = "SELECT b.booking_id, b.departure_id, b.number_of_people 
                  FROM bookings b
                  JOIN payments p ON b.booking_id = p.booking_id
                  WHERE b.status = 'pending' 
                  AND p.payment_method = 'qr' 
                  AND p.payment_status = 'pending'
                  AND b.booking_date <= (NOW() - INTERVAL 5 MINUTE)";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $expiredBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Chạy vòng lặp để hủy và hoàn ghế cho từng đơn
        foreach ($expiredBookings as $b) {
            // Hoàn lại ghế vào bảng departures
            $stmtRestore = $this->db->prepare("UPDATE departures SET available_seats = available_seats + ? WHERE departure_id = ?");
            $stmtRestore->execute([$b['number_of_people'], $b['departure_id']]);

            // Đổi trạng thái booking thành cancelled
            $stmtCancelB = $this->db->prepare("UPDATE bookings SET status = 'cancelled', note = CONCAT(IFNULL(note,''), 'Đã hủy do hết thời gian thanh toán') WHERE booking_id = ?");
            $stmtCancelB->execute([$b['booking_id']]);

            // Đổi trạng thái payment thành cancelled
            $stmtCancelP = $this->db->prepare("UPDATE payments SET payment_status = 'failed' WHERE booking_id = ?");
            $stmtCancelP->execute([$b['booking_id']]);
        }
    }

}