<?php
require_once __DIR__ . '/../config/database.php';

class AuthController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        // Đảm bảo session luôn được bật
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Thiếu thông tin đăng nhập";
            } else {
                // Kiểm tra email trong CSDL
                $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$data) {
                    $error = "Email không tồn tại";
                } else {
                    // Hỗ trợ kiểm tra cả mật khẩu Bcrypt mới và MD5 cũ trong CSDL của bạn
                    $isPasswordCorrect = false;
                    if (password_verify($password, $data['password'])) {
                        $isPasswordCorrect = true;
                    } elseif (md5($password) === $data['password']) {
                        $isPasswordCorrect = true;
                    }

                    if ($isPasswordCorrect) {
                        // Lưu session chuẩn khớp với các biến mà file booking.php đang gọi
                        $_SESSION['user'] = [
                            'user_id' => $data['user_id'],
                            'full_name' => $data['full_name'],
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            'role' => $data['role']
                        ];
                        
                        // Đăng nhập xong -> Chuyển hướng qua index.php
                        header("Location: index.php?action=home");
                        exit();
                    } else {
                        $error = "Sai mật khẩu";
                    }
                }
            }
        }

        // Gọi View để hiển thị form (truyền luôn biến $error sang nếu có lỗi)
        require __DIR__ . '/../views/login.php';
    }

    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ";
            } elseif (strlen($password) < 6) {
                $error = "Mật khẩu phải từ 6 ký tự trở lên";
            } else {
                // Kiểm tra email đã tồn tại chưa
                $stmtCheck = $this->db->prepare("SELECT user_id FROM users WHERE email = ?");
                $stmtCheck->execute([$email]);
                
                if ($stmtCheck->rowCount() > 0) {
                    $error = "Email này đã được đăng ký!";
                } else {
                    // Mã hóa mật khẩu chuẩn Bcrypt và lưu vào DB
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $this->db->prepare("INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, 'customer')");
                    $isSuccess = $stmt->execute([$name, $email, $phone, $hashed_password]);

                    if ($isSuccess) {
                        echo "<script>alert('Đăng ký thành công! Mời bạn đăng nhập.'); window.location.href='index.php?action=login';</script>";
                        exit();
                    } else {
                        $error = "Đăng ký thất bại, vui lòng thử lại.";
                    }
                }
            }
        }

        // Nếu bạn đã làm form views/register.php thì mở comment dòng dưới này ra:
        require __DIR__ . '/../views/register.php'; 
    }

    public function logout()
    {
        session_destroy(); // Xóa toàn bộ dữ liệu đăng nhập
        header("Location: index.php?action=login");
        exit();
    }
    // 1. Hàm hiển thị giao diện Profile
    public function profile()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];

        // Lấy thông tin user
        $stmt = $this->db->prepare("SELECT full_name, email, phone, password FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $user_name = $user['full_name'] ?? 'Khách hàng';
        $user_email = $user['email'] ?? 'Chưa cập nhật email';
        $user_phone = $user['phone'] ?? '';

        // Đếm số đơn
        $stmt_count = $this->db->prepare("SELECT COUNT(*) as total FROM bookings WHERE user_id = ?");
        $stmt_count->execute([$user_id]);
        $totalBookings = $stmt_count->fetchColumn();

        require __DIR__ . '/../views/profile.php';
    }

    // 2. Hàm xử lý Cập nhật thông tin cá nhân
    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];
            $full_name = trim($_POST['full_name']);
            $phone = trim($_POST['phone']);

            $stmt = $this->db->prepare("UPDATE users SET full_name = ?, phone = ? WHERE user_id = ?");
            $stmt->execute([$full_name, $phone, $user_id]);

            // Cập nhật lại session để Menu header đổi tên theo
            $_SESSION['user']['full_name'] = $full_name;

            echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='index.php?action=profile';</script>";
        }
    }

    // 3. Hàm xử lý Đổi mật khẩu
    public function updatePassword()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'];
            $old_pass = $_POST['old_password'];
            $new_pass = $_POST['new_password'];
            $confirm_pass = $_POST['confirm_password'];

            if ($new_pass !== $confirm_pass) {
                echo "<script>alert('Mật khẩu xác nhận không khớp!'); window.location.href='index.php?action=profile';</script>";
                exit;
            }

            $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra mật khẩu cũ có đúng không
            if (password_verify($old_pass, $user['password'])) {
                $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                $stmtUpdate = $this->db->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $stmtUpdate->execute([$hashed, $user_id]);
                echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='index.php?action=profile';</script>";
            } else {
                echo "<script>alert('Mật khẩu cũ không chính xác!'); window.location.href='index.php?action=profile';</script>";
            }
        }
    }
}