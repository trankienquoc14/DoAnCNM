<?php
require_once '../models/TourSchedule.php';
$schedule = new TourSchedule();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $schedule->create($_POST);
        echo 'Đã thêm lịch trình tour.';
    }
} else {
    if (isset($_GET['tour_id'])) {
        $list = $schedule->getByTour($_GET['tour_id']);
        echo json_encode($list);
    }
}
