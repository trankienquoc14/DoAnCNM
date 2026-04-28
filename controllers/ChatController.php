<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

class ChatController
{
    private $db;
    private $pusher;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $this->pusher = new Pusher\Pusher(
            'dfb02b6665ceae1b4add',
            '8897f5d7c596c6ca98eb',
            '2146792',
            $options
        );
    }

    // 1. Gửi tin nhắn (Cần thêm departure_id để lọc cho HDV)
    public function sendMessage()
    {
        header('Content-Type: application/json');
        $message = $_POST['message'] ?? '';
        $senderType = $_SESSION['user']['role'] ?? 'customer';
        $senderName = $_SESSION['user']['full_name'] ?? 'Khách vãng lai';
        $departureId = $_POST['departure_id'] ?? null;

        // --- SỬA LOGIC TẠI ĐÂY: Phân biệt Khách và Nhân viên ---
        if ($senderType === 'customer') {
            // Nếu là KHÁCH: Tự lấy ID của mình
            if (isset($_SESSION['user']['user_id'])) {
                $sessionId = 'user_' . $_SESSION['user']['user_id'];
            } else {
                if (!isset($_SESSION['chat_session_id'])) {
                    $_SESSION['chat_session_id'] = uniqid('chat_');
                }
                $sessionId = $_SESSION['chat_session_id'];
            }
        } else {
            // Nếu là ADMIN / MANAGER / GUIDE: Bắt buộc lấy session_id do giao diện truyền lên
            $sessionId = $_POST['session_id'] ?? '';
        }
        // -------------------------

        if (!empty($message) && !empty($sessionId)) {
            $stmt = $this->db->prepare("INSERT INTO chat_messages (session_id, sender_type, sender_name, message, departure_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$sessionId, $senderType, $senderName, $message, $departureId]);

            $data = [
                'session_id' => $sessionId,
                'sender_type' => $senderType,
                'sender_name' => $senderName,
                'departure_id' => $departureId,
                'message' => htmlspecialchars($message),
                'time' => date('H:i')
            ];

            $this->pusher->trigger('live-chat', 'new-message', $data);
            echo json_encode(['status' => 'success']);
        }
        exit;
    }

    // 2. Lấy danh sách phiên chat (PHÂN QUYỀN TẠI ĐÂY)
    // 2. Lấy danh sách phiên chat (PHÂN QUYỀN VÀ SỬA LỖI TÊN HIỂN THỊ)
    public function getSessions()
    {
        header('Content-Type: application/json');
        $role = $_SESSION['user']['role'] ?? '';
        $userId = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? 0;

        if ($role === 'admin' || $role === 'tour_manager') {
            // SỬA SQL: Lấy sender_name của tin nhắn ĐẦU TIÊN trong session đó
            $sql = "SELECT 
                        m1.session_id, 
                        (SELECT sender_name FROM chat_messages WHERE session_id = m1.session_id ORDER BY message_id ASC LIMIT 1) AS sender_name, 
                        m1.message, 
                        m1.created_at 
                    FROM chat_messages m1
                    JOIN (SELECT MAX(message_id) as last_id FROM chat_messages GROUP BY session_id) m2 
                    ON m1.message_id = m2.last_id
                    ORDER BY m1.created_at DESC";
            $stmt = $this->db->query($sql);

        } else if ($role === 'guide') {
            // SỬA SQL TƯƠNG TỰ CHO HDV
            $sql = "SELECT 
                        m1.session_id, 
                        (SELECT sender_name FROM chat_messages WHERE session_id = m1.session_id ORDER BY message_id ASC LIMIT 1) AS sender_name, 
                        m1.message, 
                        m1.created_at 
                    FROM chat_messages m1
                    JOIN (SELECT MAX(message_id) as last_id FROM chat_messages GROUP BY session_id) m2 ON m1.message_id = m2.last_id
                    JOIN departure_guides dg ON m1.departure_id = dg.departure_id
                    WHERE dg.guide_id = ?
                    ORDER BY m1.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId]);
        } else {
            echo json_encode([]);
            exit;
        }

        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // 3. Lấy lịch sử tin nhắn
    public function getHistory()
    {
        header('Content-Type: application/json');
        $role = $_SESSION['user']['role'] ?? 'customer';

        // --- SỬA LOGIC TẠI ĐÂY ---
        if ($role === 'customer') {
            // Khách tự xem lịch sử của mình
            if (isset($_SESSION['user']['user_id'])) {
                $sessionId = 'user_' . $_SESSION['user']['user_id'];
            } else {
                $sessionId = $_SESSION['chat_session_id'] ?? '';
            }
        } else {
            // Nhân viên xem lịch sử của khách (Lấy từ tham số URL)
            $sessionId = $_GET['session_id'] ?? '';
        }

        if (empty($sessionId)) {
            echo json_encode([]);
            exit;
        }

        $stmt = $this->db->prepare("SELECT * FROM chat_messages WHERE session_id = ? ORDER BY created_at ASC");
        $stmt->execute([$sessionId]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }
    // Xóa toàn bộ lịch sử của một cuộc trò chuyện
    public function deleteSession()
    {
        header('Content-Type: application/json');
        $sessionId = $_POST['session_id'] ?? '';

        if (!empty($sessionId)) {
            $stmt = $this->db->prepare("DELETE FROM chat_messages WHERE session_id = ?");
            if ($stmt->execute([$sessionId])) {
                echo json_encode(['status' => 'success']);
                exit;
            }
        }
        echo json_encode(['status' => 'error']);
        exit;
    }
    
}