<?php
require_once '../models/Review.php';
$review = new Review();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $review->create($_POST);
        echo 'Đã thêm đánh giá.';
    }
} else {
    if (isset($_GET['tour_id'])) {
        $list = $review->getByTour($_GET['tour_id']);
        echo json_encode($list);
    } else {
        $list = $review->getAll();
        echo json_encode($list);
    }
}
