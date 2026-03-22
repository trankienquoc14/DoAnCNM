<?php
require_once __DIR__ . '/../controllers/ManagerController.php';

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

    case 'cancelBooking':
        $controller->cancelBooking();
        break;

    case 'refundBooking':
        $controller->refundBooking();
        break;
    case 'report':
        $controller->report();
        break;

    default:
        echo "404";
}