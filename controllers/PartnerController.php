<?php
require_once '../models/Partner.php';
$partner = new Partner();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $partner->create($_POST);
        echo 'Đã thêm đối tác mới.';
    } elseif ($_POST['action'] === 'update') {
        $partner->update($_POST['partner_id'], $_POST);
        echo 'Đã cập nhật đối tác.';
    } elseif ($_POST['action'] === 'delete') {
        $partner->delete($_POST['partner_id']);
        echo 'Đã xóa đối tác.';
    }
} else {
    $list = $partner->getAll();
    echo json_encode($list);
}
