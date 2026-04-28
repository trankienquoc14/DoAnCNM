<?php
session_start();
$allowedRoles = ['admin', 'tour_manager', 'guide'];
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], $allowedRoles)) {
    die("Bạn không có quyền truy cập vào khu vực hỗ trợ khách hàng.");
}

require_once "../controllers/AdminController.php";
// 🔥 NHÚNG THÊM ChatController
require_once "../controllers/ChatController.php";

$controller = new AdminController();
// 🔥 KHỞI TẠO ChatController
$chatController = new ChatController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'toggle':
        $controller->toggle();
        break;
    case 'reset':
        $controller->reset();
        break;

    // =======================================================
    // 🔥 CÁC CASE DÀNH CHO CHAT (SỬA Ở ĐÂY)
    // =======================================================
    case 'chat':
        $controller->chat(); // Gọi hàm chat() trong AdminController để hiện giao diện
        break;

    case 'getSessions':
        $chatController->getSessions();
        break;

    case 'getHistory':
        $chatController->getHistory();
        break;

    case 'sendMessage':
        $chatController->sendMessage();
        break;
    // =======================================================
    case 'deleteSession':
        $chatController->deleteSession();
        break;
    
    default:
        $controller->index();
}