<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';
class PaymentController
{
    private $db;
    // --- CẤU HÌNH SEPAY ---
    private $sepayToken = "_";
    private $accountNumber = "050134910132";

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    // Hàm tạo mã QR (Đã chỉnh sang Sacombank để SePay dễ quét)
    public function createQR($amount, $info)
    {
        $bank = "Sacombank"; // Đổi thành Sacombank cho khớp với tài khoản bạn đã kết nối
        $account = $this->accountNumber;
        $name = "CONG TY DU LICH TRAVELVN";

        $qr_url = "https://img.vietqr.io/image/"
            . $bank . "-" . $account . "-compact2.png"
            . "?amount=" . $amount
            . "&addInfo=" . urlencode($info)
            . "&accountName=" . urlencode($name)
            . "&t=" . time();

        return $qr_url;
    }

    public function payment()
    {
        $hash_id = $_GET['payment_id'] ?? '';
        $payment_id = decode_id($hash_id);

        $booking_hash = $_GET['booking_id'] ?? '';
        $booking_id = !empty($booking_hash) ? decode_id($booking_hash) : 0;
        // --------------------------------------

        if ($payment_id === 0 && $booking_id > 0) {
            $stmtFind = $this->db->prepare("SELECT payment_id FROM payments WHERE booking_id = ? LIMIT 1");
            $stmtFind->execute([$booking_id]);
            $row = $stmtFind->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $payment_id = $row['payment_id'];
            }
        }

        if ($payment_id === 0) {
            die("<div class='text-center mt-5'><h3>Thiếu thông tin thanh toán!</h3></div>");
        }

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
            die("Không tìm thấy giao dịch");
        }

        $amount = (int) $payment['amount'];
        $info = "THANHTOAN " . $payment_id;
        $qr_url = $this->createQR($amount, $info);
        $account_no = $this->accountNumber;

        require __DIR__ . '/../views/payment.php';
    }

    // --- ĐÂY LÀ HÀM QUAN TRỌNG NHẤT: THAY THẾ WEBHOOK ---
    public function checkPaymentStatus()
    {
        header('Content-Type: application/json');

        // --- ĐÃ SỬA: Nhận mã băm và giải mã về số ---
        $hash_id = $_GET['payment_id'] ?? '';
        $payment_id = decode_id($hash_id);

        if ($payment_id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid Payment ID"]);
            exit;
        }

        // 1. Gọi API SePay
        $url = "https://my.sepay.vn/userapi/transactions/list?account_number=" . $this->accountNumber;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->sepayToken,
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Nếu kết nối thất bại hoàn toàn (Lỗi 0)
        if ($response === false) {
            $error_msg = curl_error($ch); // Lấy tin nhắn lỗi thật
            echo json_encode(["status" => "error", "message" => "Curl Error: " . $error_msg]);
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // --- BƯỚC DEBUG: Nếu bạn muốn xem API SePay trả về gì, hãy tạm thời bỏ comment dòng dưới
        // die($response); 

        $result = json_decode($response, true);

        // Kiểm tra nếu Token sai hoặc hết hạn
        if ($httpCode !== 200) {
            echo json_encode(["status" => "error", "message" => "API Error: " . $httpCode]);
            exit;
        }

        $is_paid = false;
        if (isset($result['transactions'])) {
            foreach ($result['transactions'] as $trans) {
                // SePay v2 thường dùng key 'content' cho nội dung chuyển khoản
                $content = strtoupper($trans['content'] ?? $trans['transaction_content'] ?? '');

                // Tìm mã THANHTOAN36 (không quan tâm dấu cách)
                $search = "THANHTOAN" . $payment_id;
                $cleanContent = str_replace(' ', '', $content);

                if (strpos($cleanContent, $search) !== false) {
                    $is_paid = true;
                    break;
                }
            }
        }

        if ($is_paid) {
            // Cập nhật Database
            $stmt = $this->db->prepare("UPDATE payments SET payment_status = 'paid' WHERE payment_id = ?");
            $stmt->execute([$payment_id]);

            $stmtPay = $this->db->prepare("SELECT booking_id FROM payments WHERE payment_id = ?");
            $stmtPay->execute([$payment_id]);
            $payData = $stmtPay->fetch(PDO::FETCH_ASSOC);

            if ($payData) {
                $this->db->prepare("UPDATE bookings SET status = 'confirmed' WHERE booking_id = ?")
                    ->execute([$payData['booking_id']]);
                // === BẮT ĐẦU: GỬI THÔNG BÁO PUSHER ===
                try {
                    $options = array(
                        'cluster' => 'ap1',
                        'useTLS' => true
                    );

                    // THAY 3 MÃ CỦA BẠN VÀO ĐÂY
                    $pusher = new Pusher\Pusher(
                        'dfb02b6665ceae1b4add',
                        '8897f5d7c596c6ca98eb',
                        '2146792',
                        $options
                    );

                    // Lấy tên khách hàng để thông báo cho sinh động (nếu DB có trường này)
                    $customerName = "một khách hàng";

                    $data['message'] = "💰 Ting ting! Khách hàng vừa chuyển khoản thành công đơn #" . $payData['booking_id'];

                    // Phát sóng sự kiện 'new-booking' lên kênh 'admin-channel'
                    $pusher->trigger('admin-channel', 'new-booking', $data);
                } catch (Exception $e) {
                    error_log("Lỗi Pusher: " . $e->getMessage());
                }
                // === KẾT THÚC: GỬI THÔNG BÁO PUSHER ===
            }
            echo json_encode(["status" => "paid"]);
        } else {
            // Nếu chưa thấy tiền, trả về pending để JS tiếp tục đợi
            echo json_encode(["status" => "pending"]);
        }
        exit;
    }
}