<?php
require_once __DIR__ . '/../controllers/ManagerController.php';
require_once '../config/helpers.php';
$controller = new ManagerController();

$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'dashboard':
        $controller->dashboard();
        break;

    case 'tours':
        $controller->tours();
        break;

    case 'createTour':
        $controller->createTour();
        break;

    case 'storeTour':
        $controller->storeTour();
        break;

    case 'editTour':
        $controller->editTour();
        break;

    case 'updateTour':
        $controller->updateTour();
        break;

    case 'deleteTour':
        $controller->deleteTour();
        break;

    case 'partners':
        $controller->partners();
        break;

    case 'createPartner':
        $controller->createPartner();
        break;

    case 'storePartner':
        $controller->storePartner();
        break;

    case 'editPartner':
        $controller->editPartner();
        break;

    case 'updatePartner':
        $controller->updatePartner();
        break;

    case 'deletePartner':
        $controller->deletePartner();
        break;

    case 'departures':
        $controller->departures();
        break;

    case 'createDeparture':
        $controller->createDeparture();
        break;

    case 'storeDeparture':
        $controller->storeDeparture();
        break;

    case 'editDeparture':
        $controller->editDeparture();
        break;

    case 'updateDeparture':
        $controller->updateDeparture();
        break;

    case 'deleteDeparture':
        $controller->deleteDeparture();
        break;

    case 'bookings':
        $controller->bookings();
        break;

    case 'bookingDetail':
        $controller->bookingDetail();
        break;

    case 'confirmBooking':
        $controller->confirmBooking();
        break;

    // 🔥 ĐÂY CHÍNH LÀ ĐOẠN BẠN CẦN THÊM VÀO 🔥
    case 'confirmCash':
        $controller->confirmCash();
        break;

    case 'cancelBooking':
        $controller->cancelBooking();
        break;

    case 'refundBooking':
        $controller->refundBooking();
        break;

    case 'report':
        $controller->report();
        break;

    // ================= QUẢN LÝ BÀI VIẾT (CẨM NANG) =================
    case 'blogs':
        $controller->blogs();
        break;

    case 'blogForm':
        $controller->blogForm();
        break;

    case 'saveBlog':
        $controller->saveBlog();
        break;

    case 'deleteBlog':
        $controller->deleteBlog();
        break;
    case 'chat':
        // Gọi hàm chat() trong ManagerController để hiện giao diện Messenger
        // Bạn cần thêm hàm chat() vào ManagerController tương tự AdminController
        $controller->chat();
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
    case 'deleteSession':
        $chatController->deleteSession();
        break;
    
    default:
        // Thay vì chỉ in 404, bạn có thể in ra action bị lỗi để dễ fix bug hơn
        echo "<h2 style='text-align:center; margin-top:50px;'>Lỗi 404: Không tìm thấy action '{$action}'</h2>";
}