<?php
require_once '../models/TourGuide.php';
$guide = new TourGuide();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'assign') {
        $guide->assign($_POST['departure_id'], $_POST['staff_id']);
        echo 'Đã phân công hướng dẫn viên.';
    }
} else {
    if (isset($_GET['departure_id'])) {
        $list = $guide->getByDeparture($_GET['departure_id']);
        echo json_encode($list);
    }
}
