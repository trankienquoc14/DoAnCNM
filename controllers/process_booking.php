<?php
session_start();

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    echo "<script>
        alert('Vui lòng đăng nhập trước khi đặt tour');
        window.location.href = '../views/login.php';
    </script>";
    exit;
}

require_once '../config/database.php';

$db = (new Database())->connect();

// 2. Chỉ cho phép POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Truy cập không hợp lệ");
}

// 3. Lấy dữ liệu
$departure_id = $_POST['departure_id'] ?? null;
$name = $_POST['customer_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$people = $_POST['people'] ?? 1;
$note = $_POST['note'] ?? '';
$method = $_POST['payment_method'] ?? 'cash';

// ⚠️ QUAN TRỌNG: lấy đúng key session
$user_id = $_SESSION['user']['id'];

// 4. Validate
if (!$user_id) {
    die("Lỗi user");
}

if (!$departure_id || !$name || !$email || !$phone) {
    die("Thiếu thông tin đặt tour");
}

if ($people <= 0) {
    die("Số người không hợp lệ");
}

try {
    $db->beginTransaction();

    // 5. Lấy giá tour từ DB (KHÔNG lấy từ form)
    $stmt = $db->prepare("
        SELECT t.price, d.available_seats
        FROM tours t
        JOIN departures d ON t.tour_id = d.tour_id
        WHERE d.departure_id = ?
        FOR UPDATE
    ");
    $stmt->execute([$departure_id]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tour) {
        throw new Exception("Không tìm thấy tour");
    }

    // 6. Kiểm tra chỗ
    if ($tour['available_seats'] < $people) {
        throw new Exception("Không đủ chỗ");
    }

    // 7. Tính tiền (CHUẨN)
    $price = $tour['price'];
    $total_price = $price * $people;

    // 8. Tạo booking
    $stmt = $db->prepare("
        INSERT INTO bookings 
        (user_id, departure_id, customer_name, email, phone, number_of_people, total_price, note, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $user_id,
        $departure_id,
        $name,
        $email,
        $phone,
        $people,
        $total_price,
        $note
    ]);

    $booking_id = $db->lastInsertId();

    // 9. Trừ ghế
    $stmt = $db->prepare("
        UPDATE departures 
        SET available_seats = available_seats - ?
        WHERE departure_id = ?
    ");
    $stmt->execute([$people, $departure_id]);

    // 10. Tạo payment
    $stmt = $db->prepare("
        INSERT INTO payments (booking_id, amount, payment_method, payment_status)
        VALUES (?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $booking_id,
        $total_price,
        $method
    ]);

    $payment_id = $db->lastInsertId();

    $db->commit();

    // 11. Điều hướng
    if ($method == 'qr') {
        header("Location: ../views/payment_qr.php?payment_id=$payment_id");
    } else {
        header("Location: ../views/success.php?booking_id=$booking_id");
    }
    exit;

} catch (Exception $e) {
    $db->rollBack();
    die("Lỗi: " . $e->getMessage());
}