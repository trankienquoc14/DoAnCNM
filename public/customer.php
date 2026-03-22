<?php
require_once '../controllers/TourController.php';

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'tours':
        (new TourController())->index();
        break;

    case 'getDepartures':
        (new TourController())->getDepartures();
        break;
}
?>