<?php
require_once '../config/database.php';

$db = (new Database())->connect();

$payment_id = $_POST['payment_id'] ?? 0;

if (!$payment_id) {
    die("Thiếu payment_id");
}

// 🔥 LẤY booking_id TRƯỚC
$stmt = $db->prepare("
    SELECT booking_id FROM payments WHERE payment_id = ?
");
$stmt->execute([$payment_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Không tìm thấy payment");
}

$booking_id = $data['booking_id'];

try {
    $db->beginTransaction();

    // 1. Update payment
    $stmt = $db->prepare("
        UPDATE payments 
        SET payment_status = 'paid' 
        WHERE payment_id = ?
    ");
    $stmt->execute([$payment_id]);

    // 2. Update booking
    $stmt = $db->prepare("
        UPDATE bookings 
        SET status = 'confirmed' 
        WHERE booking_id = ?
    ");
    $stmt->execute([$booking_id]);

    $db->commit();

    // 🔥 QUAN TRỌNG: truyền booking_id
    header("Location: ../views/success.php?booking_id=$booking_id");
    exit;

} catch (Exception $e) {
    $db->rollBack();
    die("Lỗi: " . $e->getMessage());
}