<?php
require_once __DIR__ . '/../controllers/GuideController.php';

$controller = new GuideController();

$action = $_GET['action'] ?? 'schedule';

switch ($action) {
    case 'schedule':
        $controller->schedule();
        break;

    case 'viewDeparture':
        $controller->viewDeparture();
        break;

    case 'checkin':
        $controller->checkin();
        break;

    case 'updateStatus':
        $controller->updateStatus();
        break;

    default:
        echo "404 Not Found";
}