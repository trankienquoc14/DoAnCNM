<?php
require_once '../models/Notification.php';
$notification = new Notification();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $notification->create($_POST);
        echo 'Đã thêm thông báo.';
    } elseif ($_POST['action'] === 'mark_read') {
        $notification->markRead($_POST['notification_id']);
        echo 'Đã đánh dấu đã đọc.';
    }
} else {
    if (isset($_GET['user_id'])) {
        $list = $notification->getByUser($_GET['user_id']);
        echo json_encode($list);
    }
}
