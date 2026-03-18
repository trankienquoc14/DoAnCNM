<?php
require_once '../models/Departure.php';
$departure = new Departure();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $departure->create($_POST);
        echo 'Đã thêm lịch khởi hành.';
    } elseif ($_POST['action'] === 'update') {
        $departure->update($_POST['departure_id'], $_POST);
        echo 'Đã cập nhật lịch khởi hành.';
    } elseif ($_POST['action'] === 'delete') {
        $departure->delete($_POST['departure_id']);
        echo 'Đã xóa lịch khởi hành.';
    }
} else {
    $list = $departure->getAll();
    echo json_encode($list);
}
